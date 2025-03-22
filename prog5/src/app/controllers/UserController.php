<?php

class UserController
{
    public function getProfile($userId = null, $message = ["title" => "Thông tin cá nhân"])
    {
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
        $message['user'] = $user;
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
        
        $message = [
            "title"           => "Thông tin cá nhân",
            "errMessage"      => "",
            "successMessage"  => ""   
        ];

        $allowedFields = [
            "teacher" => ["username", "password", "full_name", "email", "phone"],
            "student" => ["password", "email", "phone"]
        ];

        $formData = array_intersect_key($_POST, array_flip($allowedFields[$role]));

        if (!empty($formData["password"])) {
            $formData["password"] = password_hash($formData["password"], PASSWORD_BCRYPT);
        } else {
            unset($formData["password"]);
        }

        if (!empty($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $result = validateUploadFile($_FILES['avatar']);

            if ($result !== true) {
               $message['errMessage'] = $result;
               return $this->getProfile($userId, $message);
            }

            $secureUrl = uploadFile($_FILES['avatar']['tmp_name']);
            if (!$secureUrl || $secureUrl === "Upload failed: No URL returned") {
                $message["errMessage"] = "Lỗi khi tải ảnh lên.";
                return $this->getProfile($userId, $message);
            }

            $formData['avatar_url'] = $secureUrl;
        }
        die();
        $userModel = new User();
        $isSuccess = $userModel->updateUserById($userId, $formData);

        if (!$isSuccess) {
            $message['errMessage'] = "Cập nhật thông tin thất bại.";
            return $this->getProfile($userId, $message);
        }

        $message['successMessage'] = "Cập nhật thông tin thành công.";
        return $this->getProfile($userId, $message);
    }
}
