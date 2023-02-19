<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="/documents/scripts/archerx/css/header-style.css">
  <link rel="stylesheet" type="text/css" href="/documents/scripts/archerx/css/atualizar-style.css">
  <title>Atualizar</title>
</head>

<body>
<div class="navbar">
            <?php if(isset($_COOKIE['admin'])){ 
            echo(
              '<div class="dropdown">
              <button class="dropbtn">GERÊNCIA
                <i class="fa fa-caret-down"></i>
              </button>
              <div class="dropdown-content">
                <a href="/documents/scripts/archerx/public/funcionarios.php">FUNCIONÁRIOS</a>
                <a href="#">HEADSETS</a>
                <a href="#">DASHBOARD</a>
                <a href="/documents/scripts/archerx/public/wyntech/login.html">ÁREA WYNTECH</a>
                <a href="/documents/scripts/archerx/public/mapaderede.php">MAPA DE REDE</a>
              </div>
              </div>'
            );
            }
            ?>
            <?php if(isset($_COOKIE['admin'])){ 
            echo(
              '<div class="dropdown">
              <button class="dropbtn">ATUALIZAR
                <i class="fa fa-caret-down"></i>
              </button>
              <div class="dropdown-content-atualizar">
                <a href="/documents/scripts/archerx/public/atualizar_gps.php">GPS</a>
                <a href="/documents/scripts/archerx/public/atualizar_rede.php">REDE</a>
              </div>
              </div>'
            );
            }
            ?>
            <?php if(isset($_COOKIE['admin'])){ 
            echo(
                '<a href="/documents/scripts/archerx/public/cadastro.php">CADASTRO</a>           
                <a href="/documents/scripts/archerx/public/admin.php">ADMIN</a>'
            );
            }
            ?>
            <a href="/documents/scripts/archerx/public/relatorio.php">RELATORIO</a>
            <a href="/documents/scripts/archerx/public/dashboard/index.php">DASHBOARD ELEV</a>
            <a href="/documents/scripts/archerx/public/logoff.php">LOGOFF</a>
        </div>
  <div class="finder">
    <form action="/documents/scripts/archerx/public/atualizar_gps.php" method="GET">
      <select name="tipos" id="tipos" class="drop_down">
        <option value="baia">Baia</option>
        <option value="ramal_dg">Ramal Dg</option>
        <option value="ns_host">NS Host</option>
        <option value="et_host">ET host</option>
        <option value="qdu">QDU</option>        
        <option value="moniotr">Monitor</option>
        <option value="setor">Setor</option>
      </select>
      <input type="text" name="busca" size="50" class="search_bar">
      <button style="width:100px;" id='buscar' class="search_bar">Buscar</button>
    </form>
  </div>
  <div class="footer" ></div>
  <br><br>
  <div class=container>
    <?php
    include('conexao.php');
    $login_cookie = $_COOKIE['login'];
    if (isset($login_cookie)) {
      if (isset($_GET)) {

        $sql = "SELECT B.baia, C.serial, C.hostname, D.qdu_serial, E.ramal, F.ramal as ramal_dg, G.serie, H.setor
        FROM archerx.acs_uni as A
        LEFT JOIN archerx.baia as B
        ON A.id_baia = B.id 
        LEFT JOIN archerx.hosts as C
        ON A.id_hostname = C.id
        LEFT JOIN archerx.qdu as D
        ON A.id_qdu = D.id
        LEFT JOIN archerx.ramal as E
        ON A.id_ramal = E.id
        LEFT JOIN archerx.ramal_baia as F
        ON A.id_ramal_baia = F.id
        LEFT JOIN archerx.monitores as G
        ON A.id_monitores = G.id
        LEFT JOIN archerx.setor as H
        ON A.id_setor = H.id ";

        if ($_GET['busca']=="" and isset($_GET['tipos'])){
          echo "<h3>Insira um termo de busca!</h3>";
          die();
        }
        if ($_GET['busca']){
          switch ($_GET['tipos']) {
            case 'baia':
              $sql .="where B.baia='".$_GET['busca']."'";
              #echo $sql;
              break;
            case 'ns_host':
              $sql .="where C.serial='".$_GET['busca']."'";
              #echo $sql;
              break;
            case 'et_host':
              $sql .="where C.hostname LIKE '%".$_GET['busca']."%'";
              #echo $sql;
              break;
            case 'qdu':
              $sql .="where D.serial='".$_GET['busca']."'";
              #echo $sql;
              break;
            case 'ramal_dg':
              $sql .="where F.ramal='".$_GET['busca']."'";
              #echo $sql;
              break;
            case 'monitor':
              $sql .="where G.serie='".$_GET['busca']."'";
              #echo $sql;
              break;
            case 'setor':
              $sql .="where H.setor LIKE'".$_GET['busca']."'";
              #echo $sql;
              break;
          }
        }else{
          die();
        }
      }
    
      $result = $conn->query($sql);

      $data = $result->fetch_assoc();

      // Free result set

      // montagem do html da tabela
      $table  = '<table>';
      $table .= '<thead>';
      $table .= '<tr>';
      $table .= '<td><span style="font-weight:bold;">Baia</span></td>';
      $table .= '<td><span style="font-weight:bold;">Setor</span></td>';
      $table .= '<td><span style="font-weight:bold;">Ramal Dg</span></td>';
      $table .= '<td><span style="font-weight:bold;">Hostname</span></td>';
      $table .= '<td><span style="font-weight:bold;">Serial</span></td>';
      $table .= '<td><span style="font-weight:bold;">Monitor</span></td>';
      $table .= '<td><span style="font-weight:bold;">QDU</span></td>';
      $table .= '</tr>';
      $table .= '</thead>';
      $table .= '<tbody>';

      // laço de repetição para inclusão dos dados na tabela
      foreach ($result as $row) {
        $table .= '<form method="POST" action="updater.php" id="form_atualizar">';
        $table .= "<tr>";
        $table .= '<td><input type="text" name="baia"  readonly="" value="'.$row['baia'].'" placeholder=""></td>';
        $table .= '<td><select name="setor">;<option selected '.$row['setor'].'>'.$row['setor'].'</option>;
                                              <option value="VAZIO">VAZIO</option>;
                                              <option value="OPERAÇÃO">OPERAÇÃO</option>;
                                              <option value="SUPERVISÃO">SUPERVISÃO</option>;
                                              <option value="WYNTECH">WYNTECH</option>;
                                              <option value="SUPORTE DE TI">SUPORTE DE TI</option>;
                                              <option value="SESMT">SESMT </option>;
                                              <option value="RECURSOS HUMANOS">RECURSOS HUMANOS</option>;
                                              <option value="TREINAMENTO">TREINAMENTO</option>;
                                              <option value="GERÊNCIA">GERÊNCIA </option>;
                                              <option value="CÉLULA BABY">CÉLULA BABY</option>;
                                              <option value="DESENVOLVIMENTO">DESENVOLVIMENTO</option>;
                                              <option value="COORDENAÇÃO">COORDENAÇÃO</option>;
                                              <option value="TRÁFEGO">TRÁFEGO</option>;
                                              <option value="MONITORIA">MONITORIA</option>;
                                              <option value="RETAGUARDA">RETAGUARDA</option>;
                                              <option value="DATA CENTER">DATA CENTER</option>;
                                              <option value="SALA CAIXA">SALA CAIXA</option></select></td>';
        $table .= '<td><input type="text" name="ramal_dg" value="'.$row['ramal_dg'].'" placeholder=""></td>';
        $table .= '<td><input type="text" name="hostname" readonly="" value="'.$row['hostname'].'" placeholder=""></td>';
        $table .= '<td><input type="text" name="serial" value="'.$row['serial'].'" placeholder=""></td>';        
        $table .= '<td><input type="text" name="serie" value="'.$row['serie'].'" placeholder=""></td>';
        $table .= '<td><input type="text" name="qdu_serial" value="'.$row['qdu_serial'].'" placeholder=""></td>';
        $table .= '<td><input type="submit" name="atualizar" value="atualizar"></td>';
        $table .= '</tr>';
      }

      // fecahamento do html
      $table .= '</tbody>';
      $table .= '</table>';
      $table .= '</form>';
      
      // exibição na tela
      echo $table;
      $conn->close();
    } else {
      header("Location:/archerx/public/login.php");
    }

    ?>
  </div>
</body>

</html>