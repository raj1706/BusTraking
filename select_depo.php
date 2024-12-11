<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "Model@123";
$dbname = "stdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch distinct depot names
$query = "SELECT DISTINCT DepoName FROM trip_schedule";
$result = $conn->query($query);

if (!$result) {
    die("Error fetching depot names: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Select Depot</title>
</head>
<body>
    <h2>Select Your Depot</h2>
    <form method="POST" action="view_schedules.php">
        <label for="depoName">Depot Name:</label>
        <select id="depoName" name="depoName" required>
            <option value="" disabled selected>Select a depot</option>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . htmlspecialchars($row['DepoName']) . "'>" . htmlspecialchars($row['DepoName']) . "</option>";
            }
            ?>
        </select><br><br>
        <input type="submit" value="View Schedules">
    </form>
</body>
</html>
