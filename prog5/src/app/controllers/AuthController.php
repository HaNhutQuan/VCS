<?php

class AuthController {
    public function getLogin() {
        return require_once __DIR__ . "/../views/login/index.php";
    }

    public function postLogin() {
        return;
    }

    public function getRegister() {
        return;
    }

    public function postRegister() {
        return;
    }
}