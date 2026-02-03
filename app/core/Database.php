<?php

class Database
{
    private string $host = 'localhost';
    private string $user = 'root';
    private string $pass = '';
    private string $db   = 'merchansuki';

    private PDO $dbh;
    private PDOStatement $stmt;

    public function __construct()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4";

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    /** Prepare SQL */
    public function query(string $query): void
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    /** Bind parameter */
    public function bind(string $param, mixed $value): void
    {
        $this->stmt->bindValue($param, $value);
    }

    /** Execute statement */
    public function execute(): bool
    {
        return $this->stmt->execute();
    }

    /** Get all rows */
    public function resultSet(): array
    {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    /** Get single row */
    public function single(): array|false
    {
        $this->execute();
        return $this->stmt->fetch();
    }

    /** Affected rows */
    public function rowCount(): int
    {
        return $this->stmt->rowCount();
    }

    /** Last inserted ID */
    public function lastInsertId(): string
    {
        return $this->dbh->lastInsertId();
    }
}
