<?php
class Database
{
    //DB Params
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    //DB Connect
    public function connect()
    {
        $this->host = getenv('PG_HOST');
        $this->db_name = getenv('PG_DBNAME');
        $this->username = getenv('PG_USER');
        $this->password = getenv('PG_PASS');
        $this->conn = null;

        try {
            $this->conn = new PDO('pgsql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
        return $this->conn;
    }
}