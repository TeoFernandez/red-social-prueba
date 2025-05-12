
<?php
//1ra parte
session_start();
include("bdconect.php");

//Si hay sesión redirige
if (!empty($_SESSION)) {
    header("location:principal.php");
    exit();
}


//2da parte
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $usuario=$_POST['usuario']??";
    $clave=$_POST['clave']??";
    $sql="SELECT * FROM usuario WHERE  usuario=? AND  clave=?";
    $stml=$con->prepare($sql);
    $stml->bind_param("ss",$usuario,$clave);
    $stml ->execute();
    $resultado=$stml->get_result();


    if ($resultado->num_rous==1) {
        $fila=$resultado->ferch_assoc()
        $_SESSION['usuario']=$fila['usuario'];
        $_SESSION['rol']=$fila['rol']; //Campo nuevo en la base de datos  [usuario/administrador]
        header("location:principal.php");
        exit();
    }
    else{
        $error="DATOS INCORRECTOS";
    }
}

?>

<!--3ra parte-->
<form method="POST" action="">
    Usuario<input type="text" value="usuario"><br>
    Clave<input type="password" value="clave"><br>
    <input type="submit" value="Ingresar">
</form>

<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>