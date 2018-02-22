logout.php
<?php
session_start();
unset($_SESSION['AdmNo']);
session_destroy();

header("Location: login.php");
exit;
?>
