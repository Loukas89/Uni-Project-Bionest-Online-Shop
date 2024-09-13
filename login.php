<?php
session_start();
include 'db_config.php';

// Get user input
$email = $_POST['email'];
$password = $_POST['password'];

// Debug: Print user input
echo "Email: " . htmlspecialchars($email) . "<br>";
echo "Password: " . htmlspecialchars($password) . "<br>";

// Establish the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    // Debug: Print connection error
    die("Connection failed: " . print_r(sqlsrv_errors(), true));
}

// Debug: Print a message indicating successful connection
echo "Connected to the database.<br>";

// Prepare the SQL statement
$sql = "SELECT CLId, Email, Password FROM Client WHERE Email = ?";
$params = array($email);

// Execute the query
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    // Debug: Print query error
    die("Query failed: " . print_r(sqlsrv_errors(), true));
}

// Debug: Check if any rows are returned
if (sqlsrv_has_rows($stmt)) {
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    // Debug: Print the fetched row
    echo "Fetched row: " . print_r($row, true) . "<br>";

    // Check the password (assuming passwords are stored as plain text)
    if (password_verify($password, $row['Password'])) {
        $_SESSION['customerId'] = $row['CLId'];
        echo "Login successful. Customer ID: " . $_SESSION['customerId'] . "<br>";
        header("Location: home.html");
        exit();
    } else {
        echo "Invalid email or password.<br>";
    }
} else {
    echo "Invalid email or password.<br>";
}

// Free the statement and close the connection
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>
