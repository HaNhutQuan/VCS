<?php

class TeacherController {
    public function home() {
        AuthMiddleware::checkAuth("teacher");
        $data = [
            "title" => "Bảng điều khiển giáo viên"
        ];
        $userModal = new User();
        $students = $userModal->getUsersByRole("student");
        $data["students"] = $students;
        
        return render("teacher/home.php", $data);
    }
}