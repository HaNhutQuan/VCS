<?php

class Submission
{
    private $conn;
    private $table = "submissions";

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function submitAssignment($studentId, $assignmentId, $file_url)
    {
        $this->conn->beginTransaction();

        try {
            // Kiểm tra xem sinh viên đã nộp bài chưa
            $sqlCheck = "SELECT id FROM submissions WHERE student_id = :student_id AND assignment_id = :assignment_id";
            $stmtCheck = $this->conn->prepare($sqlCheck);
            $stmtCheck->execute([
                ':student_id' => $studentId,
                ':assignment_id' => $assignmentId
            ]);
            $existingSubmission = $stmtCheck->fetch(PDO::FETCH_ASSOC);

            if ($existingSubmission) {
                // Nếu đã nộp trước đó, cập nhật file mới
                $sqlUpdateSubmission = "UPDATE submissions SET file_url = :file_url, submitted_at = NOW()
                                    WHERE student_id = :student_id AND assignment_id = :assignment_id";
                $stmtUpdateSubmission = $this->conn->prepare($sqlUpdateSubmission);
                $stmtUpdateSubmission->execute([
                    ':student_id'   => $studentId,
                    ':assignment_id' => $assignmentId,
                    ':file_url'     => $file_url
                ]);
            } else {
                // Nếu chưa nộp, chèn bản ghi mới
                $sqlInsertSubmission = "INSERT INTO submissions (student_id, assignment_id, file_url, submitted_at) 
                                    VALUES (:student_id, :assignment_id, :file_url, NOW())";
                $stmtInsertSubmission = $this->conn->prepare($sqlInsertSubmission);
                $stmtInsertSubmission->execute([
                    ':student_id'   => $studentId,
                    ':assignment_id' => $assignmentId,
                    ':file_url'     => $file_url
                ]);
            }

            // Cập nhật trạng thái trong student_assignments
            $sqlUpdateStatus = "UPDATE student_assignments 
                            SET status = 'submitted', assigned_at = NOW() 
                            WHERE student_id = :student_id AND assignment_id = :assignment_id";
            $stmtUpdateStatus = $this->conn->prepare($sqlUpdateStatus);
            $stmtUpdateStatus->execute([
                ':student_id'   => $studentId,
                ':assignment_id' => $assignmentId
            ]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return "Lỗi khi nộp bài: " . $e->getMessage();
        }
    }

    public function getSubmissionById($id)
    {
        $sql = "SELECT * FROM submissions WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
