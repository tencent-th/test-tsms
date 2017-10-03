<?php

namespace TencentTH\TSMSApi;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Constants {

  public static $APP_ID = 'ake@tencent.co.th';
  public static $APP_KEY = 'XKDeV2KlRHI3FqlT6aGzEfFIwq2xwXCR';
  public static $SENDER_ID = '';

  /**
   * @return Testcase[]
   */
  public static function getTestcases() {
    return [
      'ssl' => new Testcase(
        'SSL support',
        function() {
          return 'The website and the API should support SSL';
        },
        FALSE
      ),
      'send-sms-text' => new Testcase(
        'Send text SMS',
        function () {
          if (!array_key_exists('mobile', $_REQUEST)) {
            return 'Please supply mobile through HTTP params';
          }
          $now = new \DateTime();
          $random = rand();
          $nonce = 'nonce:' . rand();
          $nationcode = "66";
          $mobile = $_REQUEST['mobile'];
          $message = 'Hello this is a test SMS message sent at ' . $now->format('c');
          $sig = hash('sha256', sprintf(
            'appkey=%s&random=%d&time=%d&mobile=%s',
            self::$APP_KEY,
            $random,
            $now->getTimestamp(),
            $mobile
          ));
          $url = 'http://tsms.qq.com/Qsms/BackendSendSms?' . http_build_query([
            'sdkappid' => self::$APP_ID,
            'random' => $random
          ]);

          return APIRequest::create($url, [
            'tel' => [
              'nationcode' => $nationcode,
              'mobile' => $mobile,
            ],
            'type' => 0,
            'msg' => $message,
            'senderid' => self::$SENDER_ID,
            'sig' => $sig,
            'time' => $now->getTimestamp(),
            'extend' => '',
            'ext' => $nonce
          ])->execute();
        },
        TRUE
      ),
      'send-sms-text-long' => new Testcase(
        'Send long text SMS',
        function () {
          if (!array_key_exists('mobile', $_REQUEST)) {
            return 'Please supply mobile through HTTP params';
          }
          $now = new \DateTime();
          $random = rand();
          $nonce = 'nonce:' . rand();
          $nationcode = "66";
          $mobile = $_REQUEST['mobile'];
          $message = 'Hello this is a very long test SMS message sent at ' . $now->format('c') . ' 012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789';
          $sig = hash('sha256', sprintf(
            'appkey=%s&random=%d&time=%d&mobile=%s',
            self::$APP_KEY,
            $random,
            $now->getTimestamp(),
            $mobile
          ));
          $url = 'http://tsms.qq.com/Qsms/BackendSendSms?' . http_build_query([
              'sdkappid' => self::$APP_ID,
              'random' => $random
            ]);

          return APIRequest::create($url, [
            'tel' => [
              'nationcode' => $nationcode,
              'mobile' => $mobile,
            ],
            'type' => 0,
            'msg' => $message,
            'senderid' => self::$SENDER_ID,
            'sig' => $sig,
            'time' => $now->getTimestamp(),
            'extend' => '',
            'ext' => $nonce
          ])->execute();
        },
        TRUE
      ),
    ];
  }

  public static function getTestcaseSource($func) {
    $reflection = new \ReflectionFunction($func);
    $file = file(__FILE__);
    $source = array_slice(
      $file,
      $reflection->getStartLine(),
      $reflection->getEndLine() - $reflection->getStartLine() - 1
    );

    return implode("", $source);
  }

}
