<?php
// Conexión a la base de datos
$conexion = new mysqli("viaduct.proxy.rlwy.net", "root", "-2bg5fEBc3fCFBH5bhhFA6f5d2feaGb6", "railway");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Procesar el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $usuario = $_POST["usuario"];
    $contrasena = password_hash($_POST["contrasena"], PASSWORD_DEFAULT);

    $stmt = $conexion->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $usuario, $contrasena);

    if ($stmt->execute()) {
        echo "Registro exitoso. Redirigiendo a la página de inicio de sesión en 5 segundos...";
        header("refresh:5;url=login.php");
    } else {
        echo "Error al registrar usuario: " . $stmt->error;
    }

    $stmt->close();
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="./register.css">
</head>
<body>
    <h1>Registro</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Nombre: <input type="text" name="nombre" required><br>
        Usuario: <input type="text" name="usuario" required><br>
        Contraseña: <input type="password" name="contrasena" required><br>
        <input type="submit" value="Registrarse">
    </form>
</body>
</html>
