<?php
session_start();
session_destroy();
header("Location: ../Dysie/registro/login.php");
exit();
?>