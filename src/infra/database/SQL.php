<?php

namespace src\infra\database;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, levels: 3));
$dotenv->load();

$dotenv->required([
  'MYSQL_HOST',
  'MYSQL_USERNAME',
  'MYSQL_PASSWORD',
  'MYSQL_DATABASE_NAME'
]);


class Sql
{
  private static $HOSTNAME;
  private static $USERNAME;
  private static $PASSWORD;
  private static $DBNAME;

  private $conn;

  public function __construct()
  {
    if (self::$HOSTNAME === null) {
      self::$HOSTNAME = $_ENV["MYSQL_HOST"];
      self::$USERNAME = $_ENV["MYSQL_USERNAME"];
      self::$PASSWORD = $_ENV["MYSQL_PASSWORD"];
      self::$DBNAME = $_ENV["MYSQL_DATABASE_NAME"];
    }

    $this->conn = new \PDO(
      "mysql:dbname=" . self::$DBNAME . ";host=" . self::$HOSTNAME,
      self::$USERNAME,
      self::$PASSWORD
    );
  }

  private function setParams($statement, $parameters = array())
  {
    foreach ($parameters as $key => $value) {
      $this->bindParam($statement, $key, $value);
    }
  }

  private function bindParam($statement, $key, $value)
  {
    $statement->bindParam($key, $value);
  }

  public function query($rawQuery, $params = array())
  {
    $stmt = $this->conn->prepare($rawQuery);
    $this->setParams($stmt, $params);
    $stmt->execute();
  }

  public function select($rawQuery, $params = array()): array
  {
    $stmt = $this->conn->prepare($rawQuery);
    $this->setParams($stmt, $params);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }
}
