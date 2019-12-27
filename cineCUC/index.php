<?php
  session_start();

  require 'database.php';

  if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT id_user, email, password FROM usuario WHERE id_user = :id_user');
    $records->bindParam(':id_user', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if (count($results) > 0) {
      $user = $results;
    }

    $con = mysqli_connect($server, $username, $password, $database);

    if(mysqli_connect_errno()){
        echo 'No se pudo conectar a la base de datos : '.mysqli_connect_error();
    }

    $uid = $_SESSION['user_id'];
  $sql = mysqli_query($con, "SELECT tipo FROM usuario WHERE id_user = $uid");
  if(isset($_GET['tipo'])){
    $tipo = $_GET['tipo'];
    }

    while ($filas=mysqli_fetch_assoc($sql)) {
        $test = $filas['tipo'];
    }

  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Welcome to the Login</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> 
    
  </head>
  <body>
    <?php require 'partials/header.php' ?>
    <div class="row">
      <div class="col-sm-4"></div>
      <div class="row col-sm-4">
    <?php if(!empty($user)): ?>
      <br> <h2 style="text-align: center;">Bienvenido <?= $user['email']; ?></h2>

        <?php if($test == 'admin'): ?>
            <br> <h2 style="text-align: center; margin-left: 5rem;">Eres Administrador</h2><br>
            <a style="margin-bottom: 20px; margin-top:20px;" class="btn btn-success btn-block" id="buton" href="./agregarPelicula.php">Agregar Peliculas</a><br>
            <a class="btn btn-success btn-block" href="./crearFunciones.php">Crear Funciones</a><br>
        <?php endif; ?>
        <?php if($test == 'cliente'): ?>
            <br> <h2 style="text-align: center;" >Sesión Cliente</h2>
        <?php endif; ?>
      <a href="logout.php"><br>
        <p style="text-align: center; margin-left: 11rem;"> Cerrar Sesión</p>
      </a>
    <?php else: ?>
      <br>
      <h2 style="margin-bottom: 50px; margin-top: 50px; margin-left: 15px;">Porfavor Registrese o Ingrese</h2>

      <div class="col-sm-3"></div>
      <a class="col-sm-3" href="login.php"><h4>Ingresar</h4></a> 
      <a class="col-sm-3" href="signup.php"><h4 >Registrarse</h4></a>
      <div class="col-sm-3"></div>
    <?php endif; ?>
      </div>
      <div class="col-sm-4"></div>
    </div>
  </body>
</html>