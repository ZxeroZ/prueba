<?php
session_start();

// Verificar si el usuario ya inició sesión
if (isset($_SESSION["usuario"])) {
    header("location: welcome.php");
    exit();
}

// Conexión a la base de datos
$conexion = new mysqli("viaduct.proxy.rlwy.net", "root", "-2bg5fEBc3fCFBH5bhhFA6f5d2feaGb6", "railway");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Procesar el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $contrasena = $_POST["contrasena"];

    $stmt = $conexion->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->bind_result($id, $username, $hashed_password);
    $stmt->fetch();

    if (password_verify($contrasena, $hashed_password)) {
        // Inicio de sesión exitoso
        $_SESSION["usuario"] = $username;
        $_SESSION["id"] = $id;
        header("location: welcome.php");
        exit();
    } else {
        echo "Inicio de sesión fallido. Verifica tus credenciales.";
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
    <title>Iniciar Sesión</title>
     <link rel="stylesheet" href="./login.css">
</head>
<body>
    <div class="login-container">
    <h1>Iniciar Sesión</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Usuario: <input type="text" name="usuario" required><br>
        Contraseña: <input type="password" name="contrasena" required><br>
        <input type="submit" value="Iniciar Sesión">
    </form>
    </div>
</body>
</html>
