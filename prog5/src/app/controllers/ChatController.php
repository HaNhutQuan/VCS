<?php

class ChatController {
    public function getMessages() {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }
        AuthMiddleware::checkAuth($_SESSION['user']['role']);

        
        return render("chat.php");
    }
}