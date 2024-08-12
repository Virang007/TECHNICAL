<?php
$servername = "localhost";
$username = "root";
$password = ""; // Your MySQL root password
$dbname = "class_management_system"; // Assuming you already have this database

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$batch_name = $_POST['batch_name'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$capacity = $_POST['capacity'];

$sql = "INSERT INTO batches (batch_name, start_date, end_date, capacity)
VALUES ('$batch_name', '$start_date', '$end_date', $capacity)";

if ($conn->query($sql) === TRUE) {
    echo "New batch created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
