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
