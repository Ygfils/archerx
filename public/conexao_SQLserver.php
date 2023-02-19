<?php

// Uma função de conexão para cada servidor.

function conect_gerenciador(){

    $conn = new PDO("sqlsrv:Database=GerenciadorAcessos;server=", "", "");
    if ($conn == false)
        die();
    
    return $conn;

}
function conect_topaceso(){

    $conn = new PDO("sqlsrv:Database=TOPACESSO;server=", "", "");
    if ($conn == false)
        die();
    
    return $conn;

}

?>