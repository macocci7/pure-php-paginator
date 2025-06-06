<?php

namespace Libs;

use Libs\DBStatement;
use Libs\Log;
use PDO;

class DB {

    public bool $status = false;
    public PDO|null $dbh = null;

    public function __construct() {
        $this->connectToDatabase();
    }

    public function __destruct() {
        $this->dbh = null;
        $this->status = false;
    }

    public function connectToDatabase(): void {
        try {
            $dsn = sprintf(
                "%s:host=%s;dbname=%s;port=%d",
                "mysql",    // PDO driver: https://www.php.net/manual/ja/pdo.drivers.php
                "mysql",    // host
                "laravel",  // database
                3306        // port
            );
            $this->dbh = new PDO(
                $dsn,
                "root", // db user
                "pass"  // db password
            );
            $this->dbh->exec("SET NAMES utf8");
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbh->setAttribute(PDO::ATTR_STATEMENT_CLASS, [DBStatement::class]);
            $this->status = true;

        } catch (\Throwable $e) {
            Log::exception($e);
            throw $e;
        }
    }

    /**
     * @param	string	$sql
     * @param	array<string, int|float|string>	$params = []
     */
    public function raw(string $sql, array $params = []): DBStatement {
        try {
            $statement = $this->dbh->prepare($sql);
            $statement->execute($params);
            return $statement;
        } catch (\Throwable $e) {
            Log::exception($e);
            throw $e;
        }
    }
}
