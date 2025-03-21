<?php

class StudentController {

    public function home() {
        AuthMiddleware::checkAuth("student");
        echo "Student Page";
    }
    public function getProfile() {
        
    }   
}