<!-- login.php -->
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

 // Check credentials (in a real scenario, check against a database)
    if ($username == "example_user" && $password == "example_password") {
        header("Location: contact_form.html");
        exit();
    } else {
        echo "Invalid username or password.";
    }

    // Database connection details
    $host = 'localhost';
    $db = 'webapp_db';
    $user = 'username';
    $pass = 'password';

    try {
        // Create a PDO connection
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute a simple query (replace this with your actual authentication logic)
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password); // In a real scenario, you would hash the password before comparing
        $stmt->execute();

        // Check if a matching user is found
        if ($stmt->rowCount() > 0) {
            // Valid credentials, redirect to contact form
            header("Location: contact_form.html");
            exit();
        } else {
            // Invalid credentials
            echo "Invalid username or password.";
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        echo "Error: " . $e->getMessage();
    }
}
?>
