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


class SQL
{
  /**
   * Retorna a conexão PDO interna.
   */
  public function getConnection(): \PDO
  {
    return $this->conn;
  }
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

  /**
   * Insere um registro na tabela.
   * @param string $table
   * @param array $data
   */
  public function insert(string $table, array $data): void
  {
    $columns = array_keys($data);
    $placeholders = array_map(fn($col) => ':' . $col, $columns);
    $sql = sprintf(
      'INSERT INTO %s (%s) VALUES (%s)',
      $table,
      implode(', ', $columns),
      implode(', ', $placeholders)
    );
    $params = [];
    foreach ($columns as $col) {
      $params[':' . $col] = $data[$col];
    }
    $this->query($sql, $params);
  }

  /**
   * Atualiza registros na tabela.
   * @param string $table
   * @param array $data
   * @param array $where
   */
  public function update(string $table, array $data, array $where): void
  {
    $set = [];
    $params = [];
    foreach ($data as $col => $val) {
      $set[] = "$col = :set_$col";
      $params[":set_$col"] = $val;
    }
    $whereParts = [];
    foreach ($where as $col => $val) {
      $whereParts[] = "$col = :where_$col";
      $params[":where_$col"] = $val;
    }
    $sql = sprintf(
      'UPDATE %s SET %s WHERE %s',
      $table,
      implode(', ', $set),
      implode(' AND ', $whereParts)
    );
    $this->query($sql, $params);
  }

  /**
   * Deleta registros da tabela.
   * @param string $table
   * @param array $where
   */
  public function delete(string $table, array $where): void
  {
    $whereParts = [];
    $params = [];
    foreach ($where as $col => $val) {
      $whereParts[] = "$col = :where_$col";
      $params[":where_$col"] = $val;
    }
    $sql = sprintf(
      'DELETE FROM %s WHERE %s',
      $table,
      implode(' AND ', $whereParts)
    );
    $this->query($sql, $params);
  }

  private function setParams($statement, $parameters = array())
  {
    foreach ($parameters as $key => $value) {
      $statement->bindValue($key, $value);
    }
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

  /**
   * @return array [string $whereSQL, array $params]
   */
  public static function buildWhereClause(array $conditions, string $tablePrefix = ''): array
  {
    $parts = [];
    $params = [];

    foreach ($conditions as $column => $value) {
      if ($value === null || (is_string($value) && trim($value) === '')) {
        continue;
      }

      $placeholder = ':' . $column;

      if ($value instanceof \DateTimeInterface) {
        $value = $value->format('Y-m-d H:i:s');
      }

      $qualifiedColumn = $tablePrefix ? "$tablePrefix.$column" : $column;

      $parts[] = "$qualifiedColumn = $placeholder";
      $params[$placeholder] = $value;
    }

    $where = $parts ? 'WHERE ' . implode(' AND ', $parts) : '';

    return [$where, $params];
  }

  /**
   * Builds prefixed SELECT columns for JOIN queries.
   *
   * @param array $columns [tableAlias => [columns]]
   * @return string
   */
  public static function buildSelectColumns(array $columns): string
  {
    $selectParts = [];
    foreach ($columns as $alias => $cols) {
      foreach ($cols as $col) {
        $selectParts[] = sprintf("%s.%s AS %s_%s", $alias, $col, $alias, $col);
      }
    }

    return implode(", ", $selectParts);
  }


}
