<?php
session_start();
unset ($_SESSION['log']);
unset ($_SESSION['pass']);
session_destroy();
header("Location:/sys");
exit;
?>