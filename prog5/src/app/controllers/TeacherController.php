<?php

class TeacherController {
    public function home() {
        AuthMiddleware::checkAuth("teacher");
        echo "Teacher Home";
    }
}