<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "Model@123";
$dbname = "stdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user inputs
    $trip_no = $_POST['trip_no'];
    $start_place = $_POST['start_place'];
    $end_place = $_POST['end_place'];
    $departure_time = $_POST['departure_time'];
    $remark = $_POST['remark'];

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO trip (trip_no, Start_place, end_place, departure_time, remark) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $trip_no, $start_place, $end_place, $departure_time, $remark);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('New trip record created successfully.');</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Retrieve records
$result = $conn->query("SELECT trip_no, Start_place, end_place, departure_time, remark FROM trip");

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Trip Entry</title>
</head>
<body>
    <h2>Enter Trip Details</h2>
    <form method="POST" action="">
        <label for="trip_no">Trip No:</label><br>
        <input type="text" id="trip_no" name="trip_no" required><br><br>

        <label for="start_place">Start Place:</label><br>
        <input type="text" id="start_place" name="start_place" required><br><br>

        <label for="end_place">End Place:</label><br>
        <input type="text" id="end_place" name="end_place" required><br><br>

        <label for="departure_time">Trip star date and Departure Time:</label><br>
        <input type="datetime-local" id="departure_time" name="departure_time" required><br><br>

        <label for="remark">Remark:</label><br>
        <textarea id="remark" name="remark"></textarea><br><br>

        <button type="submit">Submit</button>
    </form>

    <h2>Trip Records</h2>
    <table border="1">
        <tr>
            <th>Trip No</th>
            <th>Start Place</th>
            <th>End Place</th>
            <th>Departure Time</th>
            <th>Remark</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['trip_no']); ?></td>
                    <td><?php echo htmlspecialchars($row['Start_place']); ?></td>
                    <td><?php echo htmlspecialchars($row['end_place']); ?></td>
                    <td><?php echo htmlspecialchars($row['departure_time']); ?></td>
                    <td><?php echo htmlspecialchars($row['remark']); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No records found.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
