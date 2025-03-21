<?php

class UserController
{
    public function getProfile()
    {
        AuthMiddleware::checkAuth($_SESSION['user']['role']);

        if (!isset($_GET['id'])) {
            die("Thiếu ID người dùng");
        }

        $userId = $_GET['id'];
        $userModal = new User();
        $user = $userModal->getUserById($userId);

        if (!$user) {
            http_response_code(404);
            header("Location: /404");
            exit();
        }

        $data = [
            "title" => "Thông tin cá nhân",
            "user"  => $user
        ];

        return render("profile.php", $data);
    }

    public function updateProfile()
    {
        AuthMiddleware::checkAuth($_SESSION['user']['role']);
        $role = $_SESSION['user']['role'];

        if (!isset($_POST["id"])) {
            die("Thiếu ID người dùng");
        }

        $allow_list = [
            "teacher" => [
                "username",
                "password",
                "full_name",
                "email",
                "phone"
            ],
            "student" => [
                "password",
                "email",
                "phone"
            ]
        ];

        $formData = array_diff_key($_POST, ['id' => '']);
        $id = $_POST["id"];
        
        foreach ($formData as $key => $value) {
            if (!in_array($key, $allow_list[$role])) {
                http_response_code(403);
                die("Bạn không có quyền cập nhật trường thông tin: " . htmlspecialchars($key));
            }
            if (empty($value) && $key === "password") {
                unset($formData[$key]);
            }
        }

        // Handle upload file
        
        var_dump(uploadFile($_FILES["avatar"]["tmp_name"]));
        die();

        $userModal = new User();
        $isSuccess = $userModal->updateUserById($id, $formData);
        $isSuccess ? $successMessage = "Cập nhật thông tin thành công" : $errMessage = "Cập nhật thông tin thất bại";
        
        $data = [
            "title" => "Thông tin cá nhân",
            "successMessage" => $successMessage,
            "errMessage"     => $errMessage
        ];
        
        return render("profile.php", $data);
    }
}
