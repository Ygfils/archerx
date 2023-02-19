<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="/style.css">
  <title>Login Engine</title>
</head>
<?php
include('conexao.php');
$login = $_POST["login"];
$senha = $_POST["pass"];

if (isset($_POST)) {
  $result = $conn->query("SELECT * FROM archerx.usuarios WHERE login = '$login' AND senha = '$senha'") or die("erro ao selecionar");
  if (($result->num_rows) <= 0) {
    echo "<script language='javascript' type='text/javascript'>
    alert('Login e/ou senha incorretos');window.location
    .href='login.html';</script>";
    die();
  } else {
    $cookiePath = "/";
    $cookieExpire = time() + (60 * 60 * 24); //one day -> seconds*minutes*hours
    setcookie("login", $login, $cookieExpire, $cookiePath);
    if (mysqli_fetch_assoc($result)['admin']) {
      setcookie("admin", $login, $cookieExpire, $cookiePath);
      echo "<script language='javascript' type='text/javascript'>
    alert('Você é Admin!');window.location
    .href='relatorio.php';</script>";
      die();
    }
    header("Location:relatorio.php");
    echo "Login Realizado com sucesso!";
  }
}
