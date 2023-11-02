<?php
session_start();

// Niszczy Sesję
session_destroy();

// Przekierowanie
header("Location: logowanie.php");
exit();
?>