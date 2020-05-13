<?php

class Database
{
    public $con;
    private $host = "localhost";
    private $db = "test";
    private $user = "root";
    private $pass = "";

    public function getCon()
    {
        $this->con = null;
        try {
            $this->con = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db, $this->user, $this->pass);
            $this->con->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->con;
    }
}
