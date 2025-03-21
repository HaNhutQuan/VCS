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
        
        if(!$user) {
            http_response_code(404);
            header("Location: /404");
            exit();
        }
        
        $data = [
            "title" => "Thông tin cá nhân",
            "user"  => $user
        ];
        
        return render("profile.php", $data);
    }
}