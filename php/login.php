<?php
session_start(); 
include("database.php"); 

$msg = ""; 

// إذا ضغط المستخدم زر تسجيل الدخول
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//trim يشيل السبيس او اي شي زايد
    
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    
    if ($user === "" || $pass === "") {
        $msg = "Please enter the username and password!"; 
    } else {

        // استدعاء البيانات من ال Database
        $query = "SELECT * FROM visitors WHERE username = ? LIMIT 1";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();

     
        if ($result->num_rows === 1) {

            $row = $result->fetch_assoc();

           
            if (password_verify($pass, $row['password'])) {

             // تسجيل الدخول اذا كان الشرط صحيح
                $_SESSION['isLoggedIn'] = true;
                $_SESSION['username'] = $user;

                $stmt->close();
                $con->close();

             
                header("Location: Project(Home).php");
                exit;

            } else {
       
                $msg = "Incorrect username or password!";
            }

        } else {
       
            $msg = "Incorrect username or password!";
        }

        $stmt->close();
    }
}

$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>AMA Login</title>
<style>
body { font-family: Arial, sans-serif; background: rgba(0,0,0,0.6); margin:0; }
.overlay { position: fixed; top:0; left:0; width:100%; height:100%; display:flex; justify-content:center; align-items:center; z-index:9999; }
.box { background: white; padding: 30px; border-radius: 15px; text-align:center; width:320px; box-shadow:0 0 10px rgba(0,0,0,0.3); }
input { width: 90%; padding:10px; margin-bottom:10px; border-radius:8px; border:1px solid #ccc; }
button { background: rgba(193,32,64,0.9); color:white; padding:10px 20px; border:none; border-radius:8px; cursor:pointer; font-size:16px; }
.msg { margin-top:10px; min-height:28px; color:#a94442; background:#f2dede; padding:6px 10px; border-radius:6px; display:inline-block; }
a { color:#007bff; text-decoration:none; }
</style>
</head>
<body>

<div class="overlay">
  <div class="box">
    <h2>AMA</h2>
    <form method="post">
      <input type="text" name="username" placeholder="UserName" required>
      <input type="password" name="password" placeholder="Password" required>
      <br>
      <button type="submit">Login</button>
    </form>
    <p style="margin-top: 15px; font-size: 14px;">
      Do not have an account? <a href="project_info.php">Create account</a>
    </p>
    <?php if($msg) echo "<div class='msg'>".htmlspecialchars($msg)."</div>"; ?>
  </div>
</div>

</body>
</html>
