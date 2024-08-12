<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "class_management_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

// Check if the username already exists
$sql_check = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql_check);

if ($result->num_rows > 0) {
    echo "Username already exists. Please choose a different username.";
} else {
    // Insert the new user
    $sql = "INSERT INTO users (username, password, role)
            VALUES ('$username', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "User created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
