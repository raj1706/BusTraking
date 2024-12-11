<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Replace with your DB username
$password = "Model@123"; // Replace with your DB password
$dbname = "stdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch distinct depot names from the trip_schedule table
$query = "SELECT DISTINCT DepoName FROM trip_schedule";
$result = $conn->query($query);

$depoNames = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $depoNames[] = $row['DepoName'];
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Select Depot</title>
</head>
<body>
    <h2>Select Your Current Depot</h2>
    <form method="POST" action="currentstatus.php">
        <label for="depoName">Depot Name:</label>
        <select id="depoName" name="depoName" required>
            <option value="">--Select Depot--</option>
            <?php
            foreach ($depoNames as $depo) {
                echo "<option value=\"" . htmlspecialchars($depo) . "\">" . htmlspecialchars($depo) . "</option>";
            }
            ?>
        </select><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
