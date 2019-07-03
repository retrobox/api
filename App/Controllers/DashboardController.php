<?php

namespace App\Controllers;

use App\Auth\Session;
use App\Models\User;
use Slim\Http\Response;

class DashboardController extends Controller
{
    public function getDashboard(Response $response, Session $session){
        $this->loadDatabase();
        $orders = User::query()
            ->find($session->getUserId())
            ->first()
            ->shopOrders()
            ->orderBy('created_at', 'DESC')
            ->get();

//        var_dump($orders->get());

        return $response->withJson([
            "success" => true,
            "data" => [
                'user' => $session->getData()['user'],
                'orders' => $orders,
                'consoles' => []
            ]
        ]);
    }

    public function getDelete(Response $response) {
        // send a webhook to ask for a user deletion
        // to do that manually

        return $response->withJson([
            'success' => true
        ]);
    }
}
