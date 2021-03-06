<?php

namespace TencentTH\TSMSApi;


class Constants {

  public static $APP_ID = 'ake@tencent.co.th';
  public static $APP_KEY = 'XKDeV2KlRHI3FqlT6aGzEfFIwq2xwXCR';
  public static $SENDER_ID = 'JOOX';

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
      'send-sms-voice-en' => new Testcase(
        'Send voice SMS (EN)',
        function () {
          if (!array_key_exists('mobile', $_REQUEST)) {
            return 'Please supply mobile through HTTP params';
          }
          $now = new \DateTime();
          $random = rand();
          $nonce = 'nonce:' . rand();
          $nationcode = "66";
          $mobile = $_REQUEST['mobile'];
          $message = $now->format('his');
          $sig = hash('sha256', sprintf(
            'appkey=%s&random=%d&time=%d&mobile=%s',
            self::$APP_KEY,
            $random,
            $now->getTimestamp(),
            $mobile
          ));
          $url = 'http://tsms.qq.com/Qsms/BackendSendSmsIVR?' . http_build_query([
              'sdkappid' => self::$APP_ID,
              'random' => $random
            ]);

          return APIRequest::create($url, [
            'tel' => [
              'nationcode' => $nationcode,
              'mobile' => $mobile,
            ],
            'msg' => $message,
            'playtimes' => 2,
            'lang' => 'en',
            'sig' => $sig,
            'time' => $now->getTimestamp(),
            'ext' => $nonce
          ])->execute();
        },
        FALSE,
        '1) Parameters are not consistent. Missing type, senderid, and extend
2) No pause between repeating the numbers
3) Occasionally fail to work'
      ),
      'send-sms-voice-th' => new Testcase(
        'Send voice SMS (TH)',
        function () {
          if (!array_key_exists('mobile', $_REQUEST)) {
            return 'Please supply mobile through HTTP params';
          }
          $now = new \DateTime();
          $random = rand();
          $nonce = 'nonce:' . rand();
          $nationcode = "66";
          $mobile = $_REQUEST['mobile'];
          $message = $now->format('his');
          $sig = hash('sha256', sprintf(
            'appkey=%s&random=%d&time=%d&mobile=%s',
            self::$APP_KEY,
            $random,
            $now->getTimestamp(),
            $mobile
          ));
          $url = 'http://tsms.qq.com/Qsms/BackendSendSmsIVR?' . http_build_query([
              'sdkappid' => self::$APP_ID,
              'random' => $random
            ]);

          return APIRequest::create($url, [
            'tel' => [
              'nationcode' => $nationcode,
              'mobile' => $mobile,
            ],
            'msg' => $message,
            'playtimes' => 2,
            'lang' => 'th',
            'sig' => $sig,
            'time' => $now->getTimestamp(),
            'ext' => $nonce
          ])->execute();
        },
        FALSE,
        '1) Parameters are not consistent. Missing type, senderid, and extend
2) The repeating numbers has no effect
3) Occasionally fail to work'
      ),
      'status-mt' => new Testcase(
        'Status MT',
        function () {
          if (!array_key_exists('messageid', $_REQUEST)) {
            return 'Please supply messageid through HTTP params';
          }
          $now = new \DateTime();
          $random = rand();
          $messageid = $_REQUEST['messageid'];
          $sig = hash('sha256', sprintf(
            'appkey=%s&random=%d&time=%d&messageid=%s',
            self::$APP_KEY,
            $random,
            $now->getTimestamp(),
            $messageid
          ));
          $url = 'http://tsms.qq.com/Qsms/BackendSmsReportQuery?' . http_build_query([
              'sdkappid' => self::$APP_ID,
              'random' => $random
            ]);

          return APIRequest::create($url, [
            'messageid' => $messageid,
            'sig' => $sig,
            'time' => $now->getTimestamp(),
          ])->execute();
        },
        FALSE,
        '1) Parameters are not consistent. Missing ext
2) Time is not in standard format e.g. ISO-8601
3) Status is invalid. I have not got a call IVR but the status is DELIVRD'
      ),
      'status-number' => new Testcase(
        'Status Number',
        function () {
          if (!array_key_exists('mobile', $_REQUEST)) {
            return 'Please supply mobile through HTTP params';
          }
          $now = new \DateTime();
          $random = rand();
          $mobile = $_REQUEST['mobile'];
          $sig = hash('sha256', sprintf(
            'appkey=%s&random=%d&time=%d&mobile=%s',
            self::$APP_KEY,
            $random,
            $now->getTimestamp(),
            $mobile
          ));
          $url = 'http://tsms.qq.com/Qsms/BackendQueryNisInfo?' . http_build_query([
              'sdkappid' => self::$APP_ID,
              'random' => $random
            ]);

          return APIRequest::create($url, [
            'mobile' => $mobile,
            'sig' => $sig,
            'time' => $now->getTimestamp(),
          ])->execute();
        },
        FALSE,
        '1) Validity is not correct, unregistered mobile phone number returned as valid e.g. 66867605527
2) Carrier name is not valid'
      ),
      'status-push' => new Testcase(
        'Status Push',
        function () {
          $store = new Store();
          return $store->all();
        },
        FALSE,
        'Duplicated callback received'
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
