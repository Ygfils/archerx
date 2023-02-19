<!DOCTYPE html>
  <html lang="pt-BR">
   <head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="/documents/scripts/archerx/css/header-style.css"/>
    <link rel="stylesheet" type="text/css" href="/documents/scripts/archerx/css/funcionarios-style.css"/>
    <script  type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>  
    <title>FUNCIONÁRIOS</title>
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
      <div class="pai">
        <form class="funcionario" id="funcionario" method="POST">
          <h3>FUNCIONÁRIO</h3>
            <br>
              <label class="label_funcionario" for="matricula">Matricula:</label>
              <input type="entry" onkeyup="buscar_usuario(document.getElementById('matricula').value)" class="campo_matricula" name="matricula" id="matricula"/>

              <input type="button" onclick="buscar_usuario(document.getElementById('matricula').value)" value="Buscar"/>

              <p><label class="label_funcionario" for="nome">Nome:</label>
              <input type="entry" class="campo_grande_nome" name="nome" id="nome"/></p>

              <p><label class="label_funcionario" for="setor">Setor:</label>
              <input type="entry" class="campo_grande_setor" name="setor" id="setor" /></p>
              
              <p><label class="label_funcionario" for="cartao">Cartao:</label>
              <input type="entry" class="campo_pequeno_cartao" name="cartao" id="cartao" /></p>

              <p><label class="label_funcionario" for="pis">Pis:</label>
              <input type="entry" class="campo_pequeno_pis" name="pis" id="pis" /></p>
          
              <p><label class="label_funcionario" for="situacao">Situação:</label>
              <input type="entry" class="campo_pequeno_situacao" name="situacao" id="situacao" /></p>

              <p><label class="label_funcionario" for="demissao">Demissão:</label>
              <input type="entry" class="campo_pequeno_demissao" name="demissao" id="demissao" /></p>
        </form>          
          <form class="cartoes" method="POST" action="" id="entrar">
              <h3>CARTÕES</h3>
              <label class="label_cartoes" for="cartao_provisorio">Cartão:</label>
              <input type="entry" class="campo_cartoes" name="cartao_provisorio" id="cartao_provisorio"/>
              <br><br>
              <label ><h2>* Para associar, insira os 5 dígitos do cartão e selecione o período</h2></label>
              <br>
              <label class="label_cartoes" for="data_inicial">Inicio:</label>
                  <input class="campo_inicio" type="date" name="data_inicial" id="data_inicial"/>
              <label class="label_cartoes" for="data_final">Fim:</label>
                  <input class="campo_fim" type="date" name="data_final" id="data_final"/> 
              
              <input type="button" class="botao_associar" name="associar" id="associar" value="Associar"/>
              <input type="button" class="botao_desassociar" name="desassociar" id="desassociar" value="Dessassociar"/>
          </form>
            <form class="cadastro" method="POST" action="" id="entrar">
                <h3>CADASTRO</h3>
                <br>
                <input type="button" name="atualizar_funcionario" id="atualizar_funcionario" value="Atualizar"/>
                <input type="button" name="cadastrar_funcionario" id="cadastrar_funcionario" value="Cadastrar"/>
                <input type="button" name="baixa_funcionario" id="baixa_funcionario" value="Baixa"/>
            </form>
              <form class="exclusao" method="POST" action="" id="entrar">
                <h3>EXCLUSÃO</h3>
                <br>
                <input type="button" name="catraca" value="Catraca"/>
                <input type="button" name="ponto" value="Ponto"/>
                <input type="button" name="porta" value="Porta"/>
              </form>
                <form class="bloqueio" method="POST" action="" id="entrar">
                  <h3>ENTRADA NA EMPRESA</h3>
                  <label class="label_bloqueio" for="situacao_bloqueio">Situação:</label>
                  <input type="text" readonly='' class="campo_bloqueio" name="situacao_bloqueio" id="situacao_bloqueio"/>
                  <br><br>
                  <label ><h2>* Para bloquear, selecione o período.</h2></label>
                  <br>
                  <label class="label_bloqueio" for="data_inicial_bloqueio">Inicio:</label>
                      <input class="campo_inicio" type="date" name="data_inicial" id="data_inicial_bloqueio"/>
                  <label class="label_bloqueio" for="data_final_bloqueio">Fim:</label>
                      <input class="campo_fim" type="date" name="data_final" id="data_final_bloqueio"/> 
                  
                  <input type="button" class="botao_bloquear" name="bloquear" id="bloquear" value="Bloquear"/>
                  <input type="button" class="botao_desbloquear" name="desbloquear" id="desbloquear" value="Desbloquear"/>
                </form>
                  <form class="headset" method="POST" action="" id="entrar">
                    <h3>HEADSET</h3>
                    <br>
                    <label class="label_headset" for="headset_atual">Headset atual:</label>
                    <input type="entry" class="campo_headset" name="headset_aual" id="headset_aual" />

                    <p><label class="label_headset" for="situacao_head">Situação:</label>
                    <input type="entry" class="campo_situacao" name="situacao_head" id="situacao_head" /></p>
                    <br>
                    <h3>ENTREGA/TROCA/BAIXA</h3>
                    <br>
                    <label class="label_headset" for="headset_novo">Headset novo:</label>
                    <input type="entry" class="campo_headset_novo" name="headset_novo" id="headset_novo" />
                    <br>
                    <label class="label_headset" for="headset_novo">Motivo:</label>
                    <select class="campo_motivo" name="opcao" id="opcao" onchange="verifica_selecionado(document.getElementById('opcao').value)">
                        <option value=""></option>
                        <option value="troca">TROCA</option>
                        <option value="integracao">INTEGRAÇÃO</option>
                        <option value="emprestimo">EMPRÉSTIMO</option>
                    </select>
                    <br><br>
                    <label ><h5 class="aviso" >*Para troca Informe o Chamado</h5></label>
                    <label class="label_headset" for="chamado">Chamado:</label>
                    <input type="entry" class="campo_chamado" name="chamado" id="chamado" />
                    <br><br>
                      <label class="checkboxhead">
                        <input type="checkbox" name="desconto" id="desconto" />
                        <span class="checkmark"></span>
                        <label for="desconto"><h5 class="aviso" >* Marque a caixa para realizar o desconto</h5></label>
                      </label>
                    <br><br>
                    <input type="button" class="botaoheadset" name="atualizar_head" id="atualizar_head" value="Atualizar" onclick="atualizar_headset()"/>
                    <input type="button" class="botaoheadset" name="baixa_head" id="baixa_head" value="Baixa headset"/>
                    <input type="button" class="botaoheadset" name="baixa_emprestimo" id="baixa_emprestimo" value="Baixa empréstimo"/>
                    <br>
                  </form>
      </div> 
        <div class="footer" ></div>
    <script src="js/custom.js"></script>
  </body>
</html>