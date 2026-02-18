<?php
$conn = mysqli_connect("localhost","root","","institute");
if (!$conn) { die("فشل الاتصال بقاعدة البيانات"); }

$error = "";
$success = "";

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phone    = isset($_POST['phone']) ? $_POST['phone'] : '';

    // تحقق رقم الجوال
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        $error = "رقم الجوال يجب أن يكون 10 أرقام";
    } else {
        // تحقق إذا اسم المستخدم موجود مسبقًا
        $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
        if (mysqli_num_rows($check) > 0) {
            $error = "اسم المستخدم موجود مسبقاً";
        } else {
            // تشفير كلمة السر
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            mysqli_query($conn, "INSERT INTO users (username,password,phone) 
            VALUES ('$username','$hashed','$phone')");

            $success = "تم إنشاء الحساب بنجاح";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>إنشاء حساب جديد</title>
<style>
body{
    font-family: "Segoe UI", sans-serif;
    background: linear-gradient(135deg,#6e8efb,#a777e3);
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}
.box{
    background:white;
    padding:40px;
    border-radius:15px;
    width:360px;
    box-shadow:0 10px 25px rgba(0,0,0,.2);
}
h2{text-align:center;margin-bottom:20px;}
input, button{
    width:100%;
    padding:12px;
    margin:8px 0;
    border-radius:8px;
    border:1px solid #ccc;
}
button{
    border:none;
    background:#6e8efb;
    color:white;
    font-size:16px;
    cursor:pointer;
}
button:hover{background:#5a77e1;}
.error{color:red;text-align:center;}
.success{color:green;text-align:center;}
</style>
</head>
<body>
<div class="box">
<h2>إنشاء حساب جديد</h2>
<form method="post">
    <input type="text" name="username" placeholder="اسم المستخدم" required>
    <input type="password" name="password" placeholder="كلمة السر" required>
    <input type="text" name="phone" placeholder="رقم الجوال (10 أرقام)" required>
    <button name="register">تسجيل</button>
</form>

<?php
if ($error) echo "<p class='error'>$error</p>";
if ($success) echo "<p class='success'>$success</p>";
?>
</div>
</body>
</html>
