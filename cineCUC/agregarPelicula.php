<!DOCTYPE html>
<html>
    <head>
        <title>Agregar Peliculas</title>
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
  $update = false;
  if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $update = true;
    $result = $con->query("SELECT * FROM peliculas WHERE id_pelis = $id");
        if (count($result)==1){
            $filas = $result->fetch_array();
            $nombrePelicula = $filas['nombre_pelicula'];
            $descripcion = $filas['descripcion'];
            $director = $filas['director'];
            $genero = $filas['genero'];

        }
    }

    if(isset($_POST['save']) and $_POST["NomPelicula"] != "" and $_POST['Descripcion'] != "" and $_POST['Director'] != "" and $_POST['Genero'] != ""){

        $nombrePelicula = $_POST['NomPelicula'];
        $descripcion = $_POST['Descripcion'];
        $director = $_POST['Director'];
        $genero = $_POST['Genero'];

        echo $genero;

        $sql = "INSERT INTO peliculas(nombre_pelicula, descripcion, director, genero)VALUES('"  .  $nombrePelicula . "' , '"  .  $descripcion . "', '"  .  $director . "', '"  .  $genero . "')";
        $con->query($sql);
        header("Location: agregarPelicula.php");
    }

    if(isset($_GET['delete'])){
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
    }

?>

    <div class = "row">
        <div class="form-group col-sm-2"></div>
        <div class="form-group col-sm-8">
            <form name="formulario" method="post" action="agregarPelicula.php">    
                <input type="hidden" name="id" value=" <?php echo $id; ?> ">
            <br><h2 style="text-align:center;"> Agregar Peliculas</h2><br>
             <div class="row">
                 <div class="col-sm-4">
                    <label >Nombre Pelicula</label><input type="text" id="NomPelicula" name="NomPelicula" class="form-control" value="<?php echo $nombrePelicula; ?>" placerholder="Ingrese Nombre Pelicula" required></div>
                <div class="col-sm-4">
                    <label >Director</label><input type="text" id="Director" name="Director" class="form-control" value="<?php echo $director; ?>" placerholder="Ingrese director de la Pelicula" required></div>
                <div class="col-sm-4"> 
                    <label >Genero</label><input type="text" id="Genero" name="Genero" class="form-control" value="<?php echo $genero; ?>" placerholder="Ingrese Genero de la Pelicula" required></div>
                </div>
                <div class=" col-sm-12"><br>
                <label >Descripcion</label><textarea class="form-control" id="Descripcion" name="Descripcion" placeholder="Escriba una Breve descripcion" required><?php echo $descripcion; ?></textarea>
                </div><br>
       
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
                        <th style="<?php echo 'width: 15%;' ?>">Nombre</th>
                        <th>Director</th>
                        <th>Genero</th>
                        <th>Descripcion</th>
                        </tr>
                </thead>
                <tbody>
        <?php while ($filas=mysqli_fetch_assoc($sql)) {
        ?>
                    <tr>
                        <td>							
                    <a href="agregarPelicula.php?edit=<?php echo $filas['id_pelis']; ?>"
                    class="<?php echo 'btn btn-info'?>">✎</a>
	    	        <a href="agregarPelicula.php?delete=<?php echo $filas['id_pelis']; ?>"
                    class="<?php echo 'btn btn-danger'?>">✘</a>
	                    </td>
                        <td><?php echo $filas['nombre_pelicula']?></td>
                        <td><?php echo$filas['director']?></td>
                        <td><?php echo$filas['genero']?></td>
                        <td><?php echo$filas['descripcion']?></td>
     
                    </tr>
        <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
    
</body>
</html>