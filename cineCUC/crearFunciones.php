<!DOCTYPE html>
<html>
    <head>
        <title>Crear Funciones</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta charset="utf-8">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> 
    </head>
    <style>
    hr {
        margin-top: 1rem;
        margin-bottom: 1rem;
        border: 0;
        border-top: 2px solid rgba(0, 0, 0, 0.1);
    }
    </style>
<body>
<?php require 'partials/header.php' ?>
<?php
error_reporting(0);
/*Datos de conexion a la base de datos*/
  $db_host = "localhost";
  $db_user = "root";
  $db_pass = "";
  $db_name = "cinecuc";

  $con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if(mysqli_connect_errno()){
        echo 'No se pudo conectar a la base de datos : '.mysqli_connect_error();
    }

  $sql = mysqli_query($con, "SELECT * FROM peliculas");
  $id = 0;
  $nombrePelicula =  '';
  $descripcion = '';
  $director = '';
  $genero = '';
  if(isset($_GET['add'])){
    $id = $_GET['add'];
    $result = $con->query("SELECT * FROM peliculas WHERE id_pelis = $id");
        if (count($result)==1){
            $filas = $result->fetch_array();
            $nombrePelicula = $filas['nombre_pelicula'];
        }
    }
    
  $sql2 = mysqli_query($con, "SELECT * FROM funciones");
  $id = 0;
  $id_pelis = 0;
  $nombre_pelicula =  '';
  $fecha_inicio = '';
  $fecha_fin = '';
  $lugar = '';
  $direccion = '';
  $cupos = 0;
  $update = false;
  if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $update = true;
    $result2 = $con->query("SELECT * FROM funciones WHERE id_func = $id");
        if (count($result2)==1){
            $filas2 = $result2->fetch_array();
            $id_pelis = $filas2['id_pelis'];
            $nombre_pelicula = $filas2['nombre_pelicula'];
            $fecha_inicio = $filas2['fecha_inicio'];
            $fecha_fin = $filas2['fecha_fin'];
            $lugar = $filas2['lugar'];
            $direccion = $filas2['direccion_lugar'];
            $cupos = $filas2['cupos'];
        }
    }

    if(isset($_POST['save']) and $_POST["id_pelis"] != "" and $_POST['fec_inicio'] != "" and $_POST['fec_fin'] != "" and $_POST['Lugar'] != ""){
        $id_pelis = $_POST['id_pelis'];
        $nombre_pelicula = $_POST['nombre_pelicula'];
        $fecha_inicio = $_POST['fec_inicio'];
        $fecha_fin = $_POST['fec_fin'];
        $lugar = $_POST['Lugar'];
        $direccion = $_POST['Direccion'];
        $cupos = $_POST['Cupos'];

        echo $nombre_pelicula;

        $sql2 = "INSERT INTO funciones(id_pelis, nombre_pelicula, fecha_inicio, fecha_fin, lugar, direccion_lugar, cupos)VALUES('"  .  $id_pelis . "' , '"  .  $nombre_pelicula . "' , '"  .  $fecha_inicio . "', '"  .  $fecha_fin . "', '"  .  $lugar . "' , '"  .  $direccion . "' , '"  .  $cupos . "')";
        $con->query($sql2);
        header("Location: crearFunciones.php");
    }

    /*if(isset($_GET['delete'])){
        $id = $_GET['delete'];
        $con->query("DELETE FROM peliculas WHERE id_pelis = $id");
        header("Location: agregarPelicula.php");
    }

    if(isset($_POST['update'])){
        $id = $_POST['id'];
        $newName = $_POST['NomPelicula'];
        $newDesc = $_POST['Descripcion'];
        $newDir = $_POST['Director'];
        $newGen = $_POST['Genero'];

        $con->query("UPDATE peliculas SET nombre_pelicula='$newName', descripcion='$newDesc', director='$newDir', genero='$newGen'  WHERE id_pelis = $id");
        header("Location: agregarPelicula.php");
    }*/

