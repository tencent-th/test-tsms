<?php

namespace TencentTH\TSMSApi;

class Testcase {
  public $title;
  public $func;
  public $pass;
  public $note;

  /** @var \Exception $lastException */
  public $lastException;

  public function __construct($title, $func, $pass, $note = NULL) {
    $this->title = $title;
    $this->func = $func;
    $this->pass = $pass;
    $this->note = $note;
  }

  public function execute() {
    try {
      return ($this->func)();
    }
    catch (\Exception $e) {
      $this->lastException = $e;
      return 'NULL';
    }
  }
}
