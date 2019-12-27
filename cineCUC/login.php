<?php

  session_start();

  if (isset($_SESSION['user_id'])) {
    header('Location: /cineCUC');
  }
  require 'database.php';

  if (!empty($_POST['email']) && !empty($_POST['password']) ) {
    $records = $conn->prepare('SELECT id_user, email, password, tipo FROM usuario WHERE email = :email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $message = '';
    error_reporting(0);
    if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
      $_SESSION['user_id'] = $results['id_user'];
      header("Location: /cineCUC");
    } else {
      $message = 'Sorry, those credentials do not match';
    }
  }

  $con = mysqli_connect($server, $username, $password, $database);

    if(mysqli_connect_errno()){
        echo 'No se pudo conectar a la base de datos : '.mysqli_connect_error();
    }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
    <?php require 'partials/header.php' ?>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <h1>Ingresar</h1>
    <span>o <a href="signup.php">Registrarse</a></span>

    <form action="login.php" method="POST">
      <input name="email" type="text" placeholder="Ingrese su Email">
      <input name="password" type="password" placeholder="Ingrese su Contraseña">
      <input type="submit" value="Submit">
    </form>
  </body>
</html>