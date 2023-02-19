<?php

function conect(){

    $conn = new PDO("sqlsrv:Database=GerenciadorAcessos;server=PR661SR0109\SQLEXPRESS2", "USR_TOPACESSO", "top332");
    if ($conn == false)
        die();

    return $conn;

}
function insert($sql,$mat)
{
    $conn = conect();
    $statement = $conn->prepare($sql);
    $statement->bindParam('matricula', $mat);
    $statement->execute();

    stop($conn);
}
function select($sql)
{
    $conn = conect();
    $statement = $conn->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $result;

    stop($conn);

}

// Receber dados
$dados = filter_input_array(INPUT_GET);

$dados = explode(',', $dados['dados_head']);

// separar as varáveis

$matricula = $dados[0];
$head_novo = $dados[1];
$chamado = $dados[2];
$motivo = $dados[3];
$desconto = $dados[4];


$sql = "SELECT Lacre FROM Headsets WHERE Lacre = ".$dados[1];

$resultado = select($sql);

$retorno = ['erro' => False, 'dados' => $resultado];

echo json_encode($retorno);

?>