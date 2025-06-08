<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion de Usuarios</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
// Inicia una nueva sesión o reanuda la sesión existente
session_start();

// Incluye el archivo de conexión a la base de datos
// Este archivo debe contener la configuración necesaria para conectarse a la base de datos
include("bdconect.php");

// --- CREAR USUARIO ---
// Verifica si se envió el formulario para crear un nuevo usuario
if (isset($_POST["crear"])) {
    // Obtiene los valores enviados desde el formulario
    $usuario = $_POST["nuevo_usuario"] ?? '';
    $clave = $_POST["nueva_clave"] ?? '';
    $rol = $_POST["nuevo_rol"] ?? '';

    // Verifica que los campos no estén vacíos antes de insertar en la base de datos
    if (!empty($usuario) && !empty($clave) && !empty($rol)) {
        // Prepara la consulta SQL para insertar un nuevo usuario
        $sql = "INSERT INTO usuarios (usuario, clave, rol) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql); // Prepara la consulta
        $stmt->bind_param("sss", $usuario, $clave, $rol); // Vincula los parámetros
        $stmt->execute(); // Ejecuta la consulta
    }
}

// --- ELIMINAR USUARIO ---
// Verifica si se envió el formulario para eliminar un usuario
if (isset($_POST["eliminar"])) {
    // Obtiene el ID del usuario a eliminar desde el formulario
    $idEliminar = $_POST["id_eliminar"] ?? '';

    // Verifica que el ID no esté vacío antes de eliminar
    if (!empty($idEliminar)) {
        // Prepara la consulta SQL para eliminar un usuario por su ID
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($sql); // Prepara la consulta
        $stmt->bind_param("i", $idEliminar); // Vincula el parámetro
        $stmt->execute(); // Ejecuta la consulta
    }
}

// --- EDITAR USUARIO ---
// Verifica si se envió el formulario para editar un usuario
if (isset($_POST["editar"])) {
    // Obtiene los valores enviados desde el formulario
    $idEditar = $_POST["id_editar"] ?? '';
    $nuevoUsuario = $_POST["usuario_editado"] ?? '';
    $nuevaClave = $_POST["clave_editada"] ?? '';
    $nuevoRol = $_POST["rol_editado"] ?? '';

    // Verifica que los campos no estén vacíos antes de actualizar
    if (!empty($idEditar) && !empty($nuevoUsuario) && !empty($nuevaClave) && !empty($nuevoRol)) {
        // Prepara la consulta SQL para actualizar los datos del usuario
        $sql = "UPDATE usuarios SET usuario = ?, clave = ?, rol = ? WHERE id = ?";
        $stmt = $conn->prepare($sql); // Prepara la consulta
        $stmt->bind_param("sssi", $nuevoUsuario, $nuevaClave, $nuevoRol, $idEditar); // Vincula los parámetros
        $stmt->execute(); // Ejecuta la consulta
    }
}

// --- OBTENER TODOS LOS USUARIOS ---
// Realiza una consulta para obtener todos los usuarios de la base de datos
$usuarios = $conn->query("SELECT * FROM usuarios");
?>

<!-- TÍTULO DE LA PÁGINA -->
<h2>Administración de Usuarios</h2>

<!-- FORMULARIO: ALTA -->
<h3>Dar de alta un nuevo usuario</h3>
<form method="POST">
    <!-- Campo para ingresar el nombre de usuario -->
    Usuario: <input type="text" name="nuevo_usuario"><br>
    <!-- Campo para ingresar la contraseña -->
    Clave: <input type="password" name="nueva_clave"><br>
    <!-- Campo para ingresar el rol del usuario -->
    Rol: <input type="text" name="nuevo_rol"><br>
    <!-- Botón para enviar el formulario -->
    <input type="submit" name="crear" value="Crear">
</form>

<!-- FORMULARIO: ELIMINAR -->
<h3>Eliminar un usuario</h3>
<form method="POST">
    <!-- Campo para ingresar el ID del usuario a eliminar -->
    ID de usuario: <input type="number" name="id_eliminar">
    <!-- Botón para enviar el formulario -->
    <input type="submit" name="eliminar" value="Eliminar">
</form>

<!-- FORMULARIO: EDITAR -->
<h3>Editar un usuario</h3>
<form method="POST">
    <!-- Campo para ingresar el ID del usuario a editar -->
    ID de usuario: <input type="number" name="id_editar"><br>
    <!-- Campo para ingresar el nuevo nombre de usuario -->
    Nuevo usuario: <input type="text" name="usuario_editado"><br>
    <!-- Campo para ingresar la nueva contraseña -->
    Nueva clave: <input type="password" name="clave_editada"><br>
    <!-- Campo para ingresar el nuevo rol -->
    Nuevo rol: <input type="text" name="rol_editado"><br>
    <!-- Botón para enviar el formulario -->
    <input type="submit" name="editar" value="Editar">
</form>

<!-- TABLA DE USUARIOS -->
<h3>Lista de usuarios actuales</h3>
<table border="1">
    <tr>
        <!-- Encabezados de la tabla -->
        <th>ID</th>
        <th>Usuario</th>
        <th>Clave</th>
        <th>Rol</th>
    </tr>
    <!-- Itera sobre los resultados de la consulta y muestra cada usuario en una fila -->
    <?php while ($row = $usuarios->fetch_assoc()): ?>
    <tr>
        <!-- Escapa los valores para evitar inyecciones XSS -->
        <td><?= htmlspecialchars($row["id"]) ?></td>
        <td><?= htmlspecialchars($row["usuario"]) ?></td>
        <td><?= htmlspecialchars($row["clave"]) ?></td>
        <td><?= htmlspecialchars($row["rol"]) ?></td>
    </tr>
    <?php endwhile; ?>

    <footer> </footer>
</table>

    
</body>
</html>