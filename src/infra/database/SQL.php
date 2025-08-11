<?php
namespace src\infra\database;

use Dotenv\Dotenv;


$dotenv = Dotenv::createImmutable(dirname(__DIR__, levels: 3));
$dotenv->safeLoad();
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
  private static string $HOSTNAME = '';
  private static string $USERNAME = '';
  private static string $PASSWORD = '';
  private static string $DBNAME = '';
  private static string $PORT = '3306';

  private \PDO $conn;

  public function __construct()
  {
  if (self::$HOSTNAME === '') {
      self::$HOSTNAME = getenv('MYSQL_HOST') ?: ($_ENV["MYSQL_HOST"] ?? ($_SERVER['MYSQL_HOST'] ?? '127.0.0.1'));
      self::$USERNAME = getenv('MYSQL_USERNAME') ?: ($_ENV["MYSQL_USERNAME"] ?? ($_SERVER['MYSQL_USERNAME'] ?? 'root'));
      self::$PASSWORD = getenv('MYSQL_PASSWORD') ?: ($_ENV["MYSQL_PASSWORD"] ?? ($_SERVER['MYSQL_PASSWORD'] ?? ''));
      self::$DBNAME = getenv('MYSQL_DATABASE_NAME') ?: ($_ENV["MYSQL_DATABASE_NAME"] ?? ($_SERVER['MYSQL_DATABASE_NAME'] ?? ''));
      self::$PORT = getenv('MYSQL_PORT') ?: ($_ENV['MYSQL_PORT'] ?? ($_SERVER['MYSQL_PORT'] ?? '3306'));
    }

    $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', self::$HOSTNAME, self::$PORT, self::$DBNAME);
    $options = [
      \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
      \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
      \PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $this->conn = new \PDO($dsn, self::$USERNAME, self::$PASSWORD, $options);
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
