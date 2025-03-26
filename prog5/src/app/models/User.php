<?php

class User
{
    private $conn;
    private $table = "users";


    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function getUsers()
    {
        $sql = "SELECT * FROM $this->table WHERE id != :id ORDER BY role";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $_SESSION['user']['id']);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByUsername($username)
    {
        $sql = "SELECT * FROM $this->table WHERE username = :username";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":username", $username, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getUsersByRole($role)
    {
        $sql = "SELECT * FROM $this->table WHERE role = :role";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":role", $role, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateUserById($id, $data)
    {
        $updateFields = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));
        $sql = "UPDATE users SET $updateFields WHERE id = :id";

        $data["id"] = $id;
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute($data);
    }

    public function deleteUserById($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }
}
