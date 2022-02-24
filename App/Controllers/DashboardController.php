<?php

namespace App\Controllers;

use App\Auth\Session;
use App\Models\User;
use Psr\Http\Message\ResponseInterface;

class DashboardController extends Controller
{
    public function getDashboard($_, ResponseInterface $response, Session $session){
        $this->loadDatabase();

        /** @var $user User */
        $user = User::query()
            ->find($session->getUserId());
        $orders = $user
            ->shopOrders()
            ->orderBy('created_at', 'DESC')
            ->get();
        $consoles = $user
            ->consoles()
            ->orderBy('created_at', 'DESC')
            ->get();

        return $response->withJson([
            "success" => true,
            "data" => [
                'user' => $session->getData()['user'],
                'orders' => $orders,
                'consoles' => $consoles
            ]
        ]);
    }

    public function getDelete($_, ResponseInterface $response) {
        // send a webhook to ask for a user deletion
        // to do that manually

        return $response->withJson([
            'success' => true
        ]);
    }
}
