<?php

include('conexao_SQLserver.php');
 
// Receber dados
$mat = filter_input(INPUT_GET, 'matricula', FILTER_SANITIZE_NUMBER_INT);

// Vamos separar as buscas para evitar erros
If(!empty($mat)){
    
    $sql = "SELECT  Funcionarios.Nome,
                    Funcionarios.Cartao,
                    Funcionarios.Pis,
                    Departamentos.departamento,
                    Funcionarios.Situacao,
                    Funcionarios.DataDemissao,
                    a.Lacre as HeadAtual,
                    b.Lacre as HeadAntigo,
                    c.lacre as HeadEmprestimo

                FROM Funcionarios 
                LEFT JOIN Departamentos ON Departamentos.Id = Funcionarios.Id_departamento
                LEFT JOIN Headsets a ON a.Id = Funcionarios.Id_headset
                LEFT JOIN Headsets b ON b.id = Funcionarios.Id_headset_antigo
                LEFT JOIN Headsets c ON c.id = Funcionarios.Id_head_emprestimo 
                WHERE Funcionarios.Matricula = :matricula";

    $conn_funcionario = conect_gerenciador();
    $statement = $conn_funcionario->prepare($sql);
    $statement->bindParam('matricula', $mat);
    $statement->execute();
    $conn_funcionario = null;

    $resultado_query_funcionario = $statement->fetchAll(PDO::FETCH_ASSOC);

    $retorno = ['erro' => False, 'dados' => $resultado_query_funcionario];

    /////////////////// BUSCAR BLOQUEIO ///////////////////

    $sql = "SELECT Bloqueado FROM Funcionarios WHERE Matricula = :matricula";

    $conn_bloqueio = conect_topaceso();
    $statement = $conn_bloqueio->prepare($sql);
    $statement->bindParam('matricula', $mat);
    $statement->execute();
    $conn_bloqueio = null;

    $resultado_query_bloqueio = $statement->fetchAll(PDO::FETCH_ASSOC);

    array_push($retorno['dados'],$resultado_query_bloqueio);

}else{

    $retorno = ['erro' => True]; 

}

echo json_encode($retorno);