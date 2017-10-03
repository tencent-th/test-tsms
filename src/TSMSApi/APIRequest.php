<?php

namespace TencentTH\TSMSApi;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class APIRequest {

  private $client;
  private $url;
  private $json;

  public function __construct($url, $json) {
    $this->client = new Client();
    $this->url = $url;
    $this->json = $json;
  }

  public static function create($url, $json) {
    return new static($url, $json);
  }

  public function execute() {
    try {
      $res = $this->client->request(
        'POST',
        $this->url,
        ['json' => $this->json]
      );
      return [
        'code' => $res->getStatusCode(),
        'result' => $res->getBody()->getContents()
      ];
    }
    catch (ClientException $e) {
      $res = $e->getResponse();
      return [
        'error' => true,
        'code' => $res->getStatusCode(),
        'result' => $res->getBody()->getContents()
      ];
    }
  }

}
