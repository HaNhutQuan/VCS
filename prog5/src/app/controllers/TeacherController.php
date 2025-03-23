<?php

class TeacherController {
    public function home($message = ["title" => "Bảng điều khiển giáo viên"]) {
        AuthMiddleware::checkAuth("teacher");
        
        $userModal = new User();
        $students = $userModal->getUsersByRole("student");
        
        $assignmentModal = new Assignment();
        $assignments = $assignmentModal->getAssignmentByTeacherId($_SESSION['user']['id']);

        $message['students'] = $students;
        $message['assignments'] = $assignments;

        return render("teacher/home.php", $message);
    }
    public function createAssignment() {
        AuthMiddleware::checkAuth("teacher");

        $assignmentModal = new Assignment();
        $assignmentId = $assignmentModal->createAssignmentByTeacherId($_SESSION['user']['id'], "", "", "");
        $isSuccess = $assignmentModal->assignToAllStudents($assignmentId);

        return render("teacher/home.php");
    }
}