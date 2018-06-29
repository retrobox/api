<?php

namespace App\Controllers\Account;

use App\Auth\Session;
use App\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Dflydev\FigCookies\Cookie;
use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use Dflydev\FigCookies\SetCookies;
use Firebase\JWT\JWT;
use Illuminate\Database\Capsule\Manager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use STAILEUAccounts\STAILEUAccounts;
use Validator\Validator;

class StailEuController extends Controller
{
    public function getLogin(ServerRequestInterface $request, ResponseInterface $response, STAILEUAccounts $STAILEUAccounts)
    {
        $url = $STAILEUAccounts->loginForm($this->container->get('staileu')['redirect']);
        return $response->withJson([
            'success' => true,
            'data' => [
                'url' => $url
            ]
        ]);
    }

    public function getRegister(ServerRequestInterface $request, ResponseInterface $response, STAILEUAccounts $STAILEUAccounts)
    {
        $url = $STAILEUAccounts->registerForm($this->container->get('staileu')['redirect']);
        return $response->withJson([
            'success' => true,
            'data' => [
                'url' => $url
            ]
        ]);
    }

    public function getExecute(ServerRequestInterface $request, ResponseInterface $response, STAILEUAccounts $STAILEUAccounts, Manager $manager, Session $session)
    {
        $validator = new Validator($request->getQueryParams());
        $validator->required('c-sa');
        $validator->notEmpty('c-sa');
        if ($validator->isValid()) {
            //validate the token with staileu
            $result = $STAILEUAccounts->check($validator->getValue('c-sa'));
            if (is_string($result)) {
                //check if the user exist
                $user = User::find($result);
                if ($user == NULL) {
                    //create the user
                    $user = new User();
                    $user->id = $result;
                }
                $user->last_login_at = Carbon::now();
                $user->last_user_agent = $request->getServerParams()['HTTP_USER_AGENT'];
                $user->save();
                //generate a token and save it into cookie
                $token = $session->create([
                    'id' => $result,
                    'email' => $STAILEUAccounts->getEmail($result),
                    'avatar' => $STAILEUAccounts->getAvatar($result)->getUrl(),
                    'username' => $STAILEUAccounts->getUsername($result)
                ]);
                $response = FigResponseCookies::set($response, SetCookie::create($this->container->get('account')['jwt_cookie'])
                    ->withValue($token)
                    ->withDomain($this->container->get('account')['domain'])
                    ->withPath('/')
                    ->rememberForever());

                return $this->redirect($response, FigRequestCookies::get($request, $this->container->get('account')['redirection_url_cookie'])->getValue());
            } else {
                return $response->withJson([
                    'success' => false,
                    'errors' => [
                        $result->getMessage()
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
}