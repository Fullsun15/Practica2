<?php
session_start();

// Destruir la sesión
session_destroy();

// Redirigir a index.php o a cualquier otra página después de destruir la sesión
header('Location: index.php');
exit();
?>
