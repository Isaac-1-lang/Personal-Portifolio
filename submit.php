<?php
// Database connection setup
$server_name = "localhost";
$username = "root";
$password = "";
$database = "message";

// Create a connection
$connection = new mysqli($server_name, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Set character set to UTF-8
$connection->set_charset("utf8");

// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = password_hash(htmlspecialchars($_POST["password"]), PASSWORD_DEFAULT);  // Hash the password
    $message = htmlspecialchars($_POST["message"]);

    // Basic validation
    if (empty($name) || empty($email) || empty($password) || empty($message)) {
        echo "All fields are required!";
        exit();
    }

    // Prepare SQL statement to insert data into the database
    $stmt = $connection->prepare("INSERT INTO response (Name, Email, PASSWORD, Messaged) VALUES (?, ?, ?, ?)");

    // Bind parameters
    $stmt->bind_param("ssss", $name, $email, $password, $message);

    // Execute the statement
    if ($stmt->execute()) {
        echo "alert(Registration done successfully.)";
    } else {
        // Log error and show generic message
        error_log("Error executing statement: " . $stmt->error, 3, "errors.log");
        echo "Something went wrong, please try again later.";
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Invalid request method.";
}

// Close the database connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Portfolio</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div id="header">
        <div class="container">
            <!-- Navbar -->
            <nav>
                <img src="./images/black white king logo.png" alt="Logo of business" class="image_logo" width="200px">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#service">Services</a></li>
                    <li><a href="#portfolio">Portfolio</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
            <div class="introduction">
                <small>Back-End Developer</small>
                <h1>Hey,<br>I am <span>Isaac</span> Precieux<br> From Kigali-Rwanda.</h1>
            </div>
        </div>

        <!-- ----------about ------- -->
        <div id="about">
            <div class="container">
                <div class="row">
                    <div class="about-col-1">
                        <img src="./images/user.png">
                    </div>
                    <div class="about-col-2">
                        <h2 class="subtitle">About me</h2>
                        <p>I am a developer of a company called Ngwino company.
                           This is a company that deals with financial concepts.
                           I have knowledge in Python, Java, JavaScript, and others.</p>
                    </div>
                </div>
            </div>
        </div>

        <div id="service">
            <h2 class="subtitle">My Services</h2>
            <div class="services-list">
                <div>
                    <i class="fas fa-globe"></i> <h3>Web design</h3>
                    <p>I have knowledge of making web designs of many different websites using tools like Figma and Canva.</p>
                </div>
                <div>
                    <h3>Server-Side design</h3>
                    <p>Using PHP, ASP, and JSP to design the server sides of web apps.</p>
                </div>
                <div>
                    <h3>APIs Making</h3>
                    <p>Creating Application Programming Interfaces to connect apps and servers.</p>
                </div>
            </div>
        </div>

        <div id="contact">
            <div class="container">
                <h2>Contact Me</h2>
                <form method="POST" action="">
                    <input type="text" name="name" placeholder="Your name" required>
                    <input type="email" name="email" placeholder="Your email" required>
                    <input type="password" name="password" placeholder="Your password" required>
                    <textarea name="message" rows="6" placeholder="Your message" required></textarea>
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
        <div id="response-message"></div>
        <div class="copyright">
            <p>&copy;2025 Isaac. All rights reserved.</p>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
