<?php

function init(){
    $usuario = '';
    $senha = '';
    $database = '';
    $host = '';

    $conn = new mysqli($host, $usuario, $senha, $database);

    if ($conn->error) {
        die("Falha ao conectar no Servidor: " . $conn->error);
    }
    else {
        echo "Conectado com sucesso!<br>";
    }
    return $conn;
}
function stop($conn){
    $conn->close(); 
    // echo "Conexão fechada <br>";
}

function select($sql){
    $conn = init();
    $result =$conn->query($sql);
    //echo "Executado select <br>";

    //echo "Encerrado a conexão <br>";
    //echo "Retornando o valor <br>";

    return $result;    
    stop($conn);

} 

function insert($sql){
    $conn = init();
    if ($conn->query($sql)){
        $result='sucesso';
    }else{
        $result='erro: '. mysqli_error($conn);
    }
    echo $result;
    // echo "Executado update <br>";
    // echo "Retornando o valor <br>";
    return $result;
    // echo "Encerrado a conexão <br>";
    stop($conn);
    return($result);
}


if (isset($_POST['et'])) {
    $maquina = mysqli_fetch_assoc(select('select id from archerx.hosts where serial="' . $_POST['ns'] . '"'));
    if ($maquina != "") {
        echo "<script language='javascript' type='text/javascript'>
        alert('A máquina já existe!');window.location;history.go(-1);</script>";
    } else {
        $insert_maquina = 'INSERT INTO archerx.hosts(`hostname`,`serial`)VALUES("'.$_POST['et'].'","'.$_POST['ns'].'")';
        if(insert($insert_maquina)=='sucesso'){
            echo "<script language='javascript' type='text/javascript'>
            alert('Máquina cadastrada com sucesso!');window.location;history.go(-1);</script>";
        } else {
            echo "<script language='javascript' type='text/javascript'>
            alert('Erro ao cadastrar máquina!');window.location;history.go(-1);</script>";
        }
    }
}
elseif (isset($_POST['setor'])) {
    $setor = mysqli_fetch_assoc(select('select id from archerx.setor where setor="' . $_POST['setor'] . '"'));
    if ($setor != "") {
        echo "<script language='javascript' type='text/javascript'>
        alert('O setor já existe!');window.location;history.go(-1);</script>";
    } else {
        $insert_setor = 'INSERT INTO archerx.setor (setor)VALUES("'.$_POST['setor'].'")';
        if(insert($insert_setor)=='sucesso'){
            echo "<script language='javascript' type='text/javascript'>
            alert('Setor cadastrada com sucesso!');window.location;history.go(-1);</script>";
        } else {
            echo "<script language='javascript' type='text/javascript'>
            alert('Erro ao cadastrar Setor!');window.location;history.go(-1);</script>";
        }
    }
}
elseif (isset($_POST['monitor'])) {
    $monitor=mysqli_fetch_assoc(select('select id from archerx.monitores where serie="'.$_POST['monitor'].'"'));
    if ($monitor!=""){
        echo "<script language='javascript' type='text/javascript'>
        alert('Monitor já existe!');window.location;history.go(-1);</script>";
    } else {
        $insert_monitor = 'INSERT INTO archerx.monitores (serie)VALUES("'.$_POST['monitor'].'")';
        if(insert($insert_monitor)=='sucesso'){
            echo "<script language='javascript' type='text/javascript'>
            alert('Monitor cadastrada com sucesso!');window.location;history.go(-1);</script>";
        } else {
            echo "<script language='javascript' type='text/javascript'>
            alert('Erro ao cadastrar Monitor!');window.location;history.go(-1);</script>";
        }
    }
}
elseif (isset($_POST['qdu'])) {
    $newqd=mysqli_fetch_assoc(select('select id from archerx.qdu where qdu_serial="'.$_POST['qdu_serial'].'"'));
    if ($newqd!=""){
        echo "<script language='javascript' type='text/javascript'>
        alert('QDU já existe!');window.location;history.go(-1);</script>";
    } else {
        $insert_qdu = 'INSERT INTO archerx.qdu (qdu_serial) VALUES ("'.$_POST['qdu'].'")';
        if(insert($insert_qdu)=='sucesso'){
            echo "<script language='javascript' type='text/javascript'>
            alert('Máquina cadastrada com sucesso!');window.location;history.go(-1);</script>";
        } else {
            echo "<script language='javascript' type='text/javascript'>
            alert('Erro ao cadastrar máquina!');window.location;history.go(-1);</script>";
        }
    }    
}
else{
    echo "<script language='javascript' type='text/javascript'>
        alert('Erro ao cadastrar!');window.location;history.go(-1);</script>";
}

die();
?>