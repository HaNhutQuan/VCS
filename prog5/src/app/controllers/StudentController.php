<?php

class StudentController
{

    public function home()
    {
        AuthMiddleware::checkAuth("student");

        $userModal = new User();
        $users = $userModal->getUsers();
       
        $assignmentModal = new Assignment();

        $assignments = $assignmentModal->getAssignmentsByStudentId($_SESSION['user']['id']);

        $answerDir = __DIR__ . "/../storage/answers/";
        $uploadDir = __DIR__ . "/../storage/uploads/";
        $answerFiles = glob($answerDir . '*.answer');
        $filenames = [];
        $correctAnswers = [];

        foreach ($answerFiles as $answerFile) {
            if (hasStudentAnswered($_SESSION['user']['id'], $answerFile)) {
                $filename = pathinfo($answerFile, PATHINFO_FILENAME);
                $filenames[] = $filename;

                $correctAnswers[] = [
                    "answer"    => $filename,
                    "content"   => file_get_contents($uploadDir . $filename . ".txt"),
                    "hint"      => file_get_contents($uploadDir . $filename . ".hint")
                ];
            }
        }

        $hintFiles = glob($uploadDir . '*.hint');
        $challenges = [];

        foreach ($hintFiles as $hintFile) {
            $filename = pathinfo($hintFile, PATHINFO_FILENAME);
            if (in_array($filename, $filenames)) {
                continue;
            }
            $hintContent = file_get_contents($hintFile);
            $challenges[] = [
                'hint' => $hintContent
            ];
        }
        
        $data = [
            "title" => "Bảng điều khiển",
            "users" => $users,
            "assignments" => $assignments ?? [],
            "challenges" => $challenges,
            "correctAnswers" => $correctAnswers
        ];


        return render("student/home.php", $data);
    }
    public function getProfile() {}

    public function postSubmission()
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
                header("Location: /student/home");
                exit();
            }

            $secureUrl = uploadFile($_FILES['file']['tmp_name']);
            if (!$secureUrl || $secureUrl === "Upload failed: No URL returned") {
                $_SESSION['errMessage'] = "Lỗi khi tài liệu lên.";
                header("Location: /student/home");
                exit();
            }

            $filteredPost['file_url'] = $secureUrl;
        }
        else {
            $_SESSION['errMessage'] = "Thiếu tài liệu đính kèm.";
            header("Location: /student/home");
            exit();
        }

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
    public function postAnswer()
    {
        AuthMiddleware::checkAuth("student");

        if (!isset($_POST['hint'])) {
            $_SESSION['errMessage'] = "Có lỗi xảy ra.";
            header("Location: /student/home");
            exit();
        }

        if (!isset($_POST['answer'])) {
            $_SESSION['errMessage'] = "Vui lòng điền đáp án.";
            header("Location: /student/home");
            exit();
        }

        $userAnswer = $_POST['answer'];
        $pattern = '/[^a-zA-Z\s]/';

        if (preg_match($pattern, $userAnswer)) {
            $_SESSION['errMessage'] = "Vui lòng điền đáp án không dấu và các từ cách nhau bởi 1 khoảng trắng.";
            header("Location: /student/home");
            exit();
        }

        $userAnswer = strtolower($userAnswer);
        $userHint = normalizeText(strtolower($_POST['hint']));

        $answerDir = __DIR__ . "/../storage/answers";
        if (!is_dir($answerDir)) {
            mkdir($answerDir, 0755, true);
        }

        $uploadDir = __DIR__ . "/../storage/uploads/";
        $hintFiles = glob($uploadDir . '*.hint');
        foreach ($hintFiles as $hintFile) {
            $correctHint  = normalizeText(strtolower(file_get_contents($hintFile)));
            $correctAnswer = pathinfo($hintFile, PATHINFO_FILENAME);

            if ($userHint === $correctHint && $userAnswer === $correctAnswer) {
                $dest = $uploadDir . "../answers/" . $correctAnswer . ".answer";
                file_put_contents($dest, $_SESSION['user']['id'] . PHP_EOL, FILE_APPEND);
                $_SESSION['successMessage'] = "Chúc mừng bạn đã đoán đúng!";
                header("Location: /student/home");
                exit();
            }
        }
        $_SESSION['errMessage'] = "Bạn đã đoán sai!";
        header("Location: /student/home");
        exit();
    }
}
