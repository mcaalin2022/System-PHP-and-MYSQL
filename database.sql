-- Database Schema for Student Management System

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Storing plain text as requested (INSECURE)
    role ENUM('admin', 'student') DEFAULT 'student',
    is_active TINYINT(1) DEFAULT 1, -- For admin to give/take permission
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS student_profiles (
    user_id INT PRIMARY KEY,
    phone VARCHAR(20),
    address TEXT,
    age INT,
    gpa DECIMAL(3, 2),
    class_range VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS student_subjects (
    user_id INT PRIMARY KEY,
    subject1 VARCHAR(100),
    subject2 VARCHAR(100),
    subject3 VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS universities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    location VARCHAR(255),
    description TEXT,
    ranking INT,
    website VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS programs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    university_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    faculty VARCHAR(255),
    gpa_requirement DECIMAL(3, 2),
    description TEXT,
    FOREIGN KEY (university_id) REFERENCES universities(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    program_id INT NOT NULL,
    status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending',
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (program_id) REFERENCES programs(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS faculty_advice (
    id INT AUTO_INCREMENT PRIMARY KEY,
    faculty_name VARCHAR(255),
    min_gpa DECIMAL(3, 2),
    max_gpa DECIMAL(3, 2),
    advice_text TEXT
);

-- Insert Default Admin (Insecure default credentials)
INSERT INTO users (name, email, password, role) VALUES 
('Admin User', 'admin@system.com', 'admin123', 'admin')
ON DUPLICATE KEY UPDATE id=id;
