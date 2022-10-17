<?php

namespace Imsidow\Wapi;

use GuzzleHttp\Client;
use Imsidow\Wapi\Enumerations\ResponseStatusCode;

class Request
{
    private string $baseUrl = 'https://api.waafipay.net/asm';

    private string $merchantUid;
    private string $apiUserId;
    private string $apiKey;
    private array $statusCodeMessage = [
        430 => 'insufficient balance',
        432 => 'invalid pin code',
        434 => 'user cancel',
        436 => 'request timeout',
        438 => 'invalid phone number',
    ];

    public function __construct(string $merchantUid, string $apiUserId, string $apiKey)
    {
        $this->merchantUid = $merchantUid;
        $this->apiUserId = $apiUserId;
        $this->apiKey = $apiKey;
    }

    public function send(array $request = [])
    {
        $response = $this->client()->post('', ["json" => $this->formatRequest($request)]);
        return $this->formatResponse($response, $request['serviceName']);
        // return json_decode($response->getBody()->getContents(), true);
    }

    private function formatRequest(array $request): array
    {
        $serviceName = $request['serviceName'];
        unset($request['serviceName']);

        return [
            "schemaVersion" => "1.0",
            "requestId" => rand(1000000000, 9999999999),
            "timestamp" => time(),
            "channelName" => "WEB",
            "serviceName" => $serviceName,
            "serviceParams" => array_merge([
                "merchantUid" => $this->merchantUid,
                "apiUserId" => $this->apiUserId,
                "apiKey" => $this->apiKey,
            ], $request)
        ];
    }

    private function formatResponse($response, $serviceName): object
    {
        $response = json_decode($response->getBody()->getContents(), true);
        if ($response['errorCode'] === 'E10205') {
            return (object) $this->errorResponse($response);
        } else if ($response['errorCode'] === '0') {
            return (object) $this->successResponse($response);
        }
    }

    private function errorResponse($response): array
    {
        $statusCode = $this->responseMessageToStatusCode($response['responseMsg']);
        return [
            "error" => true,
            "message" => $this->statusCodeMessage[$statusCode],
            "statusCode" => $statusCode,
            "params" => [
                "timestamp" => $response['timestamp'],
                "requestId" => $response['requestId'],
                "transactionId" => $this->getTransactionIdFromResponseMessage($response['responseMsg']),
                ...$response['params']
            ]
        ];
    }

    private function successResponse($response): array
    {
        return [
            "message" => 'successful',
            "statusCode" => 200,
            "params" => [
                "timestamp" => $response['timestamp'],
                "requestId" => $response['requestId'],
                ...$response['params']
            ]
        ];
    }

    private function getTransactionIdFromResponseMessage(string $message): string
    {
        preg_match('/TransactionId: (\w+)/i', $message, $out);
        return $out[1] ?? "";
    }

    private function responseMessageToStatusCode(string $message): int
    {
        if (preg_match('/Invalid PIN code/i', $message)) {
            return ResponseStatusCode::INVALID_PIN_CODE;
        } else if (preg_match('/error occurred/i', $message)) {
            return ResponseStatusCode::USER_CANCEL;
        } else if (preg_match('/balance is not sufficient/i', $message)) {
            return ResponseStatusCode::INSUFFICIENT_BALANCE;
        } else if (preg_match('/Receiver Subscriber not found/i', $message)) {
            return ResponseStatusCode::INVALID_PHONE_NUMBER;
        }

        return ResponseStatusCode::UNKNOWN;
    }

    private function client(): Client
    {
        return new Client(['base_uri' => $this->baseUrl, 'timeout' => 20]);
    }
}
