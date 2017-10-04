<?php

use TencentTH\TSMSApi\Store;

include 'vendor/autoload.php';

$location = 'data/data.db';
$body = file_get_contents('php://input');
$uri = $_SERVER['REQUEST_URI'];

if (mb_strlen($body) > 0) {
  $store = new Store($location);
  $store->insert($uri, $body);
}
