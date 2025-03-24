<?php

class TeacherController
{
    public function home()
    {
        AuthMiddleware::checkAuth("teacher");

        $userModal = new User();
        $students = $userModal->getUsersByRole("student");

        $assignmentModal = new Assignment();
        $assignments = $assignmentModal->getAssignmentByTeacherId($_SESSION['user']['id']);

        $submissions = $assignmentModal->getSubmittedAssignments($_SESSION['user']['id']);

        $message = [
            "title" => "Bảng điều khiển",
            'students' => $students,
            'assignments' => $assignments,
            'submissions' => $submissions
        ];

        return render("teacher/home.php", $message);
    }
    public function createAssignment()
    {
        AuthMiddleware::checkAuth("teacher");

        $allowFields = ['teacher_id' => true, 'title' => true, 'description' => true];

        $filteredPost = array_intersect_key($_POST, $allowFields);


        if (count($filteredPost) !== count($_POST)) {
            die("Có trường không hợp lệ trong dữ liệu gửi lên.");
        }
        if (!empty($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $extraTypes = [
                'pdf'  => 'application/pdf',
                'doc'  => 'application/msword',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];

            $result = validateUploadFile($_FILES['file'], $extraTypes);

            if ($result !== true) {
                $_SESSION['errMessage'] = $result;
                header("Location: /teacher/home");
                exit();
            }

            $secureUrl = uploadFile($_FILES['avatar']['tmp_name']);
            if (!$secureUrl || $secureUrl === "Upload failed: No URL returned") {
                $_SESSION['errMessage'] = "Lỗi khi tài liệu lên.";
                header("Location: /teacher/home");
                exit();
            }

            $filteredPost['file_url'] = $secureUrl;
        }
        // else {
        //     $_SESSION['errMessage'] = "Thiếu tài liệu đính kèm.";
        //     header("Location: /teacher/home");
        //     exit();
        // }

        $assignmentModal = new Assignment();
        $assignmentId = $assignmentModal->createAssignmentByTeacherId($filteredPost['teacher_id'], $filteredPost['title'],  $filteredPost['file_url'], $filteredPost['description']);
        $isSuccess = $assignmentModal->assignToAllStudents($assignmentId);


        if (!$isSuccess) {
            $_SESSION['errMessage'] = "Giao bài tập thất bại.";
        } else {
            $_SESSION['successMessage'] = "Giao bài tập thành công.";
        }

        header("Location: /teacher/home");
        exit();
    }

    public function getAssignment()
    {
        AuthMiddleware::checkAuth("teacher");
        $assignId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$assignId) {
            header("Location: /teacher/home");
            exit();
        }

        $assignmentModal = new Assignment();
        $assignment = $assignmentModal->getAssignmentById($assignId);
        $data = [
            "title"     => 'Thông tin bài tập',
            "assignment" => $assignment
        ];
        return render("teacher/assignment.php", $data);
    }

    public function deleteAssignment()
    {
        AuthMiddleware::checkAuth("teacher");
        $assignId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$assignId) {
            header("Location: /teacher/home");
            exit();
        }

        $assignmentModal = new Assignment();
        $isSuccess = $assignmentModal->deleteAssignmentById($assignId);
        //$isSuccess = true;
        if (!$isSuccess) {
            $_SESSION['errMessage'] = "Xóa bài tập thất bại.";
        } else {
            $_SESSION['successMessage'] = "Xóa bài tập thành công.";
        }


        header("Location: /teacher/home");
        exit();
    }

    public function updateAssignment()
    {
        AuthMiddleware::checkAuth("teacher");

        var_dump($_POST);
        var_dump($_FILES);
        die();
    }

    public function getSubmission() {
        AuthMiddleware::checkAuth("teacher");

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            header("Location: /{$_SESSION['user']['role']}/home");
            exit();
        }

        $submissionModal = new Submission();
        $submission = $submissionModal->getSubmissionById($id);
        
        $assignmentModal = new Assignment();
        $assignment = $assignmentModal->getAssignmentById($submission['assignment_id']);

        $userModal = new User();
        $student = $userModal->getUserById($submission['student_id']);

        $data = [
            "title" => "Chi tiết bài nộp",
            "student" => $student,
            "assignment" => $assignment,
            "submission" =>  $submission
        ];
        
        return render("teacher/submission.php", $data);

    }
}
