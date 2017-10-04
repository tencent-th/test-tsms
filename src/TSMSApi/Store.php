<?php

namespace TencentTH\TSMSApi;


class Store {
  private static $location = __DIR__ . '/../../data/data.db';
  private $sqlite = null;

  public function __construct() {
    $this->sqlite = new \SQLite3(self::$location);
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

  public function all() {
    $res = $this->sqlite->query('SELECT * FROM callback ORDER BY time DESC');
    $rows = [];
    while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
      $rows[] = $row;
    }

    return $rows;
  }

}
