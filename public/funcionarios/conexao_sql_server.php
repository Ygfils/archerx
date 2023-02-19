<?php

$connection = new PDO("sqlsrv:Database=GerenciadorAcessos;server=PR661SR0109\SQLEXPRESS2", "USR_TOPACESSO", "top332");

$statement = $connection->prepare("SELECT * FROM Funcionarios");

$statement->execute();

$users = $statement->fetchAll(PDO::FETCH_ASSOC);

echo($users)

?>