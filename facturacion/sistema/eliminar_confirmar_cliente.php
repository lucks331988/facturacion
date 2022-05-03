<?php
session_start();
if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2){
    header("location: ./");
}

include "../conexion.php";

if(!empty($_POST)){
    if(empty($_POST['idcliente']))
    {
        header("location: lista_clientes.php");
        mysqli_close($conection);
    }

    $idcliente = $_POST['idcliente'];

    $query_delete = mysqli_query($conection,"DELETE FROM cliente WHERE idcliente = $idcliente");
    mysqli_close($conection);
    if($query_delete){
        header("location: lista_clientes.php");
    }else{
        echo "Error al Eliminar Cliente";
    }
}


if(empty($_REQUEST['id'])){
    header("location: lista_clientes.php");
    mysqli_close($conection);
}else{

    $idcliente= $_REQUEST['id'];

    $query = mysqli_query($conection, "SELECT * FROM cliente WHERE idcliente = $idcliente");
    mysqli_close($conection);
    $result = mysqli_num_rows($query);

    if($result > 0){
        while($data = mysqli_fetch_array($query)){
            $cuit    = $data['cuit'];
            $nombre  = $data['nombre'];
        }
    }else{
        header("location: lista_clientes.php");
    }

}



?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="css/style_delet.css">
	<?php include "includes/script.php" ?>
	<title>Eliminar Cliente</title>
</head>
<body>
	<?php include "includes/header.php" ?>
	<section id="container">
		<div class="data_delete">
            <i class="fa-solid fa-user-xmark fa-7x" style="color:red"></i>
            <h2> ¿Está seguro de eliminar el siguiente Registro?</h2>
            <p>Nombre del Cliente:<span><?php  echo $nombre; ?></span></p>
            <p>Cuit o Cuil:<span><?php  echo $cuit; ?></span></p>
            

            <form method="post" action="">
                <input type="hidden" name="idcliente" value="<?php  echo $idcliente; ?>">
                <a href="lista_clientes.php" class="btn_cancel"><i class="fa-solid fa-ban" style="color:black"></i> Cancelar</a>
                <button type="submit" class="btn_ok"><i class="fa-solid fa-trash-can" style="color:black"></i> Eliminar</button>

            </form>


        </div>
	</section>

	<?php include "includes/footer.php" ?>
</body>
</html>