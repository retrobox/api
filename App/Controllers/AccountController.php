<?php

namespace App\Controllers;

use App\AcceptLanguage;
use App\Auth\Session;
use App\Models\User;
use Carbon\Carbon;
use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use Monolog\Logger;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use STAILEUAccounts\Client;
use Validator\Validator;

class AccountController extends Controller
{
    public function getLogin(Response $response, Client $STAILEUAccounts)
    {
        $url = $STAILEUAccounts->getAuthorizeUrl($this->container->get('staileu')['redirect'], [Client::SCOPE_READ_PROFILE, Client::SCOPE_READ_EMAIL]);
        return $response->withJson([
            'success' => true,
            'data' => [
                'url' => $url
            ]
        ]);
    }

    public function execute(ServerRequestInterface $request, Response $response, Client $STAILEUAccounts, Session $session)
    {
        $this->loadDatabase();
        if ($request->getMethod() == 'POST'){
            $validator = new Validator($request->getParsedBody());
        }else{
            $validator = new Validator($request->getQueryParams());
        }
        $validator->required('code');
        $validator->notEmpty('code');
        if ($validator->isValid()) {
            //validate the token with staileu
            if ($STAILEUAccounts->verify($validator->getValue('code'))) {
                //check if the user exist
                $STAILEUAccounts->fetchUser();
                $user = User::query()->find($STAILEUAccounts->getUser()->id);
                if ($user == NULL) {
                    //create the user
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
                if ($STAILEUAccounts->getUser()->id == $this->container->get('default_admin_user_id')){
                    $user['is_admin'] = true;
                }
                $user->save();
                //generate a token and save it into cookie
                $userInfos = [
                    'id' => $STAILEUAccounts->getUser()->id,
                    'email' => $email,
                    'avatar' => $avatar,
                    'username' => $username,
                    'is_admin' => (bool) $user['is_admin']
                ];
                $this->container->get(Logger::class)->info(
                    "New login: {$STAILEUAccounts->getUser()->id} email: {$userInfos['email']} username: {$userInfos['username']} is_admin: {$userInfos['is_admin']} avatar: {$userInfos['avatar']}");
                $token = $session->create($userInfos);
                if ($request->getMethod() == 'POST'){
                    //return simple token
                    return $response->withJson([
                        'success' => true,
                        'data' => [
                            'token' => $token,
                            'user' => $userInfos
                        ]
                    ]);
                }else{
                    //cookie way
                    $response = FigResponseCookies::set($response, SetCookie::create($this->container->get('account')['jwt_cookie'])
                        ->withValue($token)
                        ->withDomain($this->container->get('account')['domain'])
                        ->withPath('/')
                        ->rememberForever());

                    $redirect = FigRequestCookies::get($request, $this->container->get('account')['redirection_url_cookie'])->getValue();
                    if ($redirect == NULL){
                        return $this->redirect($response, $this->container->get('services')['web_endpoint']);
                    }
                    return $this->redirect($response, $redirect);
                }
            } else {
                return $response->withJson([
                    'success' => false,
                    'errors' => [
                        'Invalid STAIL.EU code'
                    ]
                ])->withStatus(400);
            }
        } else {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ])->withStatus(400);
        }
    }


    public function getInfo(Response $response, Session $session){
        return $response->withJson([
           "success" => true,
           "data" => $session->getData()
        ]);
    }
}
