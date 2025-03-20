<?php

class AuthController
{
    public function getLogin()
    {
        $data = [
            "title" => "Đăng nhập"
        ];
        return render("login.php", $data);
    }

    public function postLogin()
    {
        $data = [
            "title" => "Đăng nhập",
            "errMessage" => ""
        ];

        $username = $_POST["username"];
        $password = $_POST["password"];

        if(empty($username) || empty($password)) {
            $data["errMessage"] = "Vui lòng nhập đầy đủ thông tin đăng nhập";
            return render("login.php", $data);
        }

        $userModal = new User();
        $user = $userModal->getUserByUsername($username);
        
        if($user && password_verify($password, $user->password)) {
            $_SESSION['user'] = [
                'id' => $user->user_id,
                'username' => $user->username,
                'role' => $user->role
            ];
            //var_dump($_SESSION);
            header("Location: " . ($user->role === "teacher" ? "/teacher/home" : "/student/home"));
            exit();
        }

        $data["errMessage"] = "Thông tin đăng nhập hoặc mật khẩu sai";

        return render("login.php", $data);
    }

    public function getRegister()
    {
        $data = [
            "title" => "Đăng ký"
        ];
        $user = new User();
        $user->register();
        return render("register.php", $data);
    }

    public function postRegister()
    {
        return;
    }

    public function getLogout() {
        session_destroy();
        header("Location: /login");
        exit();
    }
    public function notFound() {
        $data = [
            "title" => "404"
        ];
        return render("404.php", $data);
    }
}
