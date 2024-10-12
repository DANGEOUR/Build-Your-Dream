<?php
session_start(); // Start the session

if (isset($_POST['login_btn'])) {
    include "shared/config.php"; // Ensure the database connection is included

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql_login = "SELECT * FROM admin WHERE email = ? AND password = ?";
    $stmt_login = mysqli_prepare($conn, $sql_login);
    if ($stmt_login === false) {
        die('MySQL prepare statement error: ' . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt_login, "ss", $email, $password);
    mysqli_stmt_execute($stmt_login);
    $result_login = mysqli_stmt_get_result($stmt_login);

    if (mysqli_num_rows($result_login) > 0) {
        $row = mysqli_fetch_assoc($result_login);
        $_SESSION['username'] = $row['Name'];
        $_SESSION['logged_in'] = true;
        $_SESSION['login_success'] = 'Login successful! Welcome, Admin ' . $_SESSION['username'] . '.'; // Set the success message in the session
        header("Location: index.php"); // Redirect to index page
        exit;
    } else {
        echo "<script>
                alert('Incorrect email or password. Please try again.');
              </script>";
    }

    mysqli_stmt_close($stmt_login);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: "Roboto", sans-serif;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #282c37;
            color: #fff;
        }

        .container {
            width: 100%;
            max-width: 400px;
        }

        .card {
            background-color: #373d4b;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #61dafb;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="password"] {
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #61dafb;
            border-radius: 4px;
            transition: border-color 0.3s ease-in-out;
            outline: none;
            color: #282c37;
            box-sizing: border-box; /* Ensure padding and border are included in element's total width and height */
        }

        input:focus {
            border-color: #90caf9;
        }

        .password-wrapper {
            position: relative;
            width: 100%;
        }

        .password-wrapper input {
            padding-right: 40px;
            width: 100%;
        }

        .show-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #61dafb;
            font-size: 18px;
            cursor: pointer;
            outline: none;
            padding-bottom: 6%;
        }

        button {
            background-color: #61dafb;
            color: #282c37;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <h2>Admin Login</h2>
        <form method="POST">
            <label for="username">E-mail</label>
            <input type="text" id="username" name="email" required>

            <label for="password">Password</label>
            <div class="password-wrapper">
                <input type="password" id="password" name="password" required>
                <button type="button" class="show-password" onclick="togglePassword()">👁</button>
            </div>

            <button type="submit" name="login_btn">Login</button>
        </form>
    </div>
</div>

<script>
    function togglePassword() {
        var passwordInput = document.getElementById('password');
        var passwordToggle = document.querySelector('.show-password');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordToggle.textContent = '🙈'; // Hide password icon
        } else {
            passwordInput.type = 'password';
            passwordToggle.textContent = '👁'; // Show password icon
        }
    }
</script>
</body>
</html>
