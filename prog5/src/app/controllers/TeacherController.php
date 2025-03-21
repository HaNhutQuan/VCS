<?php

class TeacherController {
    public function home() {
        AuthMiddleware::checkAuth("teacher");
        
        $userModal = new User();
        $students = $userModal->getUsersByRole("student");
        $data = [
            "title"     => "Bảng điều khiển giáo viên",
            "students"  => $students
        ];
      
        return render("teacher/home.php", $data);
    }
}