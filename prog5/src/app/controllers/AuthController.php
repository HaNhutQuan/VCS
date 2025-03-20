<?php

class AuthController
{
    public function getLogin()
    {
        $data = [
            "title" => "Đăng nhập"
        ];
        $user = new User();
        echo $user->getInfo("teacher1")["full_name"];
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

        $user = new User();
        $check = $user->login($_POST["username"], $_POST["password"]);

        if($check) {
            header("Location: /register");
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
        return render("register.php", $data);
    }

    public function postRegister()
    {
        return;
    }
}
