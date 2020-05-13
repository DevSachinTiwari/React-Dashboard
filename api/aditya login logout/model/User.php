<?php

class User
{
    private $con;
    private $table_name = 'users';

    public function __construct($db)
    {
        $this->con = $db;
    }

    function getAll()
    {
        $sql = "SELECT * FROM {$this->table_name} ORDER BY created DESC";
        return $this->con->prepare($sql)->execute();
    }

    function getUserById($id)
    {
        $sql = "SELECT * FROM {$this->table_name} WHERE id = ? LIMIT 0,1";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(1, $id);
        return $stmt->execute()->fetch(PDO::FETCH_ASSOC);
    }

    function create($data)
    {
        $query = "INSERT INTO {$this->table_name} SET first_name=:fname,last_name=:lname,email=:email,password=:pass,created=:created";
        $stmt = $this->con->prepare($query);
        $first_name = htmlspecialchars(strip_tags($data->first_name));
        $last_name = htmlspecialchars(strip_tags($data->last_name));
        $email = htmlspecialchars(strip_tags($data->email));
        $password = md5(htmlspecialchars(strip_tags($data->password)));
        $created = date('Y-m-d H:i:s');
        $stmt->bindParam(":fname", $first_name);
        $stmt->bindParam(":lname", $last_name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":pass", $password);
        $stmt->bindParam(":created", $created);
        if ($stmt->execute()) return true;
        return false;
    }

    function checkUserValid($email, $password)
    {
        $sql = "SELECT id,first_name,last_name,email,created,updated FROM {$this->table_name} WHERE email = :email AND password = :password LIMIT 0,1";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}