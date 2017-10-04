<?php

namespace TencentTH\TSMSApi;


class Store {
  private $sqlite = null;

  public function __construct($location) {
    $this->sqlite = new \SQLite3($location);
    $tables = $this->sqlite->query('
      SELECT name
      FROM sqlite_master
      WHERE type="table"
      ORDER BY name
    ')->fetchArray();

    if ($tables === false || !in_array('callback', $tables)) {
      $this->sqlite->exec('
        CREATE TABLE callback
        (time TEXT, uri TEXT, content TEXT)
      ');
    }
  }

  public function insert($uri, $content) {
    $now = new \DateTime();
    $this->sqlite->exec(sprintf('
      INSERT INTO callback
      (time, uri, content)
      VALUES
      (\'%s\', \'%s\', \'%s\')',
      $this->sqlite->escapeString($now->format('c')),
      $this->sqlite->escapeString($uri),
      $this->sqlite->escapeString($content)
    ));
  }

}
