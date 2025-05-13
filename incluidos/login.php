

<?php
//PARTE 1
session_start();
include("dbconect.php");

// Si hay sesión, redirigir
if ($resultado->num_rows == 1) {
    $_SESSION["usuario"] = $usuario;
    header("Location: principal.php");
    exit();
}

//PARTE 2
// Si se envió el formulario
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

//PARTE 3
<form method="POST" action="">
    Usuario: <input type="text" name="usuario"><br>
    Clave: <input type="password" name="clave"><br>
    <input type="submit" value="Ingresar">
</form>

<?php
if (isset($error)) {
    echo "<p style='color:red;'>$error</p>";
}
?>

//PARTE 4
<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'mibase';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
