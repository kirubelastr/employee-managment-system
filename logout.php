<?php
session_start();
unset($_SESSION['user_type']);
unset($_SESSION['role']);
session_unset();
session_destroy();
session_set_cookie_params(0);
session_start();

header('Location: login.php');
exit();
?>
