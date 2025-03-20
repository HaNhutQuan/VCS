<?php

class User {
    private $conn;
    private $table = "users";

    private $id;
    private $username;
    private $password_hash;
    private $full_name;
    private $email;
    private $phone;
    private $avatar;
    private $role;
    private $created_at;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    private function setInfo($id, $username, $password_hash, $full_name, $email, $phone, $avatar, $role, $created_at) {
        $this->id = $id;
        $this->username = $username;
        $this->password_hash = $password_hash;
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
            
            $this->setInfo($user->id, $user->username, "", $user->full_name, $user->email, $user->phone, $user->avatar, $user->role, $user->created_at);
            return true;
        } else {
            return false;
        }
    }

    public function getInfo($username) {
        $this->getInfoFromDB($username);

        return [
            "id" => $this->id,
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

    public function getUsersByRole($role) {
        $query = "SELECT * FROM $this->table WHERE role = :role";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":role", $role);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        $users = [
            ['teacher1', '123456a@A', 'Teacher One', 'teacher1@example.com', '0123456789', 'teacher', 'Class A'],
            ['teacher2', '123456a@A', 'Teacher Two', 'teacher2@example.com', '0987654321', 'teacher', 'Class B'],
            ['student1', '123456a@A', 'Student One', 'student1@example.com', '0111222333', 'student', 'Class A'],
            ['student2', '123456a@A', 'Student Two', 'student2@example.com', '0222333444', 'student', 'Class B'],
        ];
        
        $stmt = $this->conn->prepare("INSERT INTO users (username, password_hash, full_name, email, phone, role, class_name) 
                           VALUES (:username, :password, :full_name, :email, :phone, :role, :class_name)");
        foreach ($users as $user) {
            $stmt->execute([
                'username' => $user[0],
                'password' => password_hash($user[1], PASSWORD_BCRYPT),
                'full_name' => $user[2],
                'email' => $user[3],
                'phone' => $user[4],
                'role' => $user[5],
                'class_name' => $user[6]
            ]);
        }
        
    }
}