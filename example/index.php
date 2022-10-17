<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Imsidow\Wapi\Provider;

$wapi = new Provider('M0910278', '1000389', 'API-2126079682AHX');

// $request = $wapi->requestPayment([
//     "mobile" => "252616505113",
//     "reference" => '0121',
//     "invoiceNo" => "12321",
//     "amount" => 0.1
// ]);

// $request = $wapi->cancelRequestPayment([
//     'transactionId' => '26732891',
//     'description' => 'test',
//     'reference' => '0001',
// ]);

$request = $wapi->refund([
    'transactionId' => '26732891',
    'description' => 'test',
    'reference' => '0001',
]);

// $request->success(function ($res, $message, $code) {
//     echo json_encode($res);
//     echo $message;
//     echo $code;
// })->error(function ($res, $message, $code) {
//     echo json_encode($res);
//     echo $message;
//     echo $code;
// });

// $wapi->getAccountInfo([
//     'transactionId' => '26268322',
//     'description' => 'test',
//     'reference' => '0001',
// ]);