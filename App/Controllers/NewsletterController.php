<?php

namespace App\Controllers;

use App\Utils\MailChimp;
use DiscordWebhooks\Client;
use DiscordWebhooks\Embed;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use Validator\Validator;

class NewsletterController extends Controller
{
    public function postSubscribe(ServerRequestInterface $request, Response $response, MailChimp $mailChimp)
    {
        $validator = new Validator($request->getParsedBody());
        $validator->required('email');
        $validator->notEmpty('email');
        $validator->email('email');
        if (!$validator->isValid()) {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors(true)
            ], 400);
        }

        $mailChimpResponse = $mailChimp->addSubscriber($this->container->get('mailchimp')['list_id'], $validator->getValue('email'));

        if ($mailChimpResponse->getStatusCode() !== 200) {
                return $response->withJson([
                    'success' => false,
                    'errors' => json_decode($mailChimpResponse->getBody()->getContents())
                ], 400);
        }

        return $response->withJson([
            'success' => true
        ]);
    }

    public function getEvent(Response $response)
    {
        return $response->withJson(true)->withStatus(200);
    }

    public function postEvent(ServerRequestInterface $request, Response $response)
    {
        $data = $request->getParsedBody();
        $data = json_decode(json_encode($data), true);
        $discordWebHook = new Client($this->container->get('mailchimp')['discord_webhook']);
        $embed = new Embed();
        switch ($data['type']) {
            case "subscribe":
                $embed->color("27ae60");
                $embed->title("New subscriber!");
                $embed->field("Email", $data['data']['email']);
                $embed->field("Ip", $data['data']['ip_opt']);
                $embed->field("At", $data['fired_at']);
                $embed->field("Id", $data['data']['id']);
                try {
                    $discordWebHook->embed($embed)->send();
                } catch (\Exception $e) {
                    return $response->withJson([
                        'success' => false,
                        'errors' => ['Error with the discord webhook api']
                    ], 400);
                }
                break;
        }
        return $response->withJson([
            'success' => true
        ]);
    }
}
