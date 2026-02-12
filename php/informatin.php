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


   #strength-fill {
     height: 100%;
     width: 0%;
     border-radius: 20px;
     transition: width 0.3s ease;
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
