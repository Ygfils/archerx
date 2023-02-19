<?php

$usuario_db = '';
$senha_db = '';
$database_db = '';
$host_db = '';

$conn = new mysqli($host_db, $usuario_db, $senha_db, $database_db);

if ($conn->error) {
    die("Falha ao conectar no Servidor: " . $conn->error);
}

?>