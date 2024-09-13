<?php
session_start();
include 'db_config.php';  // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $vat = $_POST['vat'];
    $country = $_POST['country'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Hash the password for security
    
    // Connect to the database
    $conn = sqlsrv_connect($serverName, $connectionOptions);

    if ($conn === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    
    // Insert user data into the Client table
    $sql = "INSERT INTO Client (Name, VAT, Country, Email, Password) OUTPUT INSERTED.CLId VALUES (?, ?, ?, ?, ?)";
    $params = array($name, $vat, $country, $email, $password);
    $stmt = sqlsrv_query($conn, $sql, $params);
    
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    
    // Get the newly created CustomerId
    sqlsrv_fetch($stmt);
    $customerId = sqlsrv_get_field($stmt, 0);
    
    // Insert a new entry in the Cart table with the CustomerId
    $cartSql = "INSERT INTO Cart (CustomerId) VALUES (?)";
    $cartParams = array($customerId);
    $cartStmt = sqlsrv_query($conn, $cartSql, $cartParams);

    if ($cartStmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_free_stmt($cartStmt);
    sqlsrv_close($conn);

    echo "User registered successfully!";
} else {
    echo "Invalid request method.";
}
?>
