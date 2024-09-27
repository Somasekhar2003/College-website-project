<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "degree_db";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql_create_db) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error;
}
$conn->select_db($database);
$sql_create_table = "CREATE TABLE IF NOT EXISTS degree (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    father_name VARCHAR(255) NOT NULL,
    mother_name VARCHAR(255) NOT NULL,
    dob DATE NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    course VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone_number VARCHAR(15) NOT NULL
)";

if ($conn->query($sql_create_table) === TRUE) {
    echo "Table created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["NAME"];
    $fatherName = $_POST["FATHER_NAME"];
    $motherName = $_POST["MOTHER_NAME"];
    $dob = $_POST["DOB"];
    $gender = $_POST["GENDER"];
    $course = $_POST["COURSE"];
    $email = $_POST["EMAIL"];
    $phoneNumber = $_POST["PHONE_NUMBER"];

    $sql = "INSERT INTO degree (name, father_name, mother_name, dob, gender, course, email, phone_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $name, $fatherName, $motherName, $dob, $gender, $course, $email, $phoneNumber);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
