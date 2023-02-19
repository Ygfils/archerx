<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="/documents/scripts/archerx/css/header-style.css">
  <link rel="stylesheet" type="text/css" href="/documents/scripts/archerx/css/atualizar_rede-style.css">
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
    <form action="/documents/scripts/archerx/public/atualizar_rede.php" method="GET">
      <select name="tipos" id="tipos" class="drop_down">
          <option value="baia">BAIA</option>
          <option value="pach_panel">PATCH PANEL</option> 
          <option value="switch_host">HOST NAME</option>
          <option value="switch_ip">IP</option>
          <option value="switch_porta">PORTA</option>
        </select>
      <input type="text" name="busca" size="20" id="campo_baia" class="search_bar">
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

        $sql = "SELECT  baia.baia,
                        pach_panel,
                        switch_host,
                        switch_ip,
                        switch_porta
                FROM archerx.mapa_rede_caixa
                INNER JOIN archerx.baia ON baia.id = archerx.mapa_rede_caixa.id_baia";

      if ($_GET['busca']=="" and isset($_GET['tipos'])){
        echo "<h3>Insira um termo de busca!</h3>";
        die();
      }
      if ($_GET['busca']){
        switch ($_GET['tipos']) {
          case 'baia':
            $sql .=" WHERE baia.baia ='".$_GET['busca']."';";
            #echo $sql;
            break;
          case 'pach_panel':
            $sql .=" WHERE pach_panel ='".$_GET['busca']."'";
            #echo $sql;
            break;
          case 'switch_host':
            $sql .=" WHERE switch_host LIKE '%".$_GET['busca']."%'";
            #echo $sql;
            break;
          case 'switch_ip':
            $sql .=" WHERE switch_ip LIKE '%".$_GET['busca']."%'";
            #echo $sql;
            break;
          case 'switch_porta':
            $sql .=" WHERE switch_porta = '".$_GET['busca']."'";
            #echo $sql;
            break;     
        }
      }else{
        die();
      }

      $result = $conn->query($sql);

      $data = $result->fetch_assoc();

      // Free result set

      // montagem do html da tabela
      $table  = '<table>';
      $table .= '<thead>';
      $table .= '<tr>';
      $table .= '<td><span style="font-weight:bold;">BAIA</span></td>';
      $table .= '<td><span style="font-weight:bold;">PATCH PANEL</span></td>';
      $table .= '<td><span style="font-weight:bold;">HOST DO SWITCH</span></td>';
      $table .= '<td><span style="font-weight:bold;">IP DO SWITCH</span></td>';
      $table .= '<td><span style="font-weight:bold;">PORTA DO SWITCH</span></td>';
      $table .= '</tr>';
      $table .= '</thead>';
      $table .= '<tbody>';

      // laço de repetição para inclusão dos dados na tabela
      foreach ($result as $row) {
        $table .= '<form method="POST" action="updater.php" id="form_atualizar">';
        $table .= "<tr>";
        $table .= '<td><input type="text" name="baia"  readonly="" value="'.$row['baia'].'" placeholder=""></td>';
        $table .= '<td><input type="text" name="pach_panel" value="'.$row['pach_panel'].'" placeholder=""></td>';
        $table .= '<td><input type="text" name="switch_host" value="'.$row['switch_host'].'" placeholder=""></td>';
        $table .= '<td><input type="text" name="switch_ip" value="'.$row['switch_ip'].'" placeholder=""></td>';        
        $table .= '<td><input type="text" name="switch_porta" value="'.$row['switch_porta'].'" placeholder=""></td>';
        $table .= '<td><input type="submit" name="atualizar_rede" value="atualizar"></td>';
        $table .= '</tr>';
      }

      // fecahamento do html
      $table .= '</tbody>';
      $table .= '</table>';
      $table .= '</form>';
      
      // exibição na tela
      echo $table;
      $conn->close();
      echo "<script>console.log($table)</script>";
    } else {
      header("Location:/documents/scripts/archerx/public/login.php");
    }
  }
    ?>
  </div>
</body>

</html>