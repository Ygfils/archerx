<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="/documents/scripts/archerx/css/header-style.css">
  <link rel="stylesheet" type="text/css" href="/documents/scripts/archerx/css/cadastro-style.css">
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
              <form action="/documents/scripts/archerx/public/cadastro.php" method="GET">
                  SELECIONE A CATEGORIA:
                <select onchange="submit();" name="tipos" id="tipos" class="drop_down" width="200" style="width: 200px">
                  <option value="SELECIONE">SELECIONE</option>
                  <option value="ET/SÉRIE">ET/SÉRIE</option>
                  <option value="QDU">QDU</option>        
                  <option value="MONITOR">Monitor</option>
                </select>
                <br>
              </form>
            </div>
              <div class="container">
                <?php
                  switch ($_GET['tipos']) {
                      case 'ET/SÉRIE':
                          $campo = '<form action="/documents/scripts/archerx/public/inserter.php" method="POST">
                                      <label for="et">ESTAÇÃO DE TRABALHO:</label>
                                      <input type="entry" class="host" id="et" name="et" />
                                      <p><label for="serie">NÚMERO DE SÉRIE:</label>
                                      <input type="entry" class="serie" id="serie" name="serie" /></p>
                                      <p><input type="submit" value="Cadastrar" /></p> 
                                    </form>';
                          break;
                      case 'MONITOR':
                          $campo = '<form action="/documents/scripts/archerx/public/inserter.php" method="POST">
                                      <label for="monitor">MONITOR:</label>
                                      <input type="entry" class="monitor" id="monitor" name="monitor" />
                                      <p><input type="submit" value="Cadastrar" /></p> 
                                    </form>';
                          break;
                      case 'QDU':
                          $campo = '<form action="/documents/scripts/archerx/public/inserter.php" method="POST">
                                      <label for="qd">CABO QD:</label>
                                      <input type="entry" class="qd" id="qd" name="qd" />
                                      <p><input type="submit" value="Cadastrar" /></p> 
                                    </form>';
                          break;
                  }
                  print $campo
                ?>
              </div>
    <div class="footer" ></div>
  </body>
</html>