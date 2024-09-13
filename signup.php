<?php
session_start();
include 'db_config.php';  // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $vat = $_POST['vat'];
    $country = $_POST['country'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Hash the password for security

    $conn = sqlsrv_connect($serverName, $connectionOptions);

    if ($conn === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Check if the email already exists
    $sql = "SELECT CLId FROM Client WHERE Email = ?";
    $params = array($email);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $client = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if ($client) {
        // Email already exists
        echo "The email address is already registered. Please use a different email.";
        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);
        exit();
    }

    sqlsrv_free_stmt($stmt);

    // Insert user data into the Client table
    $sql = "INSERT INTO Client (Name, VAT, Country, Email, Password) VALUES (?, ?, ?, ?, ?)";
    $params = array($name, $vat, $country, $email, $password);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Fetch the newly inserted ID
    $sql = "SELECT SCOPE_IDENTITY() AS ID";
    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $clientId = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)['ID'];

    // Set the session variable and redirect
    $_SESSION['customerId'] = $clientId;

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);

    header("Location: index.html");
    exit();
}
?>
