<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Get the username from the session
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .dashboard-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
            text-align: center;
        }
        .dashboard-container h1 {
            margin-bottom: 20px;
        }
        .banner {
            width: 100%;
            height: 200px;
            background-color: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 1.5rem;
            border-radius: 8px;
        }
        .links {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        .links a {
            padding: 10px 20px;
            background-color: #5cb85c;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .links a:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="banner">
            Welcome to the Dashboard, <?php echo htmlspecialchars($username); ?>!&nbsp;&nbsp;
            <a href="logout.php" style="margin-top: 5px; display: inline-block; padding: 5px 5px; background: #d9534f; color: #fff; text-decoration: none; border-radius: 4px;">Logout</a>
        </div>
        <h1>Dashboard</h1>
        <p>Navigate through the following links:</p>
        <div class="links">
            <a href="Addrute.php">Add Route</a>
            <a href="addschedule.php">Add Schedule</a>
            <a href="select_depot.php">Todays Arrival & Departure</a>
            <a href="reports.php">Reports</a>
            <a href="help.php">Help</a>
        </div>
        
    </div>
</body>
</html>
