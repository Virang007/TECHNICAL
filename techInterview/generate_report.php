<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "class_management_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$report_type = $_POST['report_type'];

if ($report_type == 'batch') {
    $sql = "SELECT * FROM batches";
} elseif ($report_type == 'attendance') {
    $sql = "SELECT * FROM attendance";
} else {
    $sql = "SELECT * FROM resource_allocations";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Data: " . json_encode($row) . "<br>";
    }
} else {
    echo "No data found";
}

$conn->close();
?>
