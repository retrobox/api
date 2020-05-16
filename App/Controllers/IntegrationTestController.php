<?php

namespace App\Controllers;

use Illuminate\Database\Capsule\Manager;
use Slim\Http\Response;

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

    public function getLambdaUserA(Response $response) {

    }

    public function getLambdaUserB(Response $response) {

    }

    public function getAdminUserA(Response $response) {

    }
}