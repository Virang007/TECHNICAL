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
$resource_id = $_POST['resource_id'];

$sql = "INSERT INTO resource_allocations (class_schedule_id, resource_id)
VALUES ($class_schedule_id, $resource_id)";

if ($conn->query($sql) === TRUE) {
    echo "Resource allocated successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
