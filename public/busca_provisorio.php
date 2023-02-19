<?php

function conect(){

    $conn = new PDO("sqlsrv:Database=TopAcesso;server=PR661SR0109\SQLEXPRESS2", "USR_TOPACESSO", "top332");
    if ($conn == false)
        die();

    return $conn;

}

function select($sql,$mat)
{
    $conn = conect();
    $statement = $conn->prepare($sql);
    $statement->bindParam('matricula', $mat);
    $statement->execute();

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $result;

    stop($conn);

}

// Receber dados
$mat = filter_input(INPUT_GET, 'matricula', FILTER_SANITIZE_NUMBER_INT);

If(!empty($mat)){
    
    $sql = "SELECT TOP(1) CartoesProvisorios.NumeroCartao 
            FROM CartoesProvisorios
            INNER JOIN	Funcionarios ON CartoesProvisorios.COD_PESSOA = Funcionarios.COD_PESSOA
            WHERE Matricula = :matricula";

    $resultado_query_cartao = select($sql,$mat);

    $retorno = ['erro' => False, 'dados' => $resultado_query_cartao];

}else{

    $retorno = ['erro' => True]; 

}

echo json_encode($retorno);