<?php
session_start();
session_destroy();
header("Location: ../dysie3/registro/login.php");
exit();
?>