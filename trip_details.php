<?php
session_start();

if (!isset($_GET['scheduleID'], $_GET['tripNo'])) {
    header("Location: view_schedules.php");
    exit();
}

$scheduleID = $_GET['scheduleID'];
$tripNo = $_GET['tripNo'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "Model@123";
$dbname = "stdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch trip details for the selected schedule and trip number
$query = "
    SELECT 
        ds.ScheduleID,
        ds.actual_atime,
        ds.actual_dtime,
        ds.date,
        t.start_place,
        t.end_place
    FROM 
        daily_schedule ds
    JOIN 
        trip_schedule ts ON ds.ScheduleID = ts.ScheduleID
    JOIN 
        trip t ON ts.TripNo = t.trip_no
    WHERE 
        ds.ScheduleID = ? AND t.trip_no = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $scheduleID, $tripNo);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Trip Details</title>
</head>
<body>
    <h2>Trip Details</h2>

    <?php
    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ScheduleID</th>
                    <th>Actual Arrival Time</th>
                    <th>Actual Departure Time</th>
                    <th>Date</th>
                    <th>Start Place</th>
                    <th>End Place</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['ScheduleID']) . "</td>
                    <td>" . htmlspecialchars($row['actual_atime']) . "</td>
                    <td>" . htmlspecialchars($row['actual_dtime']) . "</td>
                    <td>" . htmlspecialchars($row['date']) . "</td>
                    <td>" . htmlspecialchars($row['start_place']) . "</td>
                    <td>" . htmlspecialchars($row['end_place']) . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No trip details found for the selected schedule and trip number.</p>";
    }
    ?>
</body>
</html>
