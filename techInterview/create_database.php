<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = ""; // Your MySQL root password
    $dbname = $_POST['dbname'];

    // Create connection
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Create database
    $sql = "CREATE DATABASE $dbname";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully<br>";
    } else {
        echo "Error creating database: " . $conn->error;
    }

    // Select the database
    $conn->select_db($dbname);

    // SQL to create tables
    $batch_table = "CREATE TABLE batches (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        batch_name VARCHAR(255) NOT NULL,
        start_date DATE NOT NULL,
        end_date DATE NOT NULL,
        capacity INT(10) NOT NULL
    )";

    $class_schedule_table = "CREATE TABLE class_schedules (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        batch_id INT(6) UNSIGNED,
        class_date DATE NOT NULL,
        start_time TIME NOT NULL,
        end_time TIME NOT NULL,
        FOREIGN KEY (batch_id) REFERENCES batches(id)
    )";

    $instructors_table = "CREATE TABLE instructors (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        instructor_name VARCHAR(255) NOT NULL,
        available_from TIME,
        available_to TIME
    )";

    $instructor_assignment_table = "CREATE TABLE instructor_assignments (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        class_schedule_id INT(6) UNSIGNED,
        instructor_id INT(6) UNSIGNED,
        FOREIGN KEY (class_schedule_id) REFERENCES class_schedules(id),
        FOREIGN KEY (instructor_id) REFERENCES instructors(id)
    )";

    $resources_table = "CREATE TABLE resources (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        resource_name VARCHAR(255) NOT NULL,
        resource_type VARCHAR(255) NOT NULL,
        available BOOLEAN NOT NULL DEFAULT TRUE
    )";

    $resource_allocation_table = "CREATE TABLE resource_allocations (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        class_schedule_id INT(6) UNSIGNED,
        resource_id INT(6) UNSIGNED,
        FOREIGN KEY (class_schedule_id) REFERENCES class_schedules(id),
        FOREIGN KEY (resource_id) REFERENCES resources(id)
    )";

    $attendance_table = "CREATE TABLE attendance (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        class_schedule_id INT(6) UNSIGNED,
        student_id INT(6) UNSIGNED,
        status VARCHAR(50),
        FOREIGN KEY (class_schedule_id) REFERENCES class_schedules(id)
    )";

    $users_table = "CREATE TABLE users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(50) NOT NULL
    )";

    $tables = [
        $batch_table, 
        $class_schedule_table, 
        $instructors_table, 
        $instructor_assignment_table, 
        $resources_table,
        $resource_allocation_table, 
        $attendance_table, 
        $users_table
    ];

    foreach ($tables as $table) {
        if ($conn->query($table) === TRUE) {
            echo "Table created successfully<br>";
        } else {
            echo "Error creating table: " . $conn->error . "<br>";
        }
    }

    $conn->close();
}
?>
