<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "your_database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];

    // Check if email exists
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Generate reset token
        $token = bin2hex(random_bytes(16));
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour")); // token valid for 1 hour

        // Save token in DB
        $update = $conn->prepare("UPDATE users SET reset_token=?, reset_expiry=? WHERE email=?");
        $update->bind_param("sss", $token, $expiry, $email);
        $update->execute();

        // Normally you would send email here
        echo "Password reset link: <a href='reset-password.php?token=$token'>Click here</a>";
        // Later you replace this with actual email sending
    } else {
        echo "No account found with that email.";
    }
}
$conn->close();
?>
