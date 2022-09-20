<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Imsidow\Wapi\Provider;

$wapi = new Provider('M0910278', '1000389', 'API-2126079682AHX');

// $wapi->requestPayment([
//     "mobile" => "252616505113",
//     "reference" => '0121',
//     "invoiceNo" => "12321",
//     "amount" => 0.1
// ]);

// $wapi->refundPayment([
//     'transactionId' => '02123232',
//     'description' => 'test',
//     'reference' => '0001',
// ]);

$wapi->getAccountInfo([
    'transactionId' => '26268322',
    'description' => 'test',
    'reference' => '0001',
]);

// {"schemaVersion":"1.0","timestamp":"2022-08-01 19:25:43.436","requestId":"8534022951","sessionId":null,
    // "responseCode":"5206","errorCode":"E10205","responseMsg":"RCS_TRAN_FAILED_AT_ISSUER_SYSTEM (Receiver Subscriber not found, TransactionId: 25446479)","params":[]}

    // {"schemaVersion":"1.0","timestamp":"2022-08-01 19:32:21.304","requestId":"5439603625","sessionId":null,
        // "responseCode":"2001","errorCode":"0","responseMsg":"RCS_SUCCESS","params":{"state":"APPROVED","referenceId":"0001","transactionId":"25446609","txAmount":"0.1"}}

        // {"schemaVersion":"1.0","timestamp":"2022-08-01 19:33:18.893","requestId":"7507092005","sessionId":null,"responseCode":"2001","errorCode":"0","responseMsg":"RCS_SUCCESS",
            // "params":{"description":"success","state":"approved","transactionId":"25446609","referenceId":"00001"}}


 // {"message":"successful","statusCode":200,"params":{"timestamp":"2022-08-01 19:42:54.705","requestId":"9228669866","state":"APPROVED","referenceId":"0001","transactionId":"25446816","txAmount":"0.1"}}
//  {"message":"successful","statusCode":200,"params":{"timestamp":"2022-08-01 19:44:23.907","requestId":"6777299780","description":"success","state":"approved","transactionId":"25446816","referenceId":"00001"}}

//  {"schemaVersion":"1.0","timestamp":"2022-09-20 18:57:49.046","requestId":"4349230191","sessionId":null,"responseCode":"5213","errorCode":"E10206","responseMsg":"RCS_TRAN_NOT_FOUND","params":[]} -> cancel purchase -> not found
//  {"schemaVersion":"1.0","timestamp":"2022-09-20 18:57:49.046","requestId":"4349230191","sessionId":null,"responseCode":"5213","errorCode":"E10206","responseMsg":"RCS_TRAN_NOT_FOUND","params":[]} -> cancel purchase -> not allowed