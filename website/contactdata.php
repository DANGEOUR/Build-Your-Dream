<?php
include "shared/config.php";


if (isset($_POST['btn'])) {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $message = $_POST['Message'];


    $sql = "INSERT INTO contact (name, phone, email, message) VALUES ('$name', '$phone', '$email', '$message')";


    $result = mysqli_query($conn, $sql);


    if ($result) {
        echo "<script>alert('Data was saved Successfully')</script>";
        echo "<script>window.location.href('index.php')</script>";
    } else {
        echo "<script>alert('Data was not saved Successfully')</script>";
        echo "Error: " . mysqli_error($conn); // Display error message for debugging
    }
}
?>