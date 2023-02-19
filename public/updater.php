<?php

function init(){
    $usuario = 'archer';
    $senha = 'B5n3Qz2vL7HAUs7z';
    $database = 'archerx';
    $host = '172.10.20.47';

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

function update($sql){
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


function updater_finder(){
    // $conn = init();
    echo $_POST['baia']."<br>";
    echo $_POST['serial']."<br>";
    echo $_POST['hostname']."<br>";
    echo $_POST['qdu_serial']."<br>";
    echo $_POST['ramal']."<br>";
    echo $_POST['ramal_dg']."<br>";
    echo $_POST['serie']."<br>";
    echo $_POST['setor']."<br>";
    // stop($conn);
}

if (isset($_POST['atualizar'])) {

    $old_data = 'SELECT B.id, B.baia, C.serial, C.hostname, D.qdu_serial, E.ramal, F.ramal as ramal_dg, G.serie, H.setor
    FROM archerx.acs_uni as A
    LEFT JOIN archerx.baia as B
    ON A.id_baia = B.id 
    LEFT JOIN archerx.hosts as C
    ON A.id_hostname = C.id
    LEFT JOIN archerx.qdu as D
    ON A.id_qdu = D.id
    LEFT JOIN archerx.ramal_baia as F
    ON A.id_ramal_baia = F.id
    LEFT JOIN archerx.monitores as G
    ON A.id_monitores = G.id
    LEFT JOIN archerx.setor as H
    ON A.id_setor = H.id
    LEFT JOIN archerx.ramal as E
    ON A.id_ramal = E.id where B.baia="' . $_POST['baia'] . '"';

    $result = mysqli_fetch_assoc(select($old_data));

    // SETOR
    if ($_POST['setor'] != $result['setor']) {
        if($_POST['setor'] == 'VAIO'){
            $query_update_setor = 'UPDATE archerx.acs_uni SET id_setor = NULL WHERE id_baia =\'' . $result['id'] . '\'';
            if (update($query_update_setor) == 'sucesso') {
                echo "<script language='javascript' type='text/javascript'>
                alert('Atualizado com sucesso!');window.location;history.go(-1);</script>";
            }
        }else{
            $query_update_setor = 'UPDATE archerx.acs_uni SET id_setor = (SELECT id FROM setor WHERE setor LIKE\'' . $_POST['setor'] . '\') WHERE id_baia =\'' . $result['id'] . '\'';
            if (update($query_update_setor) == 'sucesso') {
                echo "<script language='javascript' type='text/javascript'>
                alert('Atualizado com sucesso!');window.location;history.go(-1);</script>";
            }
        }
    }

    // RAMAL
    if ($_POST['ramal_dg'] != $result['ramal_dg']) {

        $newramal = mysqli_fetch_assoc(select('select id from archerx.ramal_baia where ramal="' . $_POST['ramal_dg'] . '"'));

        if ($newramal == "") {

            $query_insert_ramal = 'INSERT INTO archerx.ramal_baia (ramal,tipo,servidor) VALUES (' . $_POST['ramal_dg'] . ',"geral",0)';

            if (update($query_insert_ramal) == 'sucesso') {

                $query_update_monitor = 'UPDATE archerx.acs_uni SET id_ramal_baia = (SELECT id FROM ramal_baia WHERE ramal =\'' . $_POST['ramal_dg'] . '\') WHERE id_baia =\'' . $result['id'] . '\'';

                if (update($query_update_monitor) == 'sucesso') {
                    echo "<script language='javascript' type='text/javascript'>
                        alert('Atualizado com sucesso!');window.location;history.go(-1);</script>";
                    echo '<script type="text/JavaScript"> location.reload(); </script>';
                }
            }
        } else {
            $count_monitor = mysqli_fetch_row(select('select count(*) from archerx.acs_uni where id_ramal_baia ="' . $_POST['ramal_dg'] . '"'));
            if ($count_monitor[0] >= 1) {
                echo "<script language='javascript' type='text/javascript'>
            alert('Ramal alocado em outra baia!');window.location;history.go(-1);</script>";
            } else {
                $query_update_monitor = 'UPDATE archerx.acs_uni SET id_ramal_baia = (SELECT id FROM ramal_baia WHERE ramal =\'' . $_POST['ramal_dg'] . '\') WHERE id_baia =\'' . $result['id'] . '\'';
                if (update($query_update_monitor) == 'sucesso') {
                    echo "<script language='javascript' type='text/javascript'>
                alert('Atualizado com sucesso!');window.location;history.go(-1);</script>";
                    echo '<script type="text/JavaScript"> location.reload(); </script>';
                }
            }
        }
    }
    
    // SERIAL E HOSTNAME
    // PRIMEIRO VERIFICA SE HOUVE ALTERAÇÃO
    if ($_POST['serial'] != $result['serial']) {
        // DEPOIS VERIFICA SE O VALOR É NULO 
        if ($_POST['serial'] != "") {
            // SE NÃO FOR NULO VAI BUSCAR SE O SERIAL EXISTE
            $newserial = mysqli_fetch_assoc(select('select id from archerx.hosts where serial="' . $_POST['serial'] . '"'));
            if ($newserial == "") {
                echo "<script language='javascript' type='text/javascript'>
            alert('Serial não localizado tente novamente!');window.location;history.go(-1);</script>";
            } else {
                // VAI VERIFICAR SE O VALOR NÂO ESTÁ DUPLICADO
                $count_serial = mysqli_fetch_row(select('select count(*) from archerx.acs_uni where id_hostname="' . $newserial['id'] . '"'));
                if ($count_serial[0] >= 1) {
                    echo "<script language='javascript' type='text/javascript'>
                alert('Serial alocado em outra baia!');window.location;history.go(-1);</script>";
                } else {
                    // SE PASSAR NOS TESTES ATUALIZA
                    $qup_serial = 'UPDATE archerx.acs_uni SET id_hostname=\'' . $newserial['id'] . '\' WHERE id_baia =\'' . $result['id'] . '\'';
                    if (update($qup_serial) == 'sucesso') {
                        echo "<script language='javascript' type='text/javascript'>
                    alert('Atualizado com sucesso!');window.location;history.go(-1);</script>";
                    }
                }
            }
        } else {
            // VAI SETAR NULO
            $qup_serial = 'UPDATE archerx.acs_uni SET id_hostname= NULL WHERE id_baia =\'' . $result['id'] . '\'';
            if (update($qup_serial) == 'sucesso') {
                echo "<script language='javascript' type='text/javascript'>
            alert('Atualizado com sucesso!');window.location;history.go(-1);</script>";
            }
        }
    }

    // MONITOR
    if ($_POST['serie'] != $result['serie']) {
        $newmonitor = mysqli_fetch_assoc(select('select id from archerx.monitores where serie="' . $_POST['serie'] . '"'));
        if ($newmonitor == "") {
            echo "<script language='javascript' type='text/javascript'>
        alert('Monitor não localizado tente novamente!');window.location;history.go(-1);</script>";
        } else {
            $count_monitor = mysqli_fetch_row(select('select count(*) from archerx.acs_uni where id_monitores="' . $_POST['serie'] . '"'));
            if ($count_monitor[0] >= 1) {
                echo "<script language='javascript' type='text/javascript'>
            alert('Monitor alocado em outra baia!');window.location;history.go(-1);</script>";
            } else {
                $query_update_monitor = 'UPDATE archerx.acs_uni SET id_monitores = (SELECT id FROM monitores WHERE serie =\'' . $_POST['serie'] . '\') WHERE id_baia =\'' . $result['id'] . '\'';
                if (update($query_update_monitor) == 'sucesso') {
                    echo "<script language='javascript' type='text/javascript'>
                alert('Atualizado com sucesso!');window.location;history.go(-1);</script>";
                }
            }
        }
    }

    // CABO QD
    if ($_POST['qdu_serial'] != $result['qdu_serial']) {
        $newqd = mysqli_fetch_assoc(select('select id from archerx.qdu where qdu_serial="' . $_POST['qdu_serial'] . '"'));
        if ($newqd == "") {
            echo "<script language='javascript' type='text/javascript'>
        alert('QDU não localizado tente novamente!');window.location;history.go(-1);</script>";
        } else {
            $count_QD = mysqli_fetch_row(select('select count(*) from archerx.acs_uni where id_qdu="' . $_POST['qdu_serial'] . '"'));
            if ($count_QD[0] >= 1) {
                echo "<script language='javascript' type='text/javascript'>
            alert('Cabo QD alocado em outra baia!');window.location;history.go(-1);</script>";
            } else {
                $query_update_qd = 'UPDATE archerx.acs_uni SET id_qdu = (SELECT id FROM qdu WHERE qdu_serial =\'' . $_POST['qdu_serial'] . '\') WHERE id_baia =\'' . $result['id'] . '\'';
                if (update($query_update_qd) == 'sucesso') {
                    echo "<script language='javascript' type='text/javascript'>
                alert('Atualizado com sucesso!');window.location;history.go(-1);</script>";
                }
            }
        }
    }

    if ($_POST['setor'] == $result['setor'] and $_POST['serial'] == $result['serial'] and $_POST['serie'] == $result['serie'] and $_POST['qdu_serial'] == $result['qdu_serial']) {
        echo "<script language='javascript' type='text/javascript'>
    alert('Não há dados para alterar');window.location;history.go(-1);</script>";
    }

    die();
}
if (isset($_POST['atualizar_rede'])) {
    echo 'entrou' . '<br>';

    $sql = "SELECT  baia.baia,  
                    pach_panel,
                    switch_host,
                    switch_ip,
                    switch_porta
            FROM archerx.mapa_rede_caixa
            INNER JOIN archerx.baia ON baia.id = archerx.mapa_rede_caixa.id_baia
            WHERE baia.baia = '".$_POST['baia']."'";

    $result = mysqli_fetch_assoc(select($sql));


    // PATCH PANEL
    if ($_POST['pach_panel'] != $result['pach_panel']) {

        $count_patch = mysqli_fetch_row(select('select count(*) from archerx.mapa_rede_caixa where pach_panel="' . $_POST['pach_panel'] . '"'));
        if ($count_patch[0] >= 1) {
            echo "<script language='javascript' type='text/javascript'>
        alert('Patch panel alocado em outra baia!');window.location;history.go(-1);</script>";

        } else {

            $query_update_patch = 'UPDATE archerx.mapa_rede_caixa SET pach_panel = "'.$_POST['pach_panel'].'" WHERE id_baia = (SELECT id FROM archerx.baia WHERE baia = "'.$_POST['baia'].'")';
            if (update($query_update_patch) == 'sucesso') {
                echo "<script language='javascript' type='text/javascript'>
            alert('Atualizado com sucesso!');window.location;history.go(-1);</script>";

            }
        }
    }
    
    // HOST
    if ($_POST['switch_host'] != $result['switch_host']) {
        $query_update_host = 'UPDATE archerx.mapa_rede_caixa SET switch_host = "'.$_POST['switch_host'].'" WHERE id_baia = (SELECT id FROM archerx.baia WHERE baia = "'.$_POST['baia'].'")';
        if (update($query_update_host) == 'sucesso') {
            echo "<script language='javascript' type='text/javascript'>
        alert('Atualizado com sucesso!');window.location;history.go(-1);</script>";
        }
    }
    
    // IP
    if ($_POST['switch_ip'] != $result['switch_ip']) {
        $query_update_ip = 'UPDATE archerx.mapa_rede_caixa SET switch_ip = "'.$_POST['switch_ip'].'" WHERE id_baia = (SELECT id FROM archerx.baia WHERE baia = "'.$_POST['baia'].'")';
        if (update($query_update_ip) == 'sucesso') {
            echo "<script language='javascript' type='text/javascript'>
        alert('Atualizado com sucesso!');window.location;history.go(-1);</script>";
        }
    }
    
    // PORTA
    if ($_POST['switch_porta'] != $result['switch_porta']) {

        //if ($_POST['switch_host'] != ''){
            //$count_porta = mysqli_fetch_row(select('select count(*) from archerx.mapa_rede_caixa where switch_host ="'.$_POST['switch_host'].'" AND switch_porta="' . $_POST['switch_porta'] . '"'));
            //if ($count_porta[0] >= 1) {
            //    echo "<script language='javascript' type='text/javascript'>
            //alert('Porta em uso!');window.location;history.go(-1);</script>";
           //} else {
                $query_update_porta = 'UPDATE archerx.mapa_rede_caixa SET switch_porta = "'.$_POST['switch_porta'].'" WHERE id_baia = (SELECT id FROM archerx.baia WHERE baia = "'.$_POST['baia'].'")';
                if (update($query_update_porta) == 'sucesso') {
                    echo "<script language='javascript' type='text/javascript'>
                alert('Atualizado com sucesso!');window.location;history.go(-1);</script>";
                }
            //}
        //} else {
            //$count_porta = mysqli_fetch_row(select('select count(*) from archerx.mapa_rede_caixa where switch_ip ="'.$_POST['switch_ip'].'" AND switch_porta="' . $_POST['switch_porta'] . '"'));
            //if ($count_porta[0] >= 1) {
            //    echo "<script language='javascript' type='text/javascript'>
            //alert('Porta em uso!');window.location;history.go(-1);</script>";
            //} else {
               // $query_update_porta = 'UPDATE archerx.mapa_rede_caixa SET switch_porta = "'.$_POST['switch_porta'].'" WHERE id_baia = (SELECT id FROM archerx.baia WHERE baia = "'.$_POST['baia'].'")';
                //if (update($query_update_porta) == 'sucesso') {
                //    echo "<script language='javascript' type='text/javascript'>
                //alert('Atualizado com sucesso!');window.location;history.go(-1);</script>";
                //}
            //}  
        //}     
    }

    if (
        $_POST['pach_panel'] == $result['pach_panel'] 
        and $_POST['switch_host'] == $result['switch_host'] 
        and $_POST['switch_ip'] == $result['switch_ip'] 
        and $_POST['switch_porta'] == $result['switch_porta']
    ){
        echo "<script language='javascript' type='text/javascript'>
    alert('Não há dados para alterar');window.location;history.go(-1);</script>";
    }

    die();
}


