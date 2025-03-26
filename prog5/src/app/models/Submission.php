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
            
            $sqlCheck = "SELECT id FROM student_assignments WHERE student_id = :student_id AND assignment_id = :assignment_id";
            $stmtCheck = $this->conn->prepare($sqlCheck);
            $stmtCheck->execute([
                ':student_id' => $studentId,
                ':assignment_id' => $assignmentId
            ]);
            $existingSubmission = $stmtCheck->fetch(PDO::FETCH_ASSOC);

            if ($existingSubmission) {
                
                $sqlDelete = "DELETE FROM student_assignments WHERE student_id = :student_id AND assignment_id = :assignment_id";
                $stmtDelete = $this->conn->prepare($sqlDelete);
                $stmtDelete->execute([
                    ':student_id' => $studentId,
                    ':assignment_id' => $assignmentId
                ]);
            }

            
            $sqlInsert = "INSERT INTO submissions (student_id, assignment_id, file_url, submitted_at) 
                      VALUES (:student_id, :assignment_id, :file_url, NOW())";
            $stmtInsert = $this->conn->prepare($sqlInsert);
            $stmtInsert->execute([
                ':student_id'   => $studentId,
                ':assignment_id' => $assignmentId,
                ':file_url'     => $file_url
            ]);

            // Cập nhật lại trạng thái trong student_assignments
            $sqlUpdate = "INSERT INTO student_assignments (student_id, assignment_id, status, assigned_at)
                      VALUES (:student_id, :assignment_id, 'submitted', NOW())";
            $stmtUpdate = $this->conn->prepare($sqlUpdate);
            $stmtUpdate->execute([
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

    public function getSubmissionById($id) {
        $sql = "SELECT * FROM submissions WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
