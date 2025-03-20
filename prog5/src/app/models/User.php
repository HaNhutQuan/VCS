<?php

class User {
    private $conn;
    private $table = "users";

    private $user_id;
    private $username;
    private $password;
    private $full_name;
    private $email;
    private $phone;
    private $avatar;
    private $role;
    private $created_at;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    private function setInfo($user_id, $username, $password, $full_name, $email, $phone, $avatar, $role, $created_at) {
        $this->user_id = $user_id;
        $this->username = $username;
        $this->password = $password;
        $this->full_name = $full_name;
        $this->email = $email;
        $this->phone = $phone;
        $this->avatar = $avatar;
        $this->role = $role;
        $this->created_at = $created_at;
    }

    private function getInfoFromDB($username) {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_OBJ);

        if ($user) {
            
            $this->setInfo($user->user_id, $user->username, "", $user->full_name, $user->email, $user->phone, $user->avatar, $user->role, $user->created_at);
            return true;
        } else {
            return false;
        }
    }

    public function getInfo($username) {
        $this->getInfoFromDB($username);

        return [
            "user_id" => $this->user_id,
            "username" => $this->username,
            "full_name" => $this->full_name,
            "email" => $this->email,
            "phone" => $this->phone,
            "avatar" => $this->avatar,
            "role" => $this->role,
            "created_at" => $this->created_at,
        ];
    }

    
    public function getUserByUsername($username) {
        $query = "SELECT * FROM $this->table WHERE username = :username";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }


    public function register() {
        // $sql = "INSERT INTO users (username, password, full_name, email, phone, avatar, role) 
        //     VALUES (:username, :password, :full_name, :email, :phone, :avatar, :role)";

        // $stmt = $this->conn->prepare($sql);
        // $data = [
        //     ':username'   => 'user1',
        //     ':password'   => password_hash('1', PASSWORD_BCRYPT), 
        //     ':full_name'  => 'test',
        //     ':email'      => 'student1@gmail.com',
        //     ':phone'      => '0765400898',
        //     ':avatar'     => 'http://example.com',
        //     ':role'       => 'student'
        // ];
        // $stmt->execute($data);
    }
}