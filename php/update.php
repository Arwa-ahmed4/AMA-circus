<?php
session_start(); 
include("database.php"); 


if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$msg = "";     
$msgType = "";  

// استدعاء بيانات المستخدم من قاعدة البيانات باستخدام اسم المستخدم
$query = "SELECT * FROM visitors WHERE username = ? LIMIT 1";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();


if (!$user) {
    header("Location: login.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {

    
    $new_username = trim($_POST['username']);
    $phone = trim($_POST['number']);
    $email = trim($_POST['email']);
    $birthday = $_POST['birthday'];
    $password = trim($_POST['password']);


    if (strlen($password) > 0 && strlen($password) < 8) {
        $msg = "❌ Password must be at least 8 characters.";
        $msgType = "error";
    } else {
        
    
        if (strlen($password) > 0) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        }

  
        if ($new_username !== $username) {
            // تحقق إذا اسم المستخدم الجديد موجود في قاعدةالبيانات
            $check = $con->prepare("SELECT id FROM visitors WHERE username = ? AND id != ?");
            $check->bind_param("si", $new_username, $user['id']);
            $check->execute();
            $check->store_result();

            if ($check->num_rows > 0) {
               
                $msg = "❌ Username already taken. Choose another.";
                $msgType = "error";
                $check->close();
            } else {
                $check->close();

                
                if (strlen($password) > 0) {
                    $update_query = "UPDATE visitors SET username=?, phone=?, email=?, birthday=?, password=? WHERE id=?";
                    $stmt = $con->prepare($update_query);
                    $stmt->bind_param("sssssi", $new_username, $phone, $email, $birthday, $hashedPassword, $user['id']);
                } else {
                   
                    $update_query = "UPDATE visitors SET username=?, phone=?, email=?, birthday=? WHERE id=?";
                    $stmt = $con->prepare($update_query);
                    $stmt->bind_param("ssssi", $new_username, $phone, $email, $birthday, $user['id']);
                }

                // تنفيذ تحديث البيانات
                if ($stmt->execute()) {
                    $_SESSION['username'] = $new_username; 
                    $username = $new_username;
                    $msg = "✅ Information updated successfully!"; 
                    $msgType = "success";

                    // استدعاء البيانات بعد التحديث
                    $query = "SELECT * FROM visitors WHERE id = ? LIMIT 1";
                    $stmt2 = $con->prepare($query);
                    $stmt2->bind_param("i", $user['id']);
                    $stmt2->execute();
                    $result = $stmt2->get_result();
                    $user = $result->fetch_assoc();
                    $stmt2->close();
                } else {
                    
                    $msg = "❌ Error updating data: " . $stmt->error;
                    $msgType = "error";
                }
                $stmt->close();
            }
        } else {
            
            if (strlen($password) > 0) {
                
                $update_query = "UPDATE visitors SET phone=?, email=?, birthday=?, password=? WHERE id=?";
                $stmt = $con->prepare($update_query);
                $stmt->bind_param("ssssi", $phone, $email, $birthday, $hashedPassword, $user['id']);
            } else {
               
                $update_query = "UPDATE visitors SET phone=?, email=?, birthday=? WHERE id=?";
                $stmt = $con->prepare($update_query);
                $stmt->bind_param("sssi", $phone, $email, $birthday, $user['id']);
            }

     
            if ($stmt->execute()) {
                $msg = "✅ Information updated successfully!"; 
                $msgType = "success";

            
                $query = "SELECT * FROM visitors WHERE id = ? LIMIT 1";
                $stmt2 = $con->prepare($query);
                $stmt2->bind_param("i", $user['id']);
                $stmt2->execute();
                $result = $stmt2->get_result();
                $user = $result->fetch_assoc();
                $stmt2->close();
            } else {
               
                $msg = "❌ Error updating data: " . $stmt->error;
                $msgType = "error";
            }
            $stmt->close();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Update Your Information</title>
<style>
    body {
        background-image: url('images/Capture%20Home3.PNG');
        background-size: cover;
        background-position: center;
        font-family: Arial, sans-serif;
        color: #333;
        padding: 30px;
        min-height: 100vh;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    form {
        background-color: rgba(255, 255, 255, 0.9);
        padding: 25px 30px;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0,0,0,0.2);
        width: 350px;
    }
    h2 {
        text-align: center;
        color: #941e2d;
        margin-bottom: 20px;
    }
    label {
        display: block;
        margin-top: 15px;
        font-weight: bold;
    }
    input[type="text"], input[type="email"], input[type="date"], input[type="password"] {
        width: 100%;
        padding: 8px 10px;
        margin-top: 6px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }
    button {
        margin-top: 20px;
        width: 100%;
        background-color: #941e2d;
        border: none;
        padding: 12px;
        color: white;
        font-size: 16px;
        font-weight: bold;
        border-radius: 25px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    button:hover {
        background-color: #a53340;
    }
    .message {
        text-align: center;
        margin-bottom: 15px;
        font-weight: bold;
    }
    .success {
        color: green;
    }
    .error {
        color: red;
    }
    a {
        display: block;
        text-align: center;
        margin-top: 15px;
        color: #941e2d;
        text-decoration: none;
        font-weight: bold;
    }
    a:hover {
        text-decoration: underline;
    }
</style>
</head>
<body>

<form method="post" action="update.php">
    <h2>Update Your Information</h2>
    <?php if ($msg): ?>
        <div class="message <?php echo $msgType === 'success' ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($msg); ?>
        </div>
    <?php endif; ?>

    <label for="username">Username:</label>
    <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

    <label for="number">Phone:</label>
    <input type="text" name="number" id="number" value="<?php echo htmlspecialchars($user['phone']); ?>" required>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

    <label for="birthday">Birthday:</label>
    <input type="date" name="birthday" id="birthday" value="<?php echo htmlspecialchars($user['birthday']); ?>" required>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" placeholder="Enter new password (optional)">

    <button type="submit" name="update">Update</button>

    <a href="Project(Home).php">Back to Home</a>
</form>

</body>
</html>
