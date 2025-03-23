<?php

class Assignment {
    private $conn;
    private $table = "assignments";

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function getAssignmentById($assignmentId) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :assignment_id LIMIT 1";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':assignment_id' => $assignmentId]);
    
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteAssignmentById($assignmentId) {
        $sql = "DELETE FROM {$this->table} WHERE id = :assignment_id";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':assignment_id' => $assignmentId]); 
    }
    
    public function createAssignmentByTeacherId($teacherId, $title, $fileUrl, $description = null) {
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

    public function getAssignmentByTeacherId($teacherId) {
        $sql = "SELECT * FROM {$this->table} WHERE teacher_id = :teacher_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":teacher_id", $teacherId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);;
    }
    
    public function assignToAllStudents($assignmentId) {
        $sql = "INSERT INTO student_assignments (student_id, assignment_id)
                SELECT id, :assignment_id FROM users WHERE role = 'student'";
    
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':assignment_id' => $assignmentId]);
    }
}