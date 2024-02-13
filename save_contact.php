<!-- save_contact.php -->
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mobile = $_POST["mobile"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $reg_number = $_POST["reg_number"];

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

        // Insert contact details into the 'contacts' table
        $stmt = $pdo->prepare("INSERT INTO contacts (mobile, email, address, reg_number) VALUES (:mobile, :email, :address, :reg_number)");
        $stmt->bindParam(':mobile', $mobile);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':reg_number', $reg_number);
        $stmt->execute();

        echo "Contact saved successfully!";
    } catch (PDOException $e) {
        // Handle database connection or query errors
        echo "Error: " . $e->getMessage();
    }
}
?>
