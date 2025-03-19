<?php

class AuthController {
    public function getLogin() {
        $data = [
            "title" => "Đăng nhập"
        ];

        return render("login.php", $data);
    }

    public function postLogin() {
        return;
    }

    public function getRegister() {
        $data = [
            "title" => "Đăng ký"
        ];
        return render("register.php", $data);
    }

    public function postRegister() {
        return;
    }
}