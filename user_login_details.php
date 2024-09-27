<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$con = new mysqli("localhost", "root", "", "btech_db");

if ($con->connect_error) {
    die("Failed to connect to the database: " . $con->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $email = mysqli_real_escape_string($con, $email);
    $stmt = $con->prepare("SELECT * FROM btech WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt_result = $stmt->get_result();
    if ($stmt_result === false) {
        die("Error executing the query: " . mysqli_error($con));
    }

    if ($stmt_result->num_rows > 0) {
        echo "<h2>Login Successfully</h2>";
    } else {
        echo "<h2>Invalid Email</h2>";
    }
}
?>
