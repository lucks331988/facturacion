<?php
$alert = '';
session_start();
if(!empty($_SESSION['active']))
{
    header('Location: sistema/');
}else
{

    if(!empty($_POST))
    {
        if(empty($_POST['usuario']) || empty($_POST['clave']))
    {
        $alert = 'Ingrese su Usuario y Clave';
    }else
    {
        require_once "conexion.php";
        $user = mysqli_real_escape_string($conection,$_POST['usuario']);
        $pass = md5(mysqli_real_escape_string($conection,$_POST['clave']));

        $query = mysqli_query($conection, "SELECT * FROM usuario WHERE usuario ='$user' AND clave ='$pass'");
        mysqli_close($conection);
        $result = mysqli_num_rows($query);

        if($result > 0)
        {
            $data = mysqli_fetch_array($query);
            $_SESSION['active'] = true;
            $_SESSION['idUser'] =  $data['idusuario'];
            $_SESSION['nombre'] =  $data['nombre'];
            $_SESSION['email']  =  $data['email'];
            $_SESSION['user']   =  $data['usuario'];
            $_SESSION['rol']    =  $data['rol'];

            header('Location: sistema/index.php');
        }else
        {
            $alert = 'Usuario o Clave incorrectos';
            session_destroy();
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistema de Facutración</title>
    <link rel="stylesheet" type= "text/css" href="css/style.css">
</head>
<body>
    <section class="container">
        <form action="" method="post">
            <h3>Iniciar Sesión</h3>
            <img src="img/login.png" alt="Login">
            <input type="text" name="usuario" placeholder="Usuario">
            <input type="password" name="clave" placeholder="Contraseña">
            <div class= "alert" > <?php echo isset($alert)? $alert:''; ?></div>
            <input type="submit" value="INGRESAR">

        </form>
    </section>
</body>
</html>