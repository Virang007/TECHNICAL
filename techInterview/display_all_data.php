<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            margin-top: 50px;
        }
        form {
            display: inline;
        }
        .form-container {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            margin-top: 50px;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .message {
            color: green;
            margin-bottom: 20px;
        }
        .error {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <h1>Class Management System</h1>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = ""; // Your MySQL root password
    $dbname = "class_management_system";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle delete request
    if (isset($_GET['delete']) && isset($_GET['table'])) {
        $id = intval($_GET['delete']);
        $table = $_GET['table'];
        $sql = "DELETE FROM $table WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo "<p class='message'>Record deleted successfully from $table</p>";
        } else {
            echo "<p class='error'>Error deleting record: " . $conn->error . "</p>";
        }
    }

    // Handle edit request
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['table']) && isset($_POST['id'])) {
        $table = $_POST['table'];
        $id = intval($_POST['id']);
        $columns = array_keys($_POST);
        $values = array_values($_POST);
        $updates = [];

        foreach ($columns as $index => $column) {
            if ($column != 'table' && $column != 'id') { // Exclude table and id fields
                $updates[] = "$column = '" . $conn->real_escape_string($values[$index]) . "'";
            }
        }

        $sql = "UPDATE $table SET " . implode(", ", $updates) . " WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo "<p class='message'>Record updated successfully in $table</p>";
        } else {
            echo "<p class='error'>Error updating record: " . $conn->error . "</p>";
        }
    }

    // Fetch and display data from each table
    function displayTable($conn, $tableName, $columns) {
        $sql = "SELECT * FROM $tableName";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>$tableName</h2>";
            echo "<table>";
            echo "<tr>";

            // Display column headers
            foreach ($columns as $column) {
                echo "<th>$column</th>";
            }
            echo "<th>Actions</th>"; // Add an Actions column
            echo "</tr>";

            // Display rows
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($columns as $column) {
                    echo "<td>" . $row[$column] . "</td>";
                }
                echo "<td>";
                echo "<a href='?edit=" . $row['id'] . "&table=$tableName'>Edit</a> | ";
                echo "<a href='?delete=" . $row['id'] . "&table=$tableName' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<h2>$tableName</h2><p>No data found</p>";
        }
    }

    // Handle display of the edit form
    if (isset($_GET['edit']) && isset($_GET['table'])) {
        $id = intval($_GET['edit']);
        $table = $_GET['table'];
        $sql = "SELECT * FROM $table WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<div class='form-container'>";
            echo "<h2>Edit Record in $table</h2>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='table' value='$table'>";
            echo "<input type='hidden' name='id' value='$id'>";

            foreach ($row as $column => $value) {
                if ($column != 'id') { // Don't allow editing the ID
                    echo "<label for='$column'>$column</label>";

                    if ($column == 'start_date' || $column == 'end_date') {
                        // Use a date picker for date fields
                        echo "<input type='date' name='$column' id='$column' value='$value'>";
                    } elseif ($column == 'available_from' || $column == 'available_to' || $column == 'start_time' || $column == 'end_time') {
                        // Use a time picker for time fields
                        echo "<input type='time' name='$column' id='$column' value='$value'>";
                    } else {
                        echo "<input type='text' name='$column' id='$column' value='$value'>";
                    }
                }
            }

            echo "<button type='submit'>Update</button>";
            echo "</form>";
            echo "</div>";
        } else {
            echo "<p class='error'>Record not found</p>";
        }
    }

    // Define columns for each table
    $tables = [
        "batches" => ["id", "batch_name", "start_date", "end_date", "capacity"],
        "class_schedules" => ["id", "batch_id", "class_date", "start_time", "end_time"],
        "instructors" => ["id", "instructor_name", "available_from", "available_to"]
    ];

    // Display tables
    foreach ($tables as $tableName => $columns) {
        displayTable($conn, $tableName, $columns);
    }

    // Close connection
    $conn->close();
    ?>

</body>
</html>
