<?php
session_start();
$conn = mysqli_connect("localhost","root","","institute");

$username = $_POST["username"];
$password = $_POST["password"];

$result = mysqli_query($conn,"SELECT * FROM users WHERE username='$username'");
$user = mysqli_fetch_assoc($result);

if($user && password_verify($password, $user["password"])) {
    $_SESSION["user"] = $username;
    header("Location: dashboard.php");
} else {
    echo "بيانات غير صحيحة";
}
?>
