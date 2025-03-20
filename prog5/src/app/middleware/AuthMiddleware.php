<?php

class AuthMiddleware {
    public static function checkAuth($requireRole) {
        
        if(!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        if($_SESSION['user']['role'] !== $requireRole) {
            http_response_code(404);
            header("Location: /404");
            exit();
        }

        return true;
    }
}