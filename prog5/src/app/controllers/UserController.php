<?php

class UserController {
    public function getProfile() {
        AuthMiddleware::checkAuth($_SESSION['user']['role']);

        if(!isset($_GET['id'])) {
            die("Thiếu ID người dùng");
        }

        $userId = $_GET['id'];
        $userModal = new User();
        $user = $userModal->getUserById($userId);
        
        $data = [
            "title" => "Thông tin cá nhân",
            "user"  => $user
        ];
        //var_dump($data);
        return render("profile.php", $data);
    }
}