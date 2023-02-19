# archerx
Archerx é um sistema interno criado utilizando PHP HTML CCS e Mysql.

Archer - Interface Web
Versão - 2.3
Data: 19/02/2022
Desenvolvedores:
    - Backend: Mauricio Ferrari
    - Frontend: Cristian Lopes
	  - Backend e Frontend: Daniel Lopes Manfrini 

Changelog
V1.0 = por: Mauricio Ferrari, Cristian Lopes.
	
	Inicial.

V1.1 = 	Por: Daniel Lopes Manfrini.

	Adição das colunas de setor e monitor.
	Alteração do arquivo de atualização "Updater.php":
		Restruturação completa do arquivo, com avisos de dados duplicados e dados inexistentes,
		o arquivo é executado inteiro, diferente de antes, que parava no primeiro erro,
		agora passa por todas as condições antes de finalizar e relata apenas o dado que está incorreto ao operador,
		evitando a reinserção de um dado que não foi processado. 
	População das tabelas com os dados do GPS.

V1.2 = 	Por: Daniel Lopes Manfrini.

	Criado a página de cadastro,
	Criado o arquivo "inserter.php":
		Junto com a página de cadastro realiza no banco de dados o INSERT de novas informações,
		tais como máquinas e equipamentos.

V1.3 = 	Por: Daniel Lopes Manfrini.

	Restruturação da página Dashboard elev.
	Inicio da migração da página de gerencia de funcionarios:
		atualmente é um programa em phyton, a migração deve se a facilidade de acesso.

V1.4 = 	Por: Daniel Lopes Manfrini.

	Alteração completa do HEADER e adição de um FOOTER.
	Alteração completa do login.

V1.5 = 	Por: Daniel Lopes Manfrini.

	Finalizado página de funcionarios.
		A página foi criada usando funções em ".js" para a busca das informações.
	Ficaram duas pendências:
		1ª: criar asa funções de UPDATE e INSERT.
		2º: conseguir estabelecer conexão com o SQLserver no jorginho.
			Os bancos das catracas são em SQl server.

V2.0 = 	Por: Daniel Lopes Manfrini.

	Alteração completa dos arquivos de CSS.
	Alterado cores base.
	Alterado tela de fundo.
	Alterado cores de margens e fontes.

V2.1 = 	Por: Daniel Lopes Manfrini.

	Criado novo menu dropdown GERÊNCIA para o HEADER. 

V2.2 = 	Por: Daniel Lopes Manfrini.

	Criado a página de RELATÓRIO DE REDE dentro do menu dropdown da GERÊNCIA.
	Criado novo menu dropdown dentro de CADASTRO e alterado a página cadastro para a opção GPS.
	Criado nova página GPS e adicionado dentro do menu dropdown CADASTRO.
	Utilizado o arquivo "Updater.php" para realizar o UPDATE das informações.

V2.3 = 	Por: Daniel Lopes Manfrini.

	Criado um link para o site WYNTECH dentro do menu dropdown GERÊNCIA.

PENDÊNCIAS:

	Criação da função de cadastro ADMIN.
	Hospedar a página funcionários em um server com driver MSSQLserver.
	Criação do Dashboard geral assim como no phyton.
	criação do controle de HEADSETS assim como no phyton.
