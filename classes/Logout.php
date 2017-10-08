<?php
SetCookie('access','');
unset($_SESSION['access']);
header('Location: /');
exit;
?>