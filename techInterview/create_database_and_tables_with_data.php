<?php
$servername = "localhost";
$username = "root";
$password = ""; // Your MySQL root password

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS class_management_system";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select the database
$conn->select_db("class_management_system");

// SQL to create tables
$tables = [
    "CREATE TABLE IF NOT EXISTS batches (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        batch_name VARCHAR(255) NOT NULL,
        start_date DATE NOT NULL,
        end_date DATE NOT NULL,
        capacity INT(10) NOT NULL
    )",

    "CREATE TABLE IF NOT EXISTS class_schedules (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        batch_id INT(6) UNSIGNED,
        class_date DATE NOT NULL,
        start_time TIME NOT NULL,
        end_time TIME NOT NULL,
        FOREIGN KEY (batch_id) REFERENCES batches(id)
    )",

    "CREATE TABLE IF NOT EXISTS instructors (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        instructor_name VARCHAR(255) NOT NULL,
        available_from TIME,
        available_to TIME
    )",

    "CREATE TABLE IF NOT EXISTS instructor_assignments (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        class_schedule_id INT(6) UNSIGNED,
        instructor_id INT(6) UNSIGNED,
        FOREIGN KEY (class_schedule_id) REFERENCES class_schedules(id),
        FOREIGN KEY (instructor_id) REFERENCES instructors(id)
    )",

    "CREATE TABLE IF NOT EXISTS resources (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        resource_name VARCHAR(255) NOT NULL,
        resource_type VARCHAR(255) NOT NULL,
        available BOOLEAN NOT NULL DEFAULT TRUE
    )",

    "CREATE TABLE IF NOT EXISTS resource_allocations (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        class_schedule_id INT(6) UNSIGNED,
        resource_id INT(6) UNSIGNED,
        FOREIGN KEY (class_schedule_id) REFERENCES class_schedules(id),
        FOREIGN KEY (resource_id) REFERENCES resources(id)
    )",

    "CREATE TABLE IF NOT EXISTS attendance (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        class_schedule_id INT(6) UNSIGNED,
        student_id INT(6) UNSIGNED,
        status VARCHAR(50),
        FOREIGN KEY (class_schedule_id) REFERENCES class_schedules(id)
    )",

    "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(50) NOT NULL
    )"
];

// Execute each table creation query
foreach ($tables as $table) {
    if ($conn->query($table) === TRUE) {
        echo "Table created successfully<br>";
    } else {
        echo "Error creating table: " . $conn->error . "<br>";
    }
}

// Insert dummy data
$dummy_data = [
    "INSERT INTO batches (batch_name, start_date, end_date, capacity) VALUES 
        ('Batch 2024-A', '2024-09-01', '2024-12-15', 30),
        ('Batch 2024-B', '2024-10-01', '2025-01-15', 25)",

    "INSERT INTO class_schedules (batch_id, class_date, start_time, end_time) VALUES 
        (1, '2024-09-10', '09:00:00', '11:00:00'),
        (1, '2024-09-11', '14:00:00', '16:00:00'),
        (2, '2024-10-05', '10:00:00', '12:00:00')",

    "INSERT INTO instructors (instructor_name, available_from, available_to) VALUES 
        ('John Doe', '08:00:00', '17:00:00'),
        ('Jane Smith', '09:00:00', '15:00:00')",

    "INSERT INTO resources (resource_name, resource_type, available) VALUES 
        ('Projector', 'Equipment', TRUE),
        ('Whiteboard', 'Equipment', TRUE)",
        
    "INSERT INTO users (username, password, role) VALUES 
        ('admin', 'admin123', 'Administrator'),
        ('instructor1', 'pass123', 'Instructor'),
        ('coordinator1', 'coordpass', 'Coordinator')"
];

// Execute each data insertion query
foreach ($dummy_data as $data) {
    if ($conn->query($data) === TRUE) {
        echo "Dummy data inserted successfully<br>";
    } else {
        echo "Error inserting data: " . $conn->error . "<br>";
    }
}

// Close connection
$conn->close();
?>
