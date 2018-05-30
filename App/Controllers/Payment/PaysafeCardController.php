<?php

namespace App\Controllers\Payment;

use App\Controllers\Controller;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SebastianWalker\Paysafecard\Amount;
use SebastianWalker\Paysafecard\Client;
use SebastianWalker\Paysafecard\Payment;
use Validator\Validator;

class PaysafeCardController extends Controller
{
	public function getUrl(ServerRequestInterface $request, ResponseInterface $response, Client $client)
	{
		$amount = new Amount(20.00, "EUR");
		$payment = new Payment($amount, "customer123");
		$payment->create($client);

		return $response->withJson([
			'success' => true,
			'data' => ['url' => $payment->getAuthUrl()]
		]);
	}

	public function capturePayment(ServerRequestInterface $request, ResponseInterface $response, Client $client, Logger $logger)
	{
		$validator = new Validator($request->getParsedBody());
		$validator->required('mtid');
		if ($validator->isValid()){

			$logger->info('New payment notification : ' . $validator->getValue("mtid"));

			try {
				// Find the payment the user was redirected from
				$payment = Payment::find($validator->getValue("mtid"), $client);
			}catch (\Exception $e){

				return $response->withJson([
					'success' => false,
					'errors' => [
						$e->getCode() . " " . $e->getMessage()
					]
				])->withStatus(400);

			}

			// Check if the payment was authorized
			if ($payment->isAuthorized()) {
				// ... and capture it
				$payment->capture($client);

				if ($payment->isSuccessful()) {
					return $response->withJson([
						'success' => true
					]);
				} else {
					return $response->withJson([
						'success' => false,
						'errors' => [
							$payment->getStatus()
						]
					])->withStatus(400);
				}

			} elseif ($payment->isFailed()) {
				echo "Payment Failed (" . $payment->getStatus() . ")";

				return $response->withJson([
					'success' => false,
					'errors' => [
						$payment->getStatus()
					]
				])->withStatus(400);
			} else {
				return $response->withJson([
					'success' => false,
					'errors' => [
						$payment->getStatus()
					]
				])->withStatus(400);
			}
		}else{
			$logger->info("body: " . json_encode($request->getParsedBody()));
			$logger->info("query params: " . json_encode($request->getQueryParams()));

			$logger->error("Failed: validator don't succeed");

			return $response->withJson([
				'success' => false,
				'errors' => $validator->getErrors()
			])->withStatus(400);
		}
	}
}
