<?php

session_start();
include '../conexion.php';
if(!empty($_POST))
{
    $alert ='';
    if(empty($_POST['cuit']) ||empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion']))
    {
        $alert ='<p class="msg_error">Todos los campos son obligatorios.</p>';
    }else{
        $idcliente = $_POST['id'];
        $cuit      = $_POST['cuit'];
        $nombre    = $_POST['nombre'];
        $telefono  = $_POST['telefono'];
        $direccion = ($_POST['direccion']);
        $result = 0;

        if(is_numeric($cuit) and $cuit != 0){
            $query = mysqli_query($conection, "SELECT * FROM cliente
                                                    WHERE (cuit='$cuit' AND idcliente != $idcliente)");
        $result =mysqli_fetch_array($query);
        }
        if($result > 0)
        {
            $alert ='<p class="msg_error">El CUIT/CUIL o el cliente ya existe.</p>';
        }else{
            $sql_update = mysqli_query($conection, "UPDATE cliente SET cuit ='$cuit', nombre = '$nombre', telefono = '$telefono', direccion = '$direccion' WHERE idcliente = $idcliente");
            
            
            if($sql_update)
            {
                $alert ='<p class="msg_save">Usuario Actualizado correctamente.</p>';
            }else{
                $alert ='<p class="msg_error">Error al Actualizar el usuario.</p>';
            }
        }
    }
}


//mostar datos
if(empty($_REQUEST['id'])){
    header('Location: lista_clientes.php');
    mysqli_close($conection);
}
$idcliente = $_REQUEST['id'];

$sql = mysqli_query($conection, "SELECT * FROM cliente WHERE idcliente =$idcliente AND estatus = 1");
mysqli_close($conection);

$result_sql = mysqli_num_rows($sql);

if($result_sql == 0){
        header('Location: lista_clientes.php');
}else{
    while($data = mysqli_fetch_array($sql)){
        $idcliente  = $data['idcliente'];
        $cuit       = $data['cuit'];
        $nombre     = $data['nombre'];
        $telefono   = $data['telefono'];
        $direccion  = $data['direccion'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="css/style2.css">
    <?php include "includes/script.php";?>
	<title>Actualizar Cliente</title>
</head>
<body>
<?php include "includes/header.php";?>
	<section id="container">

		<div class ="form_register">
            <h1><i class="fa-regular fa-pen-to-square"></i>Actualizar Cliente</h1>
            <hr>
            <div class="alert"> <?php echo isset($alert)? $alert: ''; ?></div>

            <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $idcliente; ?>">
                <lavel for="cuit">CUIT O CUIL</lavel>
                <input type="number" name="cuit" id="cuit" placeholder="Numero de CUIT o CUIL" value="<?php echo $cuit; ?>">
                <lavel for="nombre">Nombre</lavel>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre completo" value="<?php echo $nombre; ?>">
                <lavel for="telefono">Telefono</lavel>
                <input type="number" name="telefono" id="telefono" placeholder="Telefono" value="<?php echo $telefono; ?>">
                <lavel for="direccion">Direccion</lavel>
                <input type="text" name="direccion" id="direccion" placeholder="ingrese su Direccion" value="<?php echo $direccion; ?>">
                </select>
                <button type="submit" class="btn_save"><i class="fa-regular fa-pen-to-square"></i> Actualizar Usuario</button>
            </form>
        </div>

	</section>

	<?php include "includes/footer.php" ?>
</body>
</html>