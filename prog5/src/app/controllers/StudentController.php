<?php

class StudentController
{

    public function home()
    {
        AuthMiddleware::checkAuth("student");

        $assignmentModal = new Assignment();

        $assignments = $assignmentModal->getAssignmentsByStudentId($_SESSION['user']['id']);
        $data = [
            "title" => "Bảng điều khiển",
            "assignments" => $assignments
        ];


        return render("student/home.php", $data);
    }
    public function getProfile() {}

    public function postSubmissions()
    {
        AuthMiddleware::checkAuth("student");

        $allowFields = ['assignment_id' => true];

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

            $secureUrl = uploadFile($_FILES['file']['tmp_name']);
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

        $submissionModal = new Submission();
        $isSuccess = $submissionModal->submitAssignment($_SESSION['user']['id'], $filteredPost['assignment_id'], "");

        if (!$isSuccess) {
            $_SESSION['errMessage'] = "Nộp bài tập thất bại.";
        } else {
            $_SESSION['successMessage'] = "Nộp bài tập thành công.";
        }


        header("Location: /student/home");
        exit();
    }
}
