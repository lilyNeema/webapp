<!-- reset_password.php -->
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    // Database connection details
    $host = 'localhost';
    $db = 'webapp_db';
    $user = 'your_username';
    $pass = 'your_password';

    try {
        // Create a PDO connection
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Generate a reset token (you may use a more secure method in a production environment)
        $token = bin2hex(random_bytes(32));

        // Insert the reset token into the 'password_resets' table
        $stmt = $pdo->prepare("INSERT INTO password_resets (user_id, token) VALUES ((SELECT id FROM users WHERE email = :email), :token)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        // Send a reset password email (in a real scenario)
        $reset_link = "https://example.com/reset_password?token=$token";
        $reset_message = "Click the following link to reset your password: $reset_link";

        mail($email, "Password Reset", $reset_message);

        echo "Reset password link sent to your email.";
    } catch (PDOException $e) {
        // Handle database connection or query errors
        echo "Error: " . $e->getMessage();
    }
}
?>
