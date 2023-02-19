<!DOCTYPE html>
  <html lang="pt-BR">
    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" type="text/css" href="/documents/scripts/archerx/css/header-style.css">
      <link rel="stylesheet" href="/documents/scripts/archerx/css/relatorio-style.css">
      <title>Relatorio</title>
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
          <script>
                $(".drop")
              .mouseover(function() {
              $(".dropdown").show(300);
            });
            $(".drop")
              .mouseleave(function() {
              $(".dropdown").hide(300);     
            });
          </script>
          <div class="container">
            <p>
            <?php

              include('conexao.php');
              $login_cookie = $_COOKIE['login'];
              if(isset($login_cookie)){
                  

              $sql = "  SELECT  baia.baia,
                                pach_panel,
                                switch_host,
                                switch_ip,
                                switch_porta
                        FROM archerx.mapa_rede_caixa
                        INNER JOIN archerx.baia ON baia.id = archerx.mapa_rede_caixa.id_baia;";

              $result = $conn->query($sql);

              $data = $result->fetch_assoc();

              // montagem do html da tabela
              $table  = '<table>';
              $table .= '<thead>';
              $table .= '<tr>';
              $table .= '<td><span style="font-weight:bold;">Baia</span></td>';
              $table .= '<td><span style="font-weight:bold;">PACH PANEL</span></td>';
              $table .= '<td><span style="font-weight:bold;">HOST DO SWITCH</span></td>';
              $table .= '<td><span style="font-weight:bold;">IP DO SWITCH</span></td>';
              $table .= '<td><span style="font-weight:bold;">PORTA DO SWITCH</span></td>';
              $table .= '</tr>';
              $table .= '</thead>';
              $table .= '<tbody>';

              // laço de repetição para inclusão dos dados na tabela
              // Segue a sequancia do select
              foreach($result as $row){
                  $table .= '<tr>';
                      $table .= "<td>{$row["baia"]}</td>";
                      $table .= "<td>{$row["pach_panel"]}</td>";
                      $table .= "<td>{$row["switch_host"]}</td>";
                      $table .= "<td>{$row["switch_ip"]}</td>";
                      $table .= "<td>{$row["switch_porta"]}</td>";      
                  $table .= '</tr>';
              }

              // fecahamento do html
              $table .= '</tbody>';
              $table .= '</table>';



              // exibição na tela
              echo $table;


              $conn->close(); 
              }else{
                  header("Location:/archerx/public/login.php");
              }
              ?>
            </p>   
          </div>
        <div class="footer" ></div>
    </body>
  </html>