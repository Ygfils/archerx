<?php

$usuario_db = 'archer';
$senha_db = 'B5n3Qz2vL7HAUs7z';
$database_db = 'archerx';
$host_db = '172.10.20.47';

$conn = new mysqli($host_db, $usuario_db, $senha_db, $database_db);

if ($conn->error) {
    die("Falha ao conectar no Servidor: " . $conn->erro);
}
