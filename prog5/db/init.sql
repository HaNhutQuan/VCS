DROP DATABASE IF EXISTS vcs;
CREATE DATABASE vcs;
USE vcs;


DROP TABLE IF EXISTS users;

CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(15),  
    avatar VARCHAR(255),
    role ENUM('teacher', 'student') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- INSERT INTO users (username, password, full_name, email, phone, avatar, role) 
-- VALUES 
-- ('teacher1', '$2y$12$k7t47IIbf/wr/5VpFjMD.e.1/zo1f/qfUmHr6C0M7dcM8r17FtuNG', 
-- 'Thầy giáo ba', 'techer@gmail.com', '0765400898', 'http://example.com', 'teacher');
