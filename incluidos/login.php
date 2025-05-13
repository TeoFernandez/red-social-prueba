<?php
// PARTE 1: Iniciar sesión y conectar a la base de datos
session_start();
include("bdconect.php");

// PARTE 2: Procesar formulario de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"] ?? '';
    $clave = $_POST["clave"] ?? '';

    $sql = "SELECT * FROM usuarios WHERE usuario=? AND clave=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $usuario, $clave);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $_SESSION["usuario"] = $usuario;
        header("Location: principal.php");
        exit();
    } else {
        $error = "Datos incorrectos";
    }
}
?>

<!-- PARTE 3: Formulario HTML -->
<form method="POST" action="">
    Usuario: <input type="text" name="usuario"><br>
    Clave: <input type="password" name="clave"><br>
    <input type="submit" value="Ingresar">
</form>

<?php
// Mostrar mensaje de error si existe
if (isset($error)) {
    echo "<p style='color:red;'>$error</p>";
}
?>