?>

    <div class = "row">
        <div class="form-group col-sm-2"></div>
        <div class="form-group col-sm-8">
            <form name="formulario" method="post" action="crearFunciones.php">    
                <input type="hidden" name="id" value=" <?php echo $id; ?> ">
            <br><h2 style="text-align:center;"> Agregar Peliculas</h2><br>
             <div class="row">
                 <div class="col-sm-4">
                    <label >Nombre Pelicula</label> 
                        <select class="form-control" id="id_pelis" name="id_pelis" onchange="showSelected();" required>
                        <?php if ($update == true): ?>
                            <option value="<?php echo $id_pelis?>"> <?php echo $nombre_pelicula?> </option>
                        <?php endif; ?>
                        <?php while ($filas=mysqli_fetch_assoc($sql)) { ?>
                            <option value="<?php echo $filas['id_pelis']?>"> <?php echo $filas['nombre_pelicula']?> </option>
                        <?php } ?>
                        
                        </select>
                    <input type="hidden" id="nombre_pelicula" name="nombre_pelicula" value="">
                    
                    
                </div>
                <div class="col-sm-4">
                    <label >Fecha Inicio</label><input type="datetime-local" id="fec_inicio" name="fec_inicio" class="form-control" value="<?php echo $fecha_inicio; ?>" required></div>
                <div class="col-sm-4"> 
                    <label >Fecha Fin</label><input type="datetime-local" id="fec_fin" name="fec_fin" class="form-control" value="<?php echo $fecha_fin; ?>" required></div>
                </div><br>
                
                <div class="row">
                 <div class="col-sm-4">
                    <label >Lugar</label><input type="text" id="Lugar" name="Lugar" class="form-control" value="<?php echo $lugar; ?>" required></div>
                <div class="col-sm-4">
                    <label >Dirección del Lugar</label><input type="text" id="Direccion" name="Direccion" class="form-control" value="<?php echo $direccion; ?>" required></div>
                <div class="col-sm-4"> 
                    <label >Cupos</label><input type="number" id="Cupos" name="Cupos" class="form-control" value="<?php echo $cupos; ?>" required></div>
                </div>

                <br>

       
        <?php if ($update == true): ?>
            <button type="submit" class="<?php echo 'btn btn-info btn-block' ?>" name="update">Actualizar</button><br>
        <?php else: ?>
            <button type="submit" class="<?php echo 'btn btn-success btn-block' ?>" name="save" >Guardar</button><br>
        <?php endif; ?>
            </form>


        <div class="<?php echo 'container' ?>">
            <table class="<?php echo 'table table-striped' ?>">
                <thead>
                    <tr>
                        <th style="<?php echo 'width: 15%;' ?>"></th>
                        <th style="<?php echo 'width: 15%;' ?>">Nombre Pelicula</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Lugar</th>
                        <th>Direccion</th>
                        <th>Cupos</th>
                        </tr>
                </thead>
                <tbody>
        <?php while ($filas2=mysqli_fetch_assoc($sql2)) {
        ?>
                    <tr>
                        <td>							
                        <a href="crearFunciones.php?edit=<?php echo $filas2['id_func']; ?>"
                        class="<?php echo 'btn btn-info'?>">✎</a>
	    	            <a href="crearFunciones.php?delete=<?php echo $filas2['id_func']; ?>"
                        class="<?php echo 'btn btn-danger'?>">✘</a>
                        </td>
                        <td><?php echo $filas2['nombre_pelicula']?></td>
                        <td><?php echo $filas2['fecha_inicio']?></td>
                        <td><?php echo$filas2['fecha_fin']?></td>
                        <td><?php echo$filas2['lugar']?></td>
                        <td><?php echo$filas2['direccion_lugar']?></td>
                        <td><?php echo$filas2['cupos'] ?></td>
     
                    </tr>
        <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">

document.addEventListener('DOMContentLoaded', (e) => {
    showSelected();
})

function showSelected()
{

/* Para obtener el valor */
//var cod = document.getElementById("peli_name").value;
//document.getElementById("id_pelis").value = cod;

 
/* Para obtener el texto */
var combo = document.getElementById("id_pelis");
var selected = combo.options[combo.selectedIndex].text;
document.getElementById("nombre_pelicula").value = selected;

}
</script>
    
</body>
</html>