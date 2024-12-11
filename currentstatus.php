<?php
session_start();

// Check if depot name is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['depoName'])) {
    $_SESSION['selectedDepo'] = $_POST['depoName']; // Store in session
}
$currentDateTime = date("Y-m-d\TH:i");
if (!isset($_SESSION['selectedDepo'])) {
    header("Location: select_depot.php");
    exit();
}

$selectedDepo = $_SESSION['selectedDepo'];

// Database connection
$servername = "localhost";
$username = "root"; // Replace with your DB username
$password = "Model@123"; // Replace with your DB password
$dbname = "stdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch schedules with start_place and end_place for the selected depot
$query = "
    SELECT 
        ts.ScheduleID,
        ts.TripNo,
        ts.ATime,
        ts.DTime,
        ts.DepoName,
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

// Handle form submission to insert data into daily_schedule
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['scheduleID'], $_POST['actualATime'], $_POST['actualDTime'], $_POST['date'])) {
    $scheduleID = $_POST['scheduleID'];
    $actualATime = $_POST['actualATime'];
    $actualDTime = $_POST['actualDTime'];
    $date = $_POST['date'];

    $insertQuery = "INSERT INTO daily_schedule (ScheduleID, actual_atime, actual_dtime, date, DepoName) VALUES (?, ?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("issss", $scheduleID, $actualATime, $actualDTime, $date, $selectedDepo);

    if ($insertStmt->execute()) {
        echo "<p>Data inserted successfully into daily_schedule.</p>";
    } else {
        echo "<p>Error inserting data: " . $conn->error . "</p>";
    }

    $insertStmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Schedules and Insert Data</title>
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
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['ScheduleID']) . "</td>
                    <td>" . htmlspecialchars($row['TripNo']) . "</td>
                    <td>" . htmlspecialchars($row['ATime']) . "</td>
                    <td>" . htmlspecialchars($row['DTime']) . "</td>
                    <td>" . htmlspecialchars($row['start_place']) . "</td>
                    <td>" . htmlspecialchars($row['end_place']) . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No schedules found for the selected depot.</p>";
    }
    ?>

    <h2>Insert Data into Daily Schedule</h2>
    <form method="POST" action="">
        <label for="scheduleID">Schedule ID:</label>
        <input type="number" id="scheduleID" name="scheduleID" required><br><br>

        <label for="actualATime">Actual Arrival Time:</label>
        <input type="time" id="actualATime" name="actualATime" required><br><br>

        <label for="actualDTime">Actual Departure Time:</label>
        <input type="time" id="actualDTime" name="actualDTime" required><br><br>

        <label for="date">Date and Time:</label>
    <input type="datetime-local" id="date" name="date" value="<?php echo $currentDateTime; ?>" required><br><br>
<br><br>

        <input type="submit" value="Insert Data">
    </form>
</body>
</html>
