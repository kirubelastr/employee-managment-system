<?php

/* // Check if the user is logged in
if (!isset($_SESSION['user_type'])) {
    // Start the session
session_start();
  // Redirect to the login page
  header('Location: login.php');
  exit;
} */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>
    .header {
    min-width: 98vw;
    display:flex;
    justify-content:flex-end;
    align-items:center;
    padding-right:20px;
    height:50px;
    background-color:#ddd
}
.header .name {
    margin-right: auto;
}
.header .menu {
    display:flex;
    align-items:center;
}
.header .menu a{
    margin-left:20px;
    transition: color 0.2s;
    text-decoration:none;
    color:#333;
}
.header .menu a:hover {
    color:#09f;
}
.header .menu .notifications {
    position:relative;
}
.header .menu .notifications::after {
    content:'3';
    position:absolute;
    top:-5px;
    right:-10px;
    width:20px;
    height:20px;
    border-radius:50%;
    background-color:#f00;
    color:#fff;
    font-size:14px;
    text-align:center;
    line-height:20px;
}
.header .menu .avatar {
    width:40px;
    height:40px;
    border-radius:50%;
    margin-left:20px;
    overflow:hidden;
}
.header .menu .avatar img {
    width:100%;
}

</style>
</head>
<body>

<div class="header">
    <div class="name"><img src="image/logo2_1619976135.png" alt="excel"></div>
    <div class="menu">
      <a href="notifications.php" class="notifications">Notifications</a>
      <div class="avatar">
          <img src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=identicon" alt="Avatar">
      </div>
      <a href="logout.php">Logout</a>
    </div>
</div>
    
</body>
</html>