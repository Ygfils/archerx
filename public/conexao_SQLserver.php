<?php

function conect_gerenciador(){

    $conn = new PDO("sqlsrv:Database=GerenciadorAcessos;server=PR661SR0109\SQLEXPRESS2", "USR_TOPACESSO", "top332");
    if ($conn == false)
        die();
    
    return $conn;

}
function conect_topaceso(){

    $conn = new PDO("sqlsrv:Database=TOPACESSO;server=PR661SR0109\SQLEXPRESS2", "USR_TOPACESSO", "top332");
    if ($conn == false)
        die();
    
    return $conn;

}

?>