<?php

class ChatController
{
    public function getMessages()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $userId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$userId) {
            $_SESSION['errMessage'] = "Thiếu ID người dùng.";
            header("Location: /student/home");
            exit();
        }

        $userModal = new User();
        $user = $userModal->getUserById($userId);

        if (!$user) {
            $_SESSION['errMessage'] = "Người dùng không tồn tại.";
            header("Location: /student/home");
            exit();
        }

        $chatModal = new Chat();
        $messages = $chatModal->getMessagesBetweenUsers($userId, $_SESSION['user']['id']);

        $data = [
            "title" => "Chat với",
            "user"  => $user,
            "messages" => $messages
        ];

        return render("chat.php", $data);
    }

    public function sendMessage()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }


        $allowFields = ['receiver_id' => true, 'sender_id' => true, 'content' => true];


        $filteredPost = array_intersect_key($_POST, $allowFields);

        if (count($filteredPost) !== count($_POST)) {
            die("Có trường không hợp lệ trong dữ liệu gửi lên.");
        }

        $userModal = new User();
        $receiver = $userModal->getUserById($filteredPost['receiver_id']);
        if (!$receiver) {
            $_SESSION['errMessage'] = "Người dùng không tồn tại.";
            header("Location: /student/home");
            exit();
        }

        $chatModal = new Chat();
        $isSuccess = $chatModal->createMessageBetweenUsers($filteredPost['sender_id'], $filteredPost['receiver_id'], $filteredPost['content']);

        if (!$isSuccess) {
            $_SESSION['errMessage'] = "Gửi tin nhắn không thành công";
        }

        header("Location: /chat?id={$filteredPost['receiver_id']}");
        exit();
    }

    public function editMessage()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }
        $allowFields = ['id' => true, 'receiver_id' => true, 'content' => true];


        $filteredPost = array_intersect_key($_POST, $allowFields);

        if (count($filteredPost) !== count($_POST)) {
            die("Có trường không hợp lệ trong dữ liệu gửi lên.");
        }
        $chatModal = new Chat();
        $isSuccess = $chatModal->updateMessageContentById($filteredPost['id'], $filteredPost['content']);

        if (!$isSuccess) {
            $_SESSION['errMessage'] = "Lỗi, không thể cập nhật tin nhắn.";
        } else {
            $_SESSION['successMessage'] = "Cập nhật tin nhắn thành công.";
        }

        header("Location: /chat?id={$filteredPost['receiver_id']}");
        exit();
    }

    public function deleteMessage()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $messageId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $receiver_id = filter_input(INPUT_POST, 'receiver_id', FILTER_VALIDATE_INT);

        if (!$messageId && $receiver_id) {
            $_SESSION['errMessage'] = "Lỗi, không thể xóa tin nhắn.";
            header("Location: /chat?id=$receiver_id");
            exit();
        } else if (!$messageId || !$receiver_id) {
            $_SESSION['errMessage'] = "Lỗi, không thể xóa tin nhắn.";
            header("Location: /{$_SESSION['user']['role']}/home");
            exit();
        }

        $chatModal = new Chat();
        $isSuccess = $chatModal->deleteMessageById($messageId);

        if (!$isSuccess) {
            $_SESSION['errMessage'] = "Lỗi, không thể xóa tin nhắn.";
        } else {
            $_SESSION['successMessage'] = "Xóa tin nhắn thành công.";
        }

        header("Location: /chat?id=$receiver_id");
        exit();
    }
}
