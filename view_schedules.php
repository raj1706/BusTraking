<?php
session_start();

// Check if depot name is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['depoName'])) {
    $_SESSION['selectedDepo'] = $_POST['depoName']; // Store depot name in session
}

if (!isset($_SESSION['selectedDepo'])) {
    header("Location: select_depo.php");
    exit();
}

$selectedDepo = $_SESSION['selectedDepo'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "Model@123";
$dbname = "stdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch schedules for the selected depot
$query = "
    SELECT 
        ts.ScheduleID,
        ts.TripNo,
        ts.ATime,
        ts.DTime,
        t.start_place,
        t.end_place
    FROM 
        trip_schedule ts
    JOIN 
        trip t ON ts.TripNo = t.trip_no
    WHERE 
        ts.DepoName = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $selectedDepo);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Schedules</title>
</head>
<body>
    <h2>Schedules for Depot: <?php echo htmlspecialchars($selectedDepo); ?></h2>

    <?php
    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ScheduleID</th>
                    <th>TripNo</th>
                    <th>Arrival Time</th>
                    <th>Departure Time</th>
                    <th>Start Place</th>
                    <th>End Place</th>
                    <th>Action</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['ScheduleID']) . "</td>
                    <td>" . htmlspecialchars($row['TripNo']) . "</td>
                    <td>" . htmlspecialchars($row['ATime']) . "</td>
                    <td>" . htmlspecialchars($row['DTime']) . "</td>
                    <td>" . htmlspecialchars($row['start_place']) . "</td>
                    <td>" . htmlspecialchars($row['end_place']) . "</td>
                    <td><a href='trip_details.php?scheduleID=" . urlencode($row['ScheduleID']) . "&tripNo=" . urlencode($row['TripNo']) . "'>View More</a></td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No schedules found for the selected depot.</p>";
    }
    ?>
</body>
</html>
