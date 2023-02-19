<!DOCTYPE html>
  <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="refresh" content="180" />
        <link rel="stylesheet" type="text/css" href="/documents/scripts/archerx/css/header-style.css">
        <link rel="stylesheet" href="/documents/scripts/archerx/css/dashboard-style.css">
        <title>Archerx integration</title>
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
        <div class="containerdash">
          <h2 class="titulo">OCUPAÇÃO DE RAMAIS ELEV</h2>
            <div class="dados" >
            <?php
            include('conexao.php');
            $qRamaisDisponiveis = "SELECT count(*) as disponiveis FROM archerx.integration where status = 0";
            $result = $conn->query($qRamaisDisponiveis);
            $ramaisDisponiveis = $result->fetch_assoc();
            echo "Ramais Disponíveis: " . $ramaisDisponiveis["disponiveis"] . "<br>";

            $qRamaisOcupados = "SELECT count(*) as ocupados FROM archerx.integration where status = 1";
            $result = $conn->query($qRamaisOcupados);
            $RamaisOcupados = $result->fetch_assoc();
            echo "Ramais Ocupados: " . $RamaisOcupados["ocupados"]. "<br>";

            $RamaisTotal= $ramaisDisponiveis["disponiveis"]+$RamaisOcupados["ocupados"];
            $PercentualOcupado = $RamaisOcupados["ocupados"]/$RamaisTotal*100;
            echo "Total de Ramais: ".$RamaisTotal."<br>";

            echo "<p><label for=\"ramais\">Ocupação: ".number_format($PercentualOcupado, 1)."%</label><br>";
            echo "<progress id=\"ramais\" value=\"".$RamaisOcupados["ocupados"]."\" max=\"".$RamaisTotal."\"> ".$PercentualOcupado."% </progress></p>";
            ?>
            </div>
            <?php
            setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' ); 
            date_default_timezone_set( 'America/Sao_Paulo' );
            echo "<h4 class='tempo'>Última atualização: ".strftime( '%Y-%m-%e %T', strtotime('now'))."</h4>";
            ?>
        </div>
      <div class="footer" ></div>
  </body>
</html>