<?php
// PARTE 1: Iniciar sesión y conectar a la base de datos

// Inicia una nueva sesión o reanuda la sesión existente
session_start();

// Incluye el archivo de conexión a la base de datos
// Este archivo debe contener la configuración necesaria para conectarse a la base de datos
include("bdconect.php");

// PARTE 2: Procesar formulario de login

// Verifica si el formulario fue enviado mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los valores enviados desde el formulario
    // Si no se envían, se asigna una cadena vacía como valor predeterminado
    $usuario = $_POST["usuario"] ?? '';
    $clave = $_POST["clave"] ?? '';

    // Prepara una consulta SQL para buscar al usuario en la base de datos
    // Utiliza parámetros preparados para evitar inyecciones SQL
    $sql = "SELECT * FROM usuarios WHERE usuario=? AND clave=?";
    $stmt = $conn->prepare($sql); // Prepara la consulta
    $stmt->bind_param("ss", $usuario, $clave); // Vincula los parámetros (usuario y clave)
    $stmt->execute(); // Ejecuta la consulta
    $resultado = $stmt->get_result(); // Obtiene el resultado de la consulta

    // Verifica si se encontró un usuario con las credenciales proporcionadas
    if ($resultado->num_rows == 1) {
        // Si las credenciales son correctas, guarda el usuario en la sesión
        $_SESSION["usuario"] = $usuario;

        // Redirige al usuario a la página principal
        header("Location: principal.php");
        exit(); // Finaliza el script para evitar que se ejecute más código
    } else {
        // Si las credenciales son incorrectas, define un mensaje de error
        $error = "Datos incorrectos";
    }
}
?>

<!-- PARTE 3: Formulario HTML -->

<!-- Muestra un formulario HTML para que el usuario ingrese sus credenciales -->
<center>
<form method="POST" action="">
    Usuario: <input type="text" name="usuario"><br>
    <br>
    Clave: <input type="password" name="clave"><br>
    <input type="submit" value="Ingresar">
</form>
</center>

<?php
// PARTE 4: Mostrar mensaje de error si existe

// Verifica si se definió un mensaje de error
if (isset($error)) {
    // Muestra el mensaje de error en color rojo
    echo "<p style='color:red;'>$error</p>";
}
?>
