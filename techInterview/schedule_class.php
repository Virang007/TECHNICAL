<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "class_management_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$batch_id = $_POST['batch_id'];
$class_date = $_POST['class_date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];

$sql = "INSERT INTO class_schedules (batch_id, class_date, start_time, end_time)
VALUES ($batch_id, '$class_date', '$start_time', '$end_time')";

if ($conn->query($sql) === TRUE) {
    echo "Class scheduled successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
