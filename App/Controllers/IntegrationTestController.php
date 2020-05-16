<?php

namespace App\Controllers;

use App\Auth\Session;
use App\Models\User;
use Illuminate\Database\Capsule\Manager;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use Validator\Validator;

class IntegrationTestController extends Controller
{
    /**
     * Erase every actual data of the database.
     * Will remove every rows of every tables except for the phinxlog table in the database.
     * This is a really, really dangerous route only meant to be used for test purposes and test purposes only.
     * If the app is not in test mode or if the database is not named with the 'test' keyword, this wont work.
     *
     * @param Response $response
     * @return Response
     */
    public function getDangerouslyTruncateTables(Response $response)
    {
        if (!$this->container->get('app_test'))
            return $response->withJson([
                'success' => false,
                'errors' => [['message' => 'Not in test mode']]
            ], 403);

        $pdo = $this->container->get(Manager::class)->getConnection();

        if (strpos($pdo->getDatabaseName(), 'test') === false)
            return $response->withJson([
                'success' => false,
                'errors' => [['message' => 'Cannot truncate a non test database']]
            ], 403);

        $tables = $pdo->getPdo()->query("SHOW TABLES")->fetchAll();
        $truncateRaw = '';
        $tables = array_filter($tables, fn ($t) => $t[0] !== 'phinxlog');
        foreach ($tables as $table) {
            $truncateRaw .= 'TRUNCATE ' . $table[0] . '; ';
        }

        return $response->withJson([
            'success' => true,
            'data' => [
                'raw' => $truncateRaw
            ]
        ]);
    }

    public function getUserToken(ServerRequestInterface $request, Response $response, Session $session) {
        if (!$this->container->get('app_test')) {
            return $response->withJson([
                'success' => false,
                'errors' => [['message' => 'Not in test mode']]
            ], 403);
        }
        if (!$session->isAdmin()) {
            return $response->withJson([
                'success' => false,
                'errors' => [['message' => 'Forbidden']]
            ], 403);
        }
        $this->loadDatabase();
        $validator = new Validator($request->getQueryParams());
        $validator->requiredAndNotEmpty('id');
        if (!$validator->isValid()) {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ], 400);
        }
        /* @var $user User */
        $user = User::query()->find($validator->getValue('id'));
        if ($user == NULL) {
            return $response->withJson([
                'success' => false,
                'errors' => [['message' => 'Unknown user']]
            ], 404);
        }
        return $response->withJson([
            'success' => true,
            'data' => [
                'token' => $session->create([
                    'id' => $user['id'],
                    'email' => $user['last_email'],
                    'avatar' => $user['last_avatar'],
                    'username' => $user['last_username'],
                    'is_admin' => (bool)$user['is_admin']
                ])
            ]
        ]);
    }
}