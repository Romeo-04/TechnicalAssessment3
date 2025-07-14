-- Activity B Database Setup Script
-- Run this script in phpMyAdmin or MySQL command line

-- Create the database
CREATE DATABASE IF NOT EXISTS sa3_activityb;

-- Use the database
USE sa3_activityb;

-- Create the users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data (optional - for testing purposes)
-- Note: These passwords are hashed versions of 'password123'
INSERT INTO users (firstname, lastname, email, password) VALUES 
('John', 'Doe', 'john.doe@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Jane', 'Smith', 'jane.smith@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Bob', 'Johnson', 'bob.johnson@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Show table structure
DESCRIBE users;

-- Show all users
SELECT id, firstname, lastname, email, created_at FROM users;

-- Show total count
SELECT COUNT(*) as total_users FROM users;
