<?php
session_start();
if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2){
    header("location: ./");
}

include "../conexion.php";

if(!empty($_POST)){
    if(empty($_POST['idproveedor']))
    {
        header("location: lista_proveedor.php");
        mysqli_close($conection);
    }

    $idproveedor = $_POST['idproveedor'];

    $query_delete = mysqli_query($conection,"UPDATE proveedor SET estatus = 0 WHERE codproveedor = $idproveedor");
    mysqli_close($conection);
    if($query_delete){
        header("location: lista_proveedor.php");
    }else{
        echo "Error al Eliminar Proveedor";
    }
}


if(empty($_REQUEST['id'])){
    header("location: lista_proveedor.php");
    mysqli_close($conection);
}else{

    $idproveedor= $_REQUEST['id'];

    $query = mysqli_query($conection, "SELECT * FROM proveedor WHERE codproveedor = $idproveedor");
    mysqli_close($conection);
    $result = mysqli_num_rows($query);

    if($result > 0){
        while($data = mysqli_fetch_array($query)){
            $proveedor  = $data['proveedor'];
        }
    }else{
        header("location: lista_proveedor.php");
    }

}



?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="css/style_delet.css">
	<?php include "includes/script.php" ?>
	<title>Eliminar Proveedor</title>
</head>
<body>
	<?php include "includes/header.php" ?>
	<section id="container">
		<div class="data_delete">
            <i class="fa-solid fa-box-open fa-7x" style="color:red"></i>
            <h2> ¿Está seguro de eliminar el siguiente Registro?</h2>
            <p>Nombre del Proveedor:<span><?php  echo $proveedor; ?></span></p>
            

            <form method="post" action="">
                <input type="hidden" name="idproveedor" value="<?php  echo $idproveedor; ?>">
                <a href="lista_proveedor.php" class="btn_cancel"><i class="fa-solid fa-ban" style="color:black"></i> Cancelar</a>
                <button type="submit" class="btn_ok"><i class="fa-solid fa-trash-can" style="color:black"></i> Eliminar</button>

            </form>


        </div>
	</section>

	<?php include "includes/footer.php" ?>
</body>
</html>