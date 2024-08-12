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
$instructor_id = $_POST['instructor_id'];

$sql = "INSERT INTO instructor_assignments (class_schedule_id, instructor_id)
VALUES ($class_schedule_id, $instructor_id)";

if ($conn->query($sql) === TRUE) {
    echo "Instructor assigned successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
