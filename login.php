<!DOCTYPE html>
<html>
<head>
    <title>Traklist - Login</title>
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
        .form-container {
            width: 300px;
        }
        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        input[type=email], input[type=password] {
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
        .login-title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .error {
            color: red;
            text-align: center;
        }
        img {
          display: block;
          margin: auto;
          margin-bottom: 0px;
          width: 100%;
        }
    </style>
<body>
  <div class="form-container">
        <h2 class="login-title"><img src = "Traklist header.png"></h2>
        <form method="post">
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <input type="submit" name="submit" value="Login">
            </div>

            <div style="text-align:center; margin-top:20px;">
                <a href="signup.php">Don't have an account? Sign up here</a>
            </div>
        </form>
    </div>
</body>
</html>
<?php
  include "connection.php";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $email = $_POST["email"];
      $password = $_POST["password"];

      $sql = "SELECT user_id, email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
       $stmt->bind_result($id, $db_username, $db_password);
       $stmt->fetch();

       if (password_verify($password, $db_password)) {
           $_SESSION["user_id"] = $id;
           $_SESSION["username"] = $db_username;
           header("Location: home.php");
           exit();
       } else {
           echo "Invalid username or password.";
       }
   } else {
       echo "User not found.";
   }

   // Close statement and connection
   $stmt->close();
   $conn->close();
}
 ?>
