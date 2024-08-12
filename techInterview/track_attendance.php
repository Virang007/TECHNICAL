<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "class_management_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$class_schedule_id = $_POST['class_schedule_id'];
$student_id = $_POST['student_id'];
$status = $_POST['status'];

$sql = "INSERT INTO attendance (class_schedule_id, student_id, status)
VALUES ($class_schedule_id, $student_id, '$status')";

if ($conn->query($sql) === TRUE) {
    echo "Attendance tracked successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
