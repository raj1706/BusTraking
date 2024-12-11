<?php
// Database connection
$servername = "localhost";
$username = "root"; // replace with your DB username
$password = "Model@123"; // replace with your DB password
$dbname = "stdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch distinct DepoName values for the dropdown
$query = "SELECT DISTINCT DepoName FROM trip_schedule";
$result = $conn->query($query);
$depoNames = [];

while ($row = $result->fetch_assoc()) {
    $depoNames[] = $row['DepoName'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $scheduleID = $_POST['ScheduleID'];
    $tripNo = $_POST['TripNo'];
    $aTime = $_POST['ATime'];
    $dTime = $_POST['DTime'];
    $depoName = $_POST['DepoName'];

    // Check if 'Other' is selected and get the custom depot name
    if ($depoName === 'other') {
        $depoName = $_POST['OtherDepoName'];
    }

    // Insert data into trp table
    $stmt = $conn->prepare("INSERT INTO trip_schedule (ScheduleID, TripNo, ATime, DTime, DepoName) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $scheduleID, $tripNo, $aTime, $dTime, $depoName);

    if ($stmt->execute()) {
        echo "Record added successfully!<br><br>";
    } else {
        echo "Error: " . $stmt->error . "<br><br>";
    }

    $stmt->close();
}

// Display all records in the trp table
$query = "SELECT * FROM trip_schedule";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<h2>All Records in the Trip Schedule</h2>";
    echo "<table border='1'>
            <tr>
                <th>Schedule ID</th>
                <th>Trip No</th>
                <th>Arrival Time</th>
                <th>Departure Time</th>
                <th>Depot Name</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['ScheduleID']) . "</td>
                <td>" . htmlspecialchars($row['TripNo']) . "</td>
                <td>" . htmlspecialchars($row['ATime']) . "</td>
                <td>" . htmlspecialchars($row['DTime']) . "</td>
                <td>" . htmlspecialchars($row['DepoName']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No records found.<br><br>";
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Trip Schedule Form</title>
</head>
<body>
    <h2>Trip Schedule Entry</h2>
    <form method="POST" action="">
        <label for="ScheduleID">Schedule ID:</label>
        <input type="number" id="ScheduleID" name="ScheduleID" required><br><br>

        <label for="TripNo">Trip No:</label>
        <input type="text" id="TripNo" name="TripNo" required><br><br>

        <label for="ATime">Arrival Time:</label>
        <input type="time" id="ATime" name="ATime" required><br><br>

        <label for="DTime">Departure Time:</label>
        <input type="time" id="DTime" name="DTime" required><br><br>

        <label for="DepoName">Depot Name:</label>
        <select id="DepoName" name="DepoName">
            <?php
            foreach ($depoNames as $name) {
                echo "<option value=\"$name\">$name</option>";
            }
            ?>
            <option value="other">Other (please specify)</option>
        </select><br><br>

        <div id="otherDepoNameDiv" style="display:none;">
            <label for="OtherDepoName">Enter Depot Name:</label>
            <input type="text" id="OtherDepoName" name="OtherDepoName"><br><br>
        </div>

        <script>
            document.getElementById('DepoName').addEventListener('change', function() {
                if (this.value === 'other') {
                    document.getElementByIdx('otherDepoNameDiv').style.display = 'block';
                } else {
                    document.getElementById('otherDepoNameDiv').style.display = 'none';
                }
            });
        </script>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
