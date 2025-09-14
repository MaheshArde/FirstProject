<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "Indian_Tourism");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$confirm_password = password_hash($_POST['confirm_password'], PASSWORD_BCRYPT);


// Check confirm password
if ($_POST['password'] !== $_POST['confirm_password']) {
    die("Passwords do not match!");
}


// Insert into database
$sql = "INSERT INTO users (Firstname, Lastname, email, password, confirm_password) VALUES ('$firstname', '$lastname', '$email', '$password', '$confirm_password')";

if ($conn->query($sql) === TRUE) {
    echo "Registration successful!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
