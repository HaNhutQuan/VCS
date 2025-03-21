<?php

class User
{
    private $conn;
    private $table = "users";


    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function getUserById($id)
    {
        $query = "SELECT * FROM $this->table WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByUsername($username)
    {
        $query = "SELECT * FROM $this->table WHERE username = :username";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getUsersByRole($role)
    {
        $query = "SELECT * FROM $this->table WHERE role = :role";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":role", $role);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateUserById($id, $data)
    {
        $updateFields = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));
        $query = "UPDATE users SET $updateFields WHERE id = :id";

        $data["id"] = $id;
        $stmt = $this->conn->prepare($query);

        return $stmt->execute($data);
    }
}
