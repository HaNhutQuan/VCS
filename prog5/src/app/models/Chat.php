<?php

class Chat
{
    private $conn;
    private $table = "messages";

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }
    public function getMessagesBetweenUsers($user1, $user2)
    {
        $sql = "SELECT * FROM $this->table 
                WHERE (sender_id = :user1 AND receiver_id = :user2) 
                OR (sender_id = :user2 AND receiver_id = :user1) 
                ORDER BY created_at ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":user1", $user1, PDO::PARAM_INT);
        $stmt->bindValue(":user2", $user2, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function createMessageBetweenUsers($sender_id, $receiver_id, $content)
    {
        $sql = "INSERT INTO $this->table (sender_id, receiver_id, content) VALUES
                (:sender_id, :receiver_id, :content)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':sender_id' => $sender_id, 'receiver_id' => $receiver_id, 'content' => $content]);
    }

    public function deleteMessageById($messageId)
    {
        $sql = "DELETE FROM $this->table WHERE id = :id AND sender_id = :sender_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id", $messageId, PDO::PARAM_INT);
        $stmt->bindValue(":sender_id", $_SESSION['user']['id'], PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }
    public function updateMessageContentById($messageId, $newContent)
    {
        $sql = "UPDATE $this->table 
            SET content = :content 
            WHERE id = :id AND sender_id = :sender_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':content', $newContent);
        $stmt->bindParam(':id', $messageId);
        $stmt->bindParam(':sender_id', $_SESSION['user']['id']);
        return $stmt->execute();
    }
}
