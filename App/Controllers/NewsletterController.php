<?php

namespace App\Controllers;

use App\Utils\MailChimp;
use DiscordWebhooks\Client;
use DiscordWebhooks\Embed;
use Exception;
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

        $mailChimpResponse = $mailChimp->addSubscriber(
            $this->container->get('mailchimp')['list_id'],
            $validator->getValue('email')
        );

        if ($mailChimpResponse->getStatusCode() !== 200) {
            return $response->withJson([
                'success' => false,
                'errors' => [
                    json_decode($mailChimpResponse->getBody()->getContents())
                ]
            ], 400);
        }

        return $response->withJson([
            'success' => true
        ]);
    }

    public function getEvent(Response $response)
    {
        return $response->withJson(true, 200);
    }

    public function postEvent(ServerRequestInterface $request, Response $response)
    {
        $data = json_decode(json_encode($request->getParsedBody()), true);
        $discordWebHook = new Client($this->container->get('mailchimp')['discord_webhook']);
        $embed = new Embed();
        $notes = [];
        if (!isset($data['type']) || empty($data['type'])) {
            return $response->withJson([
                'success' => false,
                'errors' => [['message' => 'Missing type field']]
            ], 400);
        }
        if ($data['type'] === 'subscribe') {
            $address = $data['data']['email'];
            if (strpos($address, 'ignore') !== false && strpos($address, 'event') !== false) {
                $notes[] = 'This event was ignored because of the email address format';
            } else {
                $embed->color("27ae60");
                $embed->title("New subscriber!");
                $embed->field("Email", $address);
                $embed->field("Ip", $data['data']['ip_opt']);
                $embed->field("At", $data['fired_at']);
                $embed->field("Id", $data['data']['id']);
                try {
                    $discordWebHook->embed($embed)->send();
                } catch (Exception $e) {
                    return $response->withJson([
                        'success' => false,
                        'errors' => [['message' => 'Error with the discord webhook api']]
                    ], 400);
                }
            }
        } else {
            $notes[] = 'This event was ignored because is it not in the server scope';
        }
        return $response->withJson([
            'success' => true,
            'notes' => $notes
        ]);
    }
}
