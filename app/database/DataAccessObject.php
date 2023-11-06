<?php

class DataAccessObject
{
  private static $DataAccessObject;
  private $pdo;

  private function __construct()
  {
    try {
      $this->pdo = new PDO('mysql:host=' . $_ENV['MYSQL_HOST'] . ';dbname=' . $_ENV['MYSQL_DB'] . ';charset=utf8;port=' . $_ENV['MYSQL_PORT'], $_ENV["MYSQL_USER"], $_ENV["MYSQL_PASS"], array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      $this->pdo->exec("SET CHARACTER SET utf8");
    } catch (PDOException $e) {
      print "Error!: " . $e->getMessage();
      die();
    }
  }

  public function getStatement($sql)
  {
    return $this->pdo->prepare($sql);
  }

  public function getLastInsertedId()
  {
    return $this->pdo->lastInsertId();
  }

  public static function getAccessObject()
  {
    if (!isset(self::$DataAccessObject)) {
      self::$DataAccessObject = new DataAccessObject();
    }

    return self::$DataAccessObject;
  }

  public function __clone()
  {
    trigger_error('La clonación de este objeto no está permitida.', E_USER_ERROR);
  }
}
