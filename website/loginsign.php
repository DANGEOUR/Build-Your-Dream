<?php
session_start();
include "shared/config.php";
$user_name_error = '';
// User registration
if (isset($_POST['signup_btn'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $password = $_POST['pass'];

    $stmt_check_email = "SELECT email FROM sign_up WHERE email = ?";
    $sql_check_name = "SELECT Name FROM sign_up WHERE Name = ?";
    $sql_insert = "INSERT INTO sign_up(Name, email, address, phone, password) VALUES (?,?,?,?,?)";

    $stmt_check_email = mysqli_prepare($conn, $stmt_check_email);
    $stmt_check_name = mysqli_prepare($conn, $sql_check_name);
    $stmt_insert = mysqli_prepare($conn, $sql_insert);

    mysqli_stmt_bind_param($stmt_check_email, "s", $email);
    mysqli_stmt_execute($stmt_check_email);
    $result_check_email = mysqli_stmt_get_result($stmt_check_email);

    mysqli_stmt_bind_param($stmt_check_name, "s", $name);
    mysqli_stmt_execute($stmt_check_name);
    $result_check_name = mysqli_stmt_get_result($stmt_check_name);

    if (mysqli_num_rows($result_check_email) > 0) {
        echo '
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <div class="alert alert-danger text-center" role="alert">
                E-mail is already in use. Please choose a different E-mail.
              </div>';
    }
    if(mysqli_num_rows($result_check_name) > 0) {
        echo '
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <div class="alert alert-danger text-center" role="alert">
                Username is already in use. Please choose a different Username.
              </div>';
    }
    else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt_insert, "sssss", $name, $email, $address, $phone, $hashed_password);

        if (mysqli_stmt_execute($stmt_insert)) {
               echo '
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
            <div class="alert alert-success text-center" role="alert">
                    Your Account is registered, Now you can login to continue
                  </div>';
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    mysqli_free_result($result_check_email);
    mysqli_free_result($result_check_name);
    mysqli_stmt_close($stmt_check_email);
    mysqli_stmt_close($stmt_check_name);
    mysqli_stmt_close($stmt_insert);
}

// User login
if (isset($_POST['login_btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql_login = "SELECT id, Name, email, password FROM sign_up WHERE email = ?";
    $stmt_login = mysqli_prepare($conn, $sql_login);
    mysqli_stmt_bind_param($stmt_login, "s", $email);
    mysqli_stmt_execute($stmt_login);
    $result_login = mysqli_stmt_get_result($stmt_login);

    if (mysqli_num_rows($result_login) > 0) {
        $row = mysqli_fetch_assoc($result_login);
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id']; // Store user ID in session
            $_SESSION['username'] = $row['Name'];
            echo '
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
            <div class="alert alert-success text-center" role="alert">
                    Login Successful, Welcome ' . htmlspecialchars($_SESSION['username']) . '
                  </div>
                  <script> setTimeout(function() {
                        window.location.href = "index.php";
                    }, 2000); </script>';
                    // Redirect to a welcome page;
        } else {
            echo '
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
            <div class="alert alert-danger text-center" role="alert">
                   Incorrect E-mail or Password, Please try again.
                  </div>';
        }
    } else {
        echo '
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <div class="alert alert-danger text-center" role="alert">
                No account found with this email.
              </div>';
    }

    mysqli_stmt_close($stmt_login);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Build Your Dream - Login/Sign Up Page</title>
    <link rel="icon" href="assets/img/logo1.png" type="image/x-icon">
    <style>
        /* Add your CSS styles here */
        body {
            margin: 0;
            font-family: Roboto, -apple-system, 'Helvetica Neue', 'Segoe UI', Arial, sans-serif;
            background: #3b4465;
        }
        .forms-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .section-title {
            font-size: 32px;
            letter-spacing: 1px;
            color: #fff;
        }
        .forms {
            display: flex;
            align-items: flex-start;
            margin-top: 30px;
        }
        .form-wrapper {
            animation: hideLayer .3s ease-out forwards;
        }
        .form-wrapper.is-active {
            animation: showLayer .3s ease-in forwards;
        }
        @keyframes showLayer {
            50% {
                z-index: 1;
            }
            100% {
                z-index: 1;
            }
        }
        @keyframes hideLayer {
            0% {
                z-index: 1;
            }
            49.999% {
                z-index: 1;
            }
        }
        .switcher {
            position: relative;
            cursor: pointer;
            display: block;
            margin-right: auto;
            margin-left: auto;
            padding: 0;
            text-transform: uppercase;
            font-family: inherit;
            font-size: 16px;
            letter-spacing: .5px;
            color: #999;
            background-color: transparent;
            border: none;
            outline: none;
            transform: translateX(0);
            transition: all .3s ease-out;
        }
        .form-wrapper.is-active .switcher-login {
            color: #fff;
            transform: translateX(90px);
        }
        .form-wrapper.is-active .switcher-signup {
            color: #fff;
            transform: translateX(-90px);
        }
        .underline {
            position: absolute;
            bottom: -5px;
            left: 0;
            overflow: hidden;
            pointer-events: none;
            width: 100%;
            height: 2px;
        }
        .underline::before {
            content: '';
            position: absolute;
            top: 0;
            left: inherit;
            display: block;
            width: inherit;
            height: inherit;
            background-color: currentColor;
            transition: transform .2s ease-out;
        }
        .switcher-login .underline::before {
            transform: translateX(101%);
        }
        .switcher-signup .underline::before {
            transform: translateX(-101%);
        }
        .form-wrapper.is-active .underline::before {
            transform: translateX(0);
        }
        .form {
            overflow: hidden;
            min-width: 260px;
            margin-top: 50px;
            padding: 30px 25px;
            border-radius: 5px;
            transform-origin: top;
        }
        .form-login {
            animation: hideLogin .3s ease-out forwards;
        }
        .form-wrapper.is-active .form-login {
            animation: showLogin .3s ease-in forwards;
        }
        @keyframes showLogin {
            0% {
                background: #d7e7f1;
                transform: translate(40%, 10px);
            }
            50% {
                transform: translate(0, 0);
            }
            100% {
                background-color: #fff;
                transform: translate(35%, -20px);
            }
        }
        @keyframes hideLogin {
            0% {
                background-color: #fff;
                transform: translate(35%, -20px);
            }
            50% {
                transform: translate(0, 0);
            }
            100% {
                background: #d7e7f1;
                transform: translate(40%, 10px);
            }
        }
        .form-signup {
            animation: hideSignup .3s ease-out forwards;
        }
        .form-wrapper.is-active .form-signup {
            animation: showSignup .3s ease-in forwards;
        }
        @keyframes showSignup {
            0% {
                background: #d7e7f1;
                transform: translate(-40%, 10px) scaleY(.8);
            }
            50% {
                transform: translate(0, 0) scaleY(.8);
            }
            100% {
                background-color: #fff;
                transform: translate(-35%, -20px) scaleY(1);
            }
        }
        @keyframes hideSignup {
            0% {
                background-color: #fff;
                transform: translate(-35%, -20px) scaleY(1);
            }
            50% {
                transform: translate(0, 0) scaleY(.8);
            }
            100% {
                background: #d7e7f1;
                transform: translate(-40%, 10px) scaleY(.8);
            }
        }
        .form fieldset {
            position: relative;
            opacity: 0;
            margin: 0;
            padding: 0;
            border: 0;
            transition: all .3s ease-out;
        }
        .form-login fieldset {
            transform: translateX(-50%);
        }
        .form-signup fieldset {
            transform: translateX(50%);
        }
        .form-wrapper.is-active fieldset {
            opacity: 1;
            transform: translateX(0);
            transition: opacity .4s ease-in, transform .35s ease-in;
        }
        .form legend {
            position: absolute;
            overflow: hidden;
            width: 1px;
            height: 1px;
            clip: rect(0 0 0 0);
        }
        .input-block {
            margin-bottom: 20px;
        }
        .input-block label {
            font-size: 14px;
            color: #a1b4b4;
        }
        .input-block input {
            display: block;
            width: 90%;
            margin-top: 8px;
            padding-right: 15px;
            padding-left: 15px;
            font-size: 16px;
            line-height: 40px;
            color: #3b4465;
            background: #eef9fe;
            border: 1px solid #cddbef;
            border-radius: 2px;
        }
        .form [type='submit'] {
            opacity: 0;
            display: block;
            min-width: 120px;
            margin: 30px auto 10px;
            font-size: 18px;
            line-height: 40px;
            border-radius: 25px;
            border: none;
            transition: all .3s ease-out;
        }
        .form-wrapper.is-active .form [type='submit'] {
            opacity: 1;
            transform: translateX(0);
            transition: all .4s ease-in;
        }
        .btn-login {
            color: #fbfdff;
            background: #a7e245;
            transform: translateX(-30%);
            cursor: pointer;
        }
        .btn-signup {
            color: #a7e245;
            background: #fbfdff;
            box-shadow: inset 0 0 0 2px #a7e245;
            transform: translateX(30%);
            cursor: pointer;
        }
    </style>
</head>

<body>
    <br>
    <br>
    <a style="margin-left:100px; color:white; text-decoration:none;" href="index.php">Go Back</a>
    <br>
    <br>
    <br>
    <br>
    <br>
    <section class="forms-section">
        <h1 class="section-title">Login & Signup</h1>
        <div class="forms">
            <div class="form-wrapper is-active">
                <button type="button" class="switcher switcher-login">
                    Login
                    <span class="underline"></span>
                </button>
                <form class="form form-login" method="POST">
                    <fieldset>
                        <legend>Please, enter your email and password for login.</legend>
                        <div class="input-block">
                            <label for="login-email">E-mail</label>
                            <input name="email" id="login-email" type="email" required>
                        </div>
                        <div class="input-block">
                            <label for="login-password">Password</label>
                            <input name="password" id="login-password" type="password" required>
                        </div>
                    </fieldset>
                    <button name="login_btn" type="submit" class="btn-login">Login</button>
                </form>
            </div>
            <div class="form-wrapper">
                <button type="button" class="switcher switcher-signup">
                    Sign Up
                    <span class="underline"></span>
                </button>
                <form class="form form-signup" method="POST">
                    <fieldset>
                        <legend>Please, enter your email, password and password confirmation for sign up.</legend>
                        <div class="input-block">
                            <label for="signup-username">Username</label>
                            <input name="name" id="signup-username" type="text" required>
                        </div>
                        <div class="input-block">
                            <label for="signup-email">E-mail</label>
                            <input name="email" id="signup-email" type="email" required>
                        </div>
                        <div class="input-block">
                            <label for="signup-address">Address</label>
                            <input name="address" id="signup-address" type="text" required>
                        </div>
                        <div class="input-block">
                            <label for="signup-number">Phone</label>
                            <input name="phone" id="signup-address" type="text" required>
                        </div>
                        <div class="input-block">
                            <label for="signup-password">Password</label>
                            <input name="pass" id="signup-password" type="password" required>
                        </div>
                    </fieldset>
                    <button name="signup_btn" type="submit" class="btn-signup">Sign Up</button>
                </form>
            </div>
        </div>
    </section>
    <script>
        const switchers = [...document.querySelectorAll('.switcher')];
        switchers.forEach(item => {
            item.addEventListener('click', function() {
                switchers.forEach(item => item.parentElement.classList.remove('is-active'));
                this.parentElement.classList.add('is-active');
            });
        });
    </script>
</body>

</html>
