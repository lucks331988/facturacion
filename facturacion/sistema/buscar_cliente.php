<?php
session_start();
include '../conexion.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="css/style3.css">
    <link type="text/css" rel="stylesheet" href="css/paginador.css">
    <link type="text/css" rel="stylesheet" href="css/search.css">
    <?php include "includes/script.php";?>
	<title>Lista de clientes</title>
</head>
<body>
    <?php include "includes/header.php";?>
	<section id="container">
    <?php
        $busqueda = strtolower($_REQUEST['busqueda']);

        if(empty($busqueda)){
            header ("location:lista_clientes.php");
            mysqli_close($conection);
        }



    ?>
		<h1>Lista de Clientes</h1>
        <a href="registro_cliente.php" class = "btn_new">Crear cliente</a>
        <form action="buscar_cliente.php" method="get" class="form_search">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda; ?>">
            <button type="submit" class="btn_search"><i class="fa-solid fa-magnifying-glass" style="color:#fff;"></i></button>
        </form>
        <table>
            <tr>
                <th class="th">ID</th>
                <th class="th">Cuit</th>
                <th class="th">Nombre</th>
                <th class="th">Telefono</th>
                <th class="th">Direccion</th>
                <th class="th">Acciones</th>
            </tr>
                <?php
                //paginador
                $sql_registe = mysqli_query($conection, "SELECT COUNT(*) as total_registro FROM cliente 
                WHERE 
                (
                idcliente LIKE '%$busqueda%' OR
                cuit LIKE    '%$busqueda%' OR
                nombre LIKE    '%$busqueda%' OR
                telefono LIKE   '%$busqueda%' OR
                direccion LIKE   '%$busqueda%')");

                $result_register = mysqli_fetch_array($sql_registe);

                $total_registro = $result_register['total_registro'];

                $por_pagina = 10;

                if(empty($_GET['pagina'])){
                    $pagina = 1;
                }else{
                    $pagina = $_GET['pagina'];
                }

                $desde = ($pagina - 1) * $por_pagina;
                $total_paginas = ceil($total_registro / $por_pagina);
                    $query = mysqli_query($conection, "SELECT * FROM cliente  WHERE (
                                                                        idcliente LIKE '%$busqueda%' OR
                                                                        cuit   LIKE '%$busqueda%' OR
                                                                        nombre    LIKE '%$busqueda%' OR
                                                                        telefono   LIKE '%$busqueda%' OR
                                                                        direccion   LIKE '%$busqueda%') AND idcliente
                                                                        ORDER BY idcliente ASC LIMIT $desde, $por_pagina");
                mysqli_close($conection);
                    $result = mysqli_num_rows($query);
                    if($result > 0)
                    {
                        while($data = mysqli_fetch_array($query)){
            ?>
            <tr>
                <td><?php echo $data['idcliente'];?></td>
                <td><?php echo $data['cuit'];?></td>
                <td><?php echo $data['nombre'];?></td>
                <td><?php echo $data['telefono'];?></td>
                <td><?php echo $data['direccion'];?></td>
                <td>
                    <a class="link_edit" href="editar_cliente.php?id=<?php echo $data['idcliente'];?>">Editar</a>

                    <?php if($_SESSION['rol'] == 1 ||$_SESSION['rol'] == 2){ ?>
                    |
                    <a class="link_delete" href="eliminar_confirmar_cliente.php?id=<?php echo $data['idcliente'];?>">Eliminar</a>
                    <?php } ?>
                </td>
            </tr>
            <?php
                        }
                    }
                ?>
        </table>
        <?php

        if($total_registro != 0){

        ?>
        <div class="paginador">
            <ul>
                <?php 
                if($pagina != 1){
                ?>
                <li><a href="?pagina= <?php  echo 1;?>&busqueda=<?php echo $busqueda;?>">|<</a></li>
                <li><a href="?pagina= <?php  echo $pagina - 1;?>&busqueda=<?php echo $busqueda;?>"><<</a></li>
                
                <?php
                }
                for ($i=1; $i <= $total_paginas; $i++) { 
                        if($i == $pagina){
                            echo '<li class="pageSelected">'.$i.'</li>';
                        }else{
                            echo '<li><a href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';
                        }
                } 
                if($pagina != $total_paginas){
                ?>
                <li><a href="?pagina= <?php  echo $pagina + 1;?>&busqueda=<?php echo $busqueda;?>">>></a></li>
                <li><a href="?pagina= <?php  echo $total_paginas;?>&busqueda=<?php echo $busqueda;?>">>|</a></li>
                <?php } ?>
            </ul>
        </div>
        <?php } ?>
	</section>

	<?php include "includes/footer.php" ?>
</body>
</html>