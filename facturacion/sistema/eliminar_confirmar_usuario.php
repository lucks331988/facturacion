<?php
session_start();
if($_SESSION['rol'] != 1){
    header("location: ./");
}

include "../conexion.php";

if(!empty($_POST)){
    if($_POST['idusuario'] == 1){
        header("location: lista_usuarios.php");
        mysqli_close($conection);
        exit;
    }
    $idusuario = $_POST['idusuario'];

    $query_delete = mysqli_query($conection,"DELETE FROM usuario WHERE idusuario = $idusuario");
    mysqli_close($conection);
    if($query_delete){
        header("location: lista_usuarios.php");
    }else{
        echo "Error al Eliminar Usuario";
    }
}


if(empty($_REQUEST['id']) || $_REQUEST['id'] == 1){
    header("location: lista_usuarios.php");
    mysqli_close($conection);
}else{

    $idusuario= $_REQUEST['id'];

    $query = mysqli_query($conection, "SELECT U.nombre, u.usuario, r.rol
                                        FROM usuario u
                                        INNER JOIN rol r
                                        ON u.rol = r.idrol
                                        WHERE u.idusuario = $idusuario");
    mysqli_close($conection);
    $result = mysqli_num_rows($query);

    if($result > 0){
        while($data = mysqli_fetch_array($query)){
            $nombre  = $data['nombre'];
            $usuario = $data['usuario'];
            $rol     = $data['rol'];
        }
    }else{
        header("location: lista_usuarios.php");
    }

}



?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="css/style_delet.css">
	<?php include "includes/script.php" ?>
	<title>Eliminar Usuario</title>
</head>
<body>
	<?php include "includes/header.php" ?>
	<section id="container">
		<div class="data_delete">
        <i class="fa-solid fa-user-xmark fa-7x" style="color:red"></i>
            <h2> ¿Está seguro de eliminar el siguiente Registro?</h2>
            <p>Nombre:<span><?php  echo $nombre; ?></span></p>
            <p>Usuario:<span><?php  echo $usuario; ?></span></p>
            <p>Tipo de usuario:<span><?php  echo $rol; ?></span></p>

            <form method="post" action="">
                <input type="hidden" name="idusuario" value="<?php  echo $idusuario; ?>">
                <a href="lista_usuarios.php" class="btn_cancel"><i class="fa-solid fa-ban" style="color:black"></i> Cancelar</a>
                <button type="submit" class="btn_ok"><i class="fa-solid fa-trash-can" style="color:black"></i> Eliminar</button>

            </form>


        </div>
	</section>

	<?php include "includes/footer.php" ?>
</body>
</html>