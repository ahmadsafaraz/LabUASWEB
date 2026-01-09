<?php
// classes/Database.php

class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    private $conn;
    private $error;

    // Constructor - otomatis connect saat object dibuat
    public function __construct() {
        $this->connect();
    }

    // Method untuk connect ke database
    private function connect() {
        $this->conn = null;
        
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname;
            $this->conn = new PDO($dsn, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn->exec("set names utf8");
        } catch(PDOException $e) {
            $this->error = "Connection Error: " . $e->getMessage();
            die($this->error);
        }
    }

    // Method untuk get connection
    public function getConnection() {
        return $this->conn;
    }

    // Method untuk execute query dengan prepared statement
    public function query($sql, $params = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch(PDOException $e) {
            $this->error = "Query Error: " . $e->getMessage();
            return false;
        }
    }

    // Method untuk get single row
    public function single($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetch() : false;
    }

    // Method untuk get multiple rows
    public function resultSet($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetchAll() : false;
    }

    // Method untuk get row count
    public function rowCount($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->rowCount() : 0;
    }

    // Method untuk get last insert ID
    public function lastInsertId() {
        return $this->conn->lastInsertId();
    }
}
?>