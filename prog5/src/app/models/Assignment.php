<?php

class Assignment
{
    private $conn;
    private $table = "assignments";

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function getAssignmentById($assignmentId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :assignment_id LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':assignment_id' => $assignmentId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteAssignmentById($assignmentId)
    {
        try {
            $this->conn->beginTransaction();


            $sql = "DELETE FROM submissions WHERE assignment_id = :assignment_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':assignment_id' => $assignmentId]);


            $sql = "DELETE FROM student_assignments WHERE assignment_id = :assignment_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':assignment_id' => $assignmentId]);


            $sql = "DELETE FROM {$this->table} WHERE id = :assignment_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':assignment_id' => $assignmentId]);

            $this->conn->commit();

            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Lỗi khi xóa assignment: " . $e->getMessage());
            return false;
        }
    }



    public function createAssignmentByTeacherId($teacherId, $title, $fileUrl, $description = null)
    {
        $sql = "INSERT INTO {$this->table} (teacher_id, title, description, file_url) 
                VALUES (:teacher_id, :title, :description, :file_url)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':teacher_id' => $teacherId,
            ':title' => $title,
            ':description' => $description,
            ':file_url' => $fileUrl
        ]);

        return $this->conn->lastInsertId();
    }

    public function getAssignmentByTeacherId($teacherId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE teacher_id = :teacher_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":teacher_id", $teacherId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);;
    }

    public function getAssignmentsByStudentId($studentId)
    {
        $sql = "SELECT 
                    sa.id AS student_assignment_id,
                    a.id AS assignment_id,
                    a.title,
                    a.description,
                    a.file_url,
                    a.created_at,
                    sa.assigned_at,
                    sa.status
                FROM student_assignments sa
                JOIN assignments a ON sa.assignment_id = a.id
                WHERE sa.student_id = :student_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":student_id", $studentId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function assignToAllStudents($assignmentId)
    {
        $sql = "INSERT INTO student_assignments (student_id, assignment_id)
                SELECT id, :assignment_id FROM users WHERE role = 'student'";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':assignment_id' => $assignmentId]);
    }

    public function updateAssignmentById($assignmentId, $title, $description, $fileUrl = null)
    {
        try {
            $sql = "UPDATE assignments 
                SET title = :title, description = :description, file_url = :file_url WHERE id = :assignment_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':assignment_id', $assignmentId, PDO::PARAM_INT);
            $stmt->bindParam(':file_url', $fileUrl, PDO::PARAM_STR);


            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Lỗi khi cập nhật assignment: " . $e->getMessage());
            return false;
        }
    }

    public function getSubmittedAssignments($teacherId)
    {

        $sql = "SELECT 
                    a.id AS assignment_id,
                    a.title,
                    a.description,
                    a.file_url AS assignment_file,
                    a.created_at,
                    s.id AS submission_id,
                    s.file_url AS submission_file,
                    s.submitted_at,
                    u.id AS student_id,
                    u.full_name AS full_name
                FROM submissions s
                JOIN assignments a ON s.assignment_id = a.id
                JOIN users u ON s.student_id = u.id
                WHERE a.teacher_id = :teacher_id
                ORDER BY s.submitted_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':teacher_id' => $teacherId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatusSubmitById($assignmentId)
    {
        $sql = "UPDATE student_assignments 
        SET status = 'teacher_updated' 
        WHERE assignment_id = :assignment_id";

        $statusStmt = $this->conn->prepare($sql);
        return $statusStmt->execute([':assignment_id' => $assignmentId]);
    }
}
