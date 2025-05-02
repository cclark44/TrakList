<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Traklist - Signup</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    form {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        width: 400px;
    }

    input[type=text], input[type=email], input[type=password], input[type=date], select, input[type=number], input[type=checkbox] {
        width: calc(100% - 22px);
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-sizing: border-box;
    }

    input[type=submit] {
        width: 100%;
        padding: 10px;
        background-color: #E05338;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    input[type=submit]:hover {
        background-color: #e77964;
    }

    .signup-title {
        text-align: center;
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
    }


    </style>
<form method="post">
    <h2 class="signup-title">Signup</h2>
    <!-- User Info -->
    <div>
        <label for="full_name"a>Full Name:</label>
        <input type="text" id="full_name" name="full_name" required>
    </div>
    <div>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <input type="submit" value="Submit">
    <div style="text-align:center; margin-top:20px;">
        <a href="login.php">Login Here</a>
    </div>

</form>
</html>
<?php
include "connection.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["full_name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];


    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // SQL statement to insert user data
    $sql = "INSERT INTO users (full_name, username, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss",$full_name, $username, $email, $hashed_password);

    if ($stmt->execute()) {
      header("Location: login.php");
     exit();
 } else {
     echo "Error: " . $stmt->error;
 }

    $stmt->close();
    $conn->close();
}
?>
