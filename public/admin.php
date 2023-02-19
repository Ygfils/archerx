<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="/documents/scripts/archerx/css/header-style.css">
  <link rel="stylesheet" type="text/css" href="/documents/scripts/archerx/css/admin-style.css">
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
  <div class=container>
    <?php
    include('conexao.php');
    if(isset($_COOKIE['admin'])) {

      $sql = "SELECT idusuarios,admin, nome, login from archerx.usuarios";

      $result = $conn->query($sql);

      $data = $result->fetch_assoc();

      // Free result set

      // montagem do html da tabela
      $table  = '<table>';
      $table .= '<thead>';
      $table .= '<tr>';
      $table .= '<td><span style="font-weight:bold;">ID</span></td>';
      $table .= '<td><span style="font-weight:bold;">Nome</span></td>';
      $table .= '<td><span style="font-weight:bold;">Usuario</span></td>';
      $table .= '<td><span style="font-weight:bold;">Senha</span></td>';
      $table .= '<td><span style="font-weight:bold;">Atualizar</span></td>';
      $table .= '<td><span style="font-weight:bold;">Remover</span></td>';
      $table .= '</tr>';
      $table .= '</thead>';
      $table .= '<tbody>';



      // laço de repetição para inclusão dos dados na tabela
      foreach ($result as $row) {
        $table .= '<form method="POST" action="updater.php" id="form_admin">';
        $table .= "<tr>";
        $table .= '<td>'.$row['idusuarios'].'</td>';
        $table .= '<td><input type="text" name="nome"  readonly="" value="' . $row['nome'] . '" placeholder=""></td>';
        $table .= '<td><input type="text" name="usuario" value="' . $row['login'] . '" placeholder=""></td>';
        $table .= '<td><input type="password" name="senha" value="" placeholder="********"></td>';
        $table .= '<td><input type="submit" name="atualizar_admin" value="Atualizar"></td>';
        $table .= '<td><input type="submit" name="deletar" value="Remover"></td>';
        $table .= '</tr>';
      }
      $table .= '<form method="POST" action="updater.php" id="form_admin">';
      $table .= "<tr>";
      $table .= '<td></td>';
      $table .= '<td><input type="text" name="nome"  readonly="" value="" placeholder=""></td>';
      $table .= '<td><input type="text" name="usuario" value="" placeholder=""></td>';
      $table .= '<td><input type="password" name="senha" value="" placeholder="********"></td>';
      $table .= '<td><input type="submit" name="criar_admin" value="Adicionar"></td>';
      $table .= '<td><input type="submit" name="deletar" disabled="yes" value="Remover"></td>';
      $table .= '</tr>';

      // fecahamento do html
      $table .= '</tbody>';
      $table .= '</table>';
      $table .= '</form>';

      // exibição na tela
      echo $table;
      $conn->close();
    } 
    
    else {
      echo "<script language='javascript' type='text/javascript'>
                alert('Você não é admin!');window.location;history.go(-1);</script>";
      die();
    }
    ?>
  </div>
  <div class="footer" ></div>
</body>

</html>