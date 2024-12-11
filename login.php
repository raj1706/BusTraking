<?php
// Start session to track user login
session_start();

// Define hardcoded credentials for demonstration purposes
$valid_username = "admin";
$valid_password = "password123";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check if credentials are valid
    if ($username === $valid_username && $password === $valid_password) {
        // Set session variable to indicate login status
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: dashboard.php"); // Redirect to a dashboard page
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
        }
        .login-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .login-container input {
            width: 300px;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .login-container form{
          text-align: center;
        }
        .login-container button {
            width: 300px;
            padding: 10px;
            background: #5cb85c;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .login-container button:hover {
            background: #4cae4c;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bus status</title>
  
  <link rel="stylesheet" href="styles.css">

</head>
<body>
   <div class="page-container">
    <div class="nav">
      <nav>
        <div class="logo">
          <img src="b1.jpg" alt="logo">
          <div class="title">
            Real-Time Bus
          </div>
        </div>
       <ul>
        <li class="active"> 
          <a href="/index.php">Home</a>
        </li>
        <li> 
          <a href="/about.html">About</a>
        </li>
        <li> 
          <a href="/bus.php">Live Bus</a>
        </li>
        <li> 
          <a href="/contact.html">Contact</a>
        </li>
        <li> 
          <a href="/Login.php">Login</a>
        </li>
       </ul>
      </nav>
    </div>

    <div class="banner">
      <div class="heading">
        <img src="b1.jpg" alt="" height="150px" width="300px"><br/>
        <b>Welcome to Real-Time Bus Tracking System</b> <br />
        <small>Here we provides accurate and up-to-date information about bus location. </small>
      </div>
    </div>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (!empty($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
           <input type="text" name="username" placeholder="Username" required><br/>
            <input type="password" name="password" placeholder="Password" required><br/>
            <button type="submit">Login</button><br/>
        </form>
    <div class="maintext">

    </div>
    <!--<div class="subtext">
      <div class="red">
        <h3>HTML</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit aliquid sed totam iure voluptatum ipsa quae. Quidem excepturi veritatis odit explicabo consequatur ad consequuntur nostrum eaque numquam! Voluptates, beatae vitae!</p>
      </div>
      <div class="yellow">
        <h3>CSS</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit aliquid sed totam iure voluptatum ipsa quae. Quidem excepturi veritatis odit explicabo consequatur ad consequuntur nostrum eaque numquam! Voluptates, beatae vitae!</p>
      </div>
      <div class="green">
        <h3>Web Development</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit aliquid sed totam iure voluptatum ipsa quae. Quidem excepturi veritatis odit explicabo consequatur ad consequuntur nostrum eaque numquam! Voluptates, beatae vitae!</p>
      </div>
    </div>
    <h3 class="title">Projects</h3>
    <div class="projects">
      <div class="project">
        <img src="https://api.dicebear.com/9.x/pixel-art/svg" alt="" width="100px" height="100px">
        <h4>Project 1</h4>
        <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo earum explicabo doloribus est provident minus vero. Repudiandae perferendis reiciendis quis, totam in expedita odio quidem dolorem quasi officia, recusandae quos.
        </p>
      </div>
      <div class="project">
        <img src="https://api.dicebear.com/9.x/adventurer/svg?seed=Brian" alt="" width="100px" height="100px">
        <h4>Project 2</h4>
        <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo earum explicabo doloribus est provident minus vero. Repudiandae perferendis reiciendis quis, totam in expedita odio quidem dolorem quasi officia, recusandae quos.
        </p>
      </div>
      <div class="project">
        <img src="https://api.dicebear.com/9.x/adventurer/svg?seed=Sophia
        " alt="" width="100px" height="100px">
        <h4>Project 3</h4>
        <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo earum explicabo doloribus est provident minus vero. Repudiandae perferendis reiciendis quis, totam in expedita odio quidem dolorem quasi officia, recusandae quos.
        </p>
      </div>
    </div>-->
    <blockquote class="quote"> 
      माझी एस. टी, माझा अभिमान.
    </blockquote>
    <div class="footer">
      copyright &copy; Model
    </div>
   </div>
</body>
</html>