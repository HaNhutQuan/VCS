<?php

class UserController
{
    public function getProfile($userId = null)
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }
        AuthMiddleware::checkAuth($_SESSION['user']['role']);

        $userId = $userId ?? filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$userId) {
            header("Location: /{$_SESSION['user']['role']}/home");
            exit();
        }

        $userModel = new User();
        $user = $userModel->getUserById($userId);

        if (!$user) {
            http_response_code(404);
            header("Location: /404");
            exit();
        }
        $message = [
            "title" => "Thông tin cá nhân",
            'user' => $user
        ];
        return render("profile.php", $message);
    }

    public function updateProfile()
    {
        AuthMiddleware::checkAuth($_SESSION['user']['role']);
        $role = $_SESSION['user']['role'];

        $userId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$userId) {
            header("Location: /{$_SESSION['user']['role']}/home");
            exit();
        }

        $message = ["title" => "Thông tin cá nhân",];

        $allowedFields = [
            "teacher" => ["username", "password", "full_name", "email", "phone"],
            "student" => ["password", "email", "phone"]
        ];

        $validKeys = array_fill_keys($allowedFields[$role], true);
        $formData = array_intersect_key($_POST, $validKeys);

        if (!empty($formData["password"])) {
            $formData["password"] = password_hash($formData["password"], PASSWORD_BCRYPT);
        } else {
            unset($formData["password"]);
        }

        if (!empty($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $result = validateUploadFile($_FILES['avatar']);

            if ($result !== true) {
                $_SESSION['errMessage'] = $result;
                header("Location: /profile?id=$userId");
                exit();
            }

            $secureUrl = uploadFile($_FILES['avatar']['tmp_name']);
            if (!$secureUrl || $secureUrl === "Upload failed: No URL returned") {
                $_SESSION["errMessage"] = "Lỗi khi tải ảnh lên.";
                header("Location: /profile?id=$userId");
                exit();
            }

            $formData['avatar_url'] = $secureUrl;
        }
        die();
        $userModel = new User();
        $isSuccess = $userModel->updateUserById($userId, $formData);

        if (!$isSuccess) {
            $_SESSION['errMessage'] = "Cập nhật thông tin thất bại.";
        } else {
            $_SESSION['successMessage'] = "Cập nhật thông tin thành công.";
        }

        header("Location: /profile?id=$userId");
        exit();
    }

    public function getDeleteUser()
    {
        AuthMiddleware::checkAuth("teacher");
        $userId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$userId) {
            header("Location: /{$_SESSION['user']['role']}/home");
            exit();
        }

        $userModal = new User();
        $isSuccess = $userModal->deleteUserById($userId);

        if (!$isSuccess) {
            $_SESSION['errMessage'] = "Xóa sinh viên thất bại";
            header("Location: /profile?id={$userId}");
            exit();
        }

        // Return the teacher's profile
        $_SESSION['successMessage'] = "Xóa sinh viên thành công.";
        header("Location: /profile?id={$_SESSION['user']['id']}");
        exit();
    }
}
