<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Imsidow\Wapi\Provider;

$wapi = new Provider('M0910278', '1000389', 'API-2126079682AHX');

$wapi->requestMobilePayment([
    "mobile" => "252616505113",
    "reference" => '0001',
    "invoiceNo" => "00001",
    "amount" => 100
]);
