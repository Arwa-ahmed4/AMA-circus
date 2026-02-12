<?php
include("database.php"); 

$errorMsg = "";  // متغير لتخزين رسالة الخطأ

if ($_SERVER["REQUEST_METHOD"] == "POST") { 

    // أخد القيم اللي دخلها المستخدم
    $username = $_POST["username"];
    $phone = $_POST["number"];
    $email = $_POST["email"];
    $birthday = $_POST["birthday"];
    $password = $_POST["password"];

    // أتأكد ان اليوزرنيم غير موجود
    $check = $con->prepare("SELECT id FROM visitors WHERE username = ? LIMIT 1");
    $check->bind_param("s", $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) { 
        // بدل echo و exit خزّن الرسالة عشان نعرضها داخل الصفحة
        $errorMsg = "Username already taken. Choose another.";
    } else {
        $check->close();

        // تشفير كلمة المرور 
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $con->prepare(
            "INSERT INTO visitors (username, phone, email, birthday, password)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("sssss", $username, $phone, $email, $birthday, $hashedPassword);

        if ($stmt->execute()) { 
            header("Location: login.php");
            exit();
        } else { 
            $errorMsg = "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $check->close();
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tickets Page</title>
    <link rel="stylesheet" href="Common.css">
    <style>
      h1 {
         text-align: center;
         color: rgb(180, 78, 73); 
         font-family: "Comic Sans MS", cursive;
      }
      .box {
         border: 2px solid #ccc;
         border-radius: 8px;
         padding: 20px;
         margin: 20px auto;
         width: 80%;
         background: #fafafa;
      }
      label {
         display: block;
         margin-top: 10px;
         font-weight: bold;
      }
      input {
         width: 95%;
         padding: 6px;
         margin-top: 5px;
         border: 1px solid #888;
         border-radius: 4px;
      }
      .strength-bar {
       width: 100%;   
       height: 10px;
       background-color: #ddd;
       border-radius: 20px;
       margin-top: 6px;
       margin-bottom: 10px;
       overflow: hidden;
      }
      #strength-fill {
        height: 100%;
        width: 0%;
        border-radius: 20px;
        transition: width 0.3s ease;
      }
    </style>
</head>
<body>
<header class="hero-section">
  <nav class="navbar">
    <div class="logo">AMA</div>
  </nav>
</header>

<h1>Information</h1>

<div class="box">

    <!-- عرض رسالة الخطأ هنا لو موجودة -->
    <?php if(!empty($errorMsg)): ?>
      <div style="color: red; font-weight: bold; margin-bottom: 15px;">
        <?php echo htmlspecialchars($errorMsg); ?>
      </div>
    <?php endif; ?>

    <form action="save_info.php" method="post">

        <h3>👤 Visitor Information</h3>

        <label for="username">Username</label>
        <input type="text" id="username" name="username" required pattern="[A-Za-z0-9]+" placeholder="Your username (letters & numbers only)" />

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required minlength="6"/>

        <div class="strength-bar">
            <div id="strength-fill"></div>
        </div>

        <label for="number">Phone Number</label>
        <input type="tel" id="number" name="number" pattern="[0-9]{10}" maxlength="10" required placeholder="05XXXXXXXX"/>

        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" required />

        <label for="birthday">Birthday</label>
        <input type="date" id="birthday" name="birthday" required />

       <div class="confirm-box">
          <button type="submit" class="circus-btn btn-secondary">Create</button>
        </div>

    </form>
</div>

<script src="Info.js"></script>
</body>
</html>
