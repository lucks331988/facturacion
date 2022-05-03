<?php

session_start();
session_start();
if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2){
    header("location: ./");
}

include '../conexion.php';
if(!empty($_POST))
{
    $alert ='';
    if(empty($_POST['proveedor']) ||empty($_POST['contacto']) || empty($_POST['telefono']) || empty($_POST['direccion']))
    {
        $alert ='<p class="msg_error">Todos los campos son obligatorios.</p>';
    }else{
        $idproveedor = $_POST['id'];
        $proveedor      = $_POST['proveedor'];
        $contacto    = $_POST['contacto'];
        $telefono  = $_POST['telefono'];
        $direccion = ($_POST['direccion']);
        $result = 0;

            $sql_update = mysqli_query($conection, "UPDATE proveedor SET proveedor ='$proveedor', contacto = '$contacto', telefono = '$telefono', direccion = '$direccion' WHERE codproveedor = $idproveedor");
            
            
            if($sql_update)
            {
                $alert ='<p class="msg_save">Proveedor Actualizado correctamente.</p>';
            }else{
                $alert ='<p class="msg_error">Error al Actualizar el Proveedor.</p>';
            }
        }
    }



//mostar datos
if(empty($_REQUEST['id'])){
    header('Location: lista_proveedor.php');
    mysqli_close($conection);
}
$idproveedor = $_REQUEST['id'];

$sql = mysqli_query($conection, "SELECT * FROM proveedor WHERE codproveedor = $idproveedor AND estatus = 1");
mysqli_close($conection);

$result_sql = mysqli_num_rows($sql);

if($result_sql == 0){
        header('Location: lista_proveedor.php');
}else{
    while($data = mysqli_fetch_array($sql)){
        $idproveedor  = $data['codproveedor'];
        $proveedor    = $data['proveedor'];
        $contacto     = $data['contacto'];
        $telefono     = $data['telefono'];
        $direccion    = $data['direccion'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="css/style2.css">
    <?php include "includes/script.php";?>
	<title>Actualizar Proveedor</title>
</head>
<body>
<?php include "includes/header.php";?>
	<section id="container">

		<div class ="form_register">
            <h1><i class="fa-solid fa-box-open"></i> Actualizar Proveedor</h1>
            <hr>
            <div class="alert"> <?php echo isset($alert)? $alert: ''; ?></div>

            <form action="" method="post">
            <input type="hidden" name="id"  value="<?php echo $idproveedor;?>">
                <lavel for="proveedor">Proveedor</lavel>
                <input type="text" name="proveedor" id="proveedor" placeholder="Nombre del Proveedor" value="<?php echo $proveedor;?>">
                <lavel for="contacto">Contacto</lavel>
                <input type="text" name="contacto" id="contacto" placeholder="Nombre completo del contacto"value="<?php echo $contacto;?>">
                <lavel for="telefono">Telefono</lavel>
                <input type="number" name="telefono" id="telefono" placeholder="ingrese un Telefono"value="<?php echo $telefono;?>">
                <lavel for="direccion">Direccion</lavel>
                <input type="text" name="direccion" id="direccion" placeholder="ingrese su Direccion" value="<?php echo $direccion;?>">
                </select>
                <button type="submit" class="btn_save"><i class="fa-solid fa-floppy-disk"></i>Guardar proveedor</button>
            </form>
        </div>

	</section>

	<?php include "includes/footer.php" ?>
</body>
</html>