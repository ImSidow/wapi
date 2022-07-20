<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Imsidow\Wapi\ClassWapi;


$wapi = new ClassWapi('M0910278', '1000389', 'API-2126079682AHX');

$wapi->requestMobilePayment();


