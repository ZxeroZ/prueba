<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["usuario"])) {
    header("location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="welcome.css">
</head>
<body>
    <div class="hero">
        <h1>Bienvenido, <?php echo $_SESSION["usuario"]; ?>!</h1>
    <p><a href="logout.php">Cerrar Sesión</a></p>
    </div>
</body>
</html>
