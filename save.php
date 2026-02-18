<?php
$conn = mysqli_connect("localhost","root","","institute");
if (!$conn) { die("فشل الاتصال بقاعدة البيانات"); }

$error = "";
$success = "";

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phone    = isset($_POST['phone']) ? $_POST['phone'] : '';

    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        $error = "رقم الجوال يجب أن يكون 10 أرقام";
    } else {
        $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
        if (mysqli_num_rows($check) > 0) {
            $error = "اسم المستخدم موجود مسبقاً";
        } else {
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
    <!-- شعار الموقع -->
<div class="logo-container" onclick="window.location.href='index.html'">
  <img src="../width_889.webp" alt="شعار الموقع">
</div>
<head>
<meta charset="UTF-8">
<title>إنشاء حساب جديد</title>

<style>

/* ===== الوضع الافتراضي دارك ===== */
body{
    font-family: "Segoe UI", sans-serif;
    background: linear-gradient(135deg,#1e1e2f,#121212);
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    transition:0.6s;
    overflow:hidden;
}

/* عند تشغيل الأبجورة */
body.light-on{
    background: linear-gradient(135deg,#34345a,#1c1c1c);
}

/* ===== البوكس ===== */
.box{
    background:#1f1f1f; /* نفس لون الدارك الأساسي */
    color:white;
    padding:40px;
    border-radius:20px;
    width:360px;
    box-shadow:0 10px 40px rgba(0,0,0,.6);
    position:relative;
    transition:0.6s;
}

/* لما النور يشتغل يصير أبيض */
body.light-on .box{
    background:white;
    color:#222;
    box-shadow:0 0 100px rgba(255,223,120,0.6);
}

h2{text-align:center;margin-bottom:20px;color: #376f81;}

input{
    width:100%;
    padding:12px;
    margin:8px 0;
    border-radius:10px;
    border:1px solid #444;
    background:#2a2a2a;
    color:white;
    transition:0.3s;
}

/* الحقول تصير فاتحة عند التشغيل */
body.light-on input{
    background:#f3f3f3;
    color:#222;
    border:1px solid #ccc;
}

input:focus{
    border-color:#ffcc33;
    outline:none;
}

button{
    width:100%;
    padding:12px;
    margin-top:10px;
    border:none;
    border-radius:10px;
    background:#6e8efb;
    color:white;
    font-size:16px;
    cursor:pointer;
}

button:hover{
    background:#5a77e1;
}

.error{color:#ff6b6b;text-align:center;}
.success{color:#4cd137;text-align:center;}


/* ===== الأبجورة ===== */

.lamp{
    position:absolute;
    left:-260px; /* أبعدناها زيادة */
    top:-200px;
    width:180px;
    height:400px;
    display:flex;
    flex-direction:column;
    align-items:center;
    cursor:pointer;
}

/* السلك */
.lamp::before{
    content:"";
    width:4px;
    height:220px;
    background:#777;
}

/* رأس الأبجورة */
.lamp-head{
    width:130px;
    height:80px;
    background:#333;
    border-radius:70% 70% 20% 20%;
    position:relative;
    transition:0.4s;
}


.lamp-head::after{
    content:"";
    position:absolute;
    top:75px;
    left:50%;
    transform:translateX(-50%);
    width:0;
    height:0;

    /* أصغر من قبل ومتناسب مع عرض الأبجورة */
    border-left:70px solid transparent;
    border-right:70px solid transparent;
    border-top:280px solid rgba(255,223,120,0.45);

    opacity:0;
    transition:0.5s;
    filter:blur(6px);
}


body.light-on .lamp-head{
    background:#555;
}

body.light-on .lamp-head::after{
    opacity:1;
}

.logo-container {
  position: fixed;
  top: 10px;
  right:40px;
  cursor: pointer;
  z-index: 9999;
  width: 140px;      /* زيادة الحجم */
  height: 140px;     /* زيادة الحجم */
  border-radius: 30%; /* دائرة كاملة */
  overflow: hidden;
  display: flex;
  justify-content: center;
  align-items: center;
}


.logo-container img {
  width: 100%;   /* أوسع شوي داخل الحاوية الكبيرة */
  height: 100%;
  object-fit: contain;
  transition: transform 0.3s;
}


.logo-container:hover img {
  transform: scale(1.1); /* تأثير تكبير خفيف عند الهوف */
}



</style>
</head>

<body>

<div class="box">

<div class="lamp" id="lamp">
    <div class="lamp-head"></div>
</div>

<h2>إنشاء حساب جديد</h2>


<p style="font-size:17px;opacity:0.7;text-align:center;margin-top:-10px;"><i>
- جرّب تشغيل المصباح!-</i>
</p>


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

<script>
const lamp = document.getElementById("lamp");

lamp.addEventListener("click", function(){
    document.body.classList.toggle("light-on");
});
</script>


</body>
</html>
