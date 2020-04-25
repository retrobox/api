<?php

namespace App\Controllers;

use App\Auth\Session;
use App\Models\User;
use App\Utils\AcceptLanguage;
use App\Utils\WebSocketServerClient;
use Carbon\Carbon;
use Exception;
use Faker\Provider\Uuid;
use Firebase\JWT\JWT;
use Monolog\Logger;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use STAILEUAccounts\Client;
use Validator\Validator;

class AccountController extends Controller
{
    public function getLogin(Response $response, Client $STAILEUAccounts)
    {
        $url = $STAILEUAccounts->getAuthorizeUrl(
            $this->container->get('staileu')['redirect'],
            [Client::SCOPE_READ_PROFILE, Client::SCOPE_READ_EMAIL]
        );
        return $response->withJson([
            'success' => true,
            'data' => ['url' => $url]
        ]);
    }

    public function execute(ServerRequestInterface $request, Response $response, Client $STAILEUAccounts, Session $session)
    {
        $this->loadDatabase();
        $validator = new Validator($request->getParsedBody());
        $validator->required('code');
        $validator->notEmpty('code');
        if (!$validator->isValid())
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ], 400);

        // validate the token with staileu
        if (!$STAILEUAccounts->verify($validator->getValue('code')))
            return $response->withJson([
                'success' => false,
                'errors' => [
                    ['message' => 'Invalid STAIL.EU code']
                ]
            ], 400);
        // check if the user exist
        $STAILEUAccounts->fetchUser();
        $user = User::query()->find($STAILEUAccounts->getUser()->id);
        if ($user == NULL) {
            // create the user
            $user = new User();
            $user['id'] = $STAILEUAccounts->getUser()->id;
        }
        $username = $STAILEUAccounts->getUser()->username;
        $email = $STAILEUAccounts->getUser()->email;
        $avatar = $STAILEUAccounts->getUser()->avatarUrl;
        $user['last_login_at'] = Carbon::now();
        $user['last_user_agent'] = $request->getServerParams()['HTTP_USER_AGENT'];
        $user['last_ip'] = $request->getAttribute('ip_address');
        $user['last_avatar'] = $avatar;
        $user['last_email'] = $email;
        $user['last_username'] = $username;
        $user['last_locale'] = AcceptLanguage::getLanguageFromRequest($request);
        if ($STAILEUAccounts->getUser()->id == $this->container->get('default_admin_user_id')) {
            $user['is_admin'] = true;
        }
        $user->save();
        // generate a token and save it into cookie
        $userInfos = [
            'id' => $STAILEUAccounts->getUser()->id,
            'email' => $email,
            'avatar' => $avatar,
            'username' => $username,
            'is_admin' => (bool)$user['is_admin']
        ];
        $message = "New login: {$STAILEUAccounts->getUser()->id}";
        $message .= " email: {$userInfos['email']}";
        $message .= " username: {$userInfos['username']}";
        $message .= " is_admin: {$userInfos['is_admin']}";
        $message .= " avatar: {$userInfos['avatar']}";
        $this->container->get(Logger::class)->info($message);
        $token = $session->create($userInfos);

        return $response->withJson([
            'success' => true,
            'data' => [
                'token' => $token,
                'user' => $userInfos
            ]
        ]);
    }

    public function getInfo(Response $response, Session $session)
    {
        return $response->withJson([
            "success" => true,
            "data" => $session->getData()
        ]);
    }

    public function getLoginDesktop(Response $response)
    {
        $loginDesktopToken = Uuid::uuid();
        $jwt = JWT::encode([
            'iss' => $this->container->get('app_name') . '._.' . $this->container->get('env_name'),
            'iat' => Carbon::now()->timestamp,
            'login_desktop_token' => $loginDesktopToken
        ], $this->container->get('jwt')['key']);
        return $response->withJson([
            'success' => true,
            'data' => [
                'token' => $jwt
            ]
        ]);
    }

    public function postLoginDesktop(ServerRequestInterface $request, Response $response, Session $session)
    {
        $validator = new Validator($request->getParsedBody());
        $validator->required('token');
        $validator->notEmpty('token');
        if (!$validator->isValid()) {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors(true)
            ], 400);
        }
        // verify JWT token
        try {
            $decoded = JWT::decode($validator->getValue('token'), $this->container->get('jwt')['key'], ['HS256']);
        } catch (Exception $e) {
            return $response->withStatus(401)->withJson([
                'success' => false,
                'errors' => [
                    ['code' => 'invalid_desktop_login_token', 'message' => 'Invalid desktop login token']
                ]
            ]);
        }
        // call the websocket server via http request with the token to trigger the event
        $decoded = json_decode(json_encode($decoded), true);
        $payload = [
            'login_desktop_token' => $decoded['login_desktop_token'],
            'user_token' => $session->getToken(),
            'user' => $session->getUser()
        ];
        $this->container->get(WebSocketServerClient::class)->notifyDesktopLogin($payload);

        return $response->withJson([
            'success' => true
        ]);
    }
}
