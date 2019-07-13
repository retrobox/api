<?php

namespace App\Controllers;

use App\Models\Console;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use Validator\Validator;

class ConsoleController extends Controller
{
    /**
     * Verify if the id and token is correct,
     * generally called by the Web Socket server
     * service to accept or reject a console overlay.
     *
     * @param ServerRequestInterface $request
     * @param Response $response
     * @return Response
     */
    public function verifyConsole(ServerRequestInterface $request, Response $response)
    {
        $validator = new Validator($request->getParsedBody());
        $validator->required('console_id', 'console_token');
        $validator->notEmpty('console_id', 'console_token');
        if (!$validator->isValid()) {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors(true)
            ], 400);
        }
        $this->loadDatabase();
        $console = Console::query()
            ->where('id', '=', $validator->getValue('console_id'))
            ->where('token', '=', $validator->getValue('console_token'))
            ->first();
        if ($console === NULL) {
            return $response->withJson([
                'success' => false,
                'errors' => [
                    'Invalid console_id or console_token'
                ]
            ], 401);
        }
        // valid console id and console token, display optional data about the console
        return $response->withJson([
            'success' => true,
            'data' => $console
        ]);
    }
}
