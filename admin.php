<?php
//está é a pagina principal do site onde as demais paginas serão carregadas conforme a utilização
include('session.php');
header('Content-Type: text/html; charset=UTF-8');
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>SenaQuiz</title>
		<link rel="stylesheet" type="text/css" href="assets/css/login.css" />
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://code.jquery.com/jquery-2.2.3.min.js" type="text/javascript"></script>
	
	</head>
	<body>
    <script src="assets/js/jquery.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
		<div class="container interna">

		<nav id="menuCrud">	<!--menu principal que ira passar os parametros na url-->
			<a href="?page=form">Cadastrar Nova Questão</a>			
			<a href="?page=grid">Ver tabela de Questões</a>	
			<a href="index.php?logout=1">Sair</a>
		</nav>
		
		<?php
			if (isset($_SESSION['showMenu']) && $_SESSION['showMenu']) {
		?>
			

			<?php
    
			    include('conexao.php');// inclusão da pagina de conexão com o banco de dados
			    
			    $query = "SELECT * FROM questao LEFT JOIN imagem ON (questao.codImagem = imagem.codImagem)";// Query de consulta do banco de dados
			    
			    $consulta  = odbc_exec($connect, $query);//função de conexão com o banco de dados utilizando a query
			    $resultado = odbc_num_rows($consulta);// resultado da consulta
			    
			    if ($resultado > 0) { //se a consulta no banco de dados retornar algum resultado o sistema ira dar continuidade no processo
			        if (isset($_GET['page']) && $_GET['page'] == "grid") {
			            include('grid.php');
			            //se na url for passado o parametro grid a pagina com a tabela de questões será incluida
			        } else if (isset($_GET['page']) && $_GET['page'] == "form") {
			            include('nova-edita.php');
			            //se na url for passado o parametro form a pagina de criação/edição será incluida
			        } else if (isset($_GET['page']) && $_GET['page'] == "deleta") {
			            include('deleta.php');
			            //se na url for passado o parametro deleta a questão selecionada será excluída utilizando a pagina de delete
			        } else if (isset($_GET['page']) && $_GET['page'] == "salva-form") {
			            include('salva-form.php');
			            //se na url for passado o parametro salva-fornm a questão em criação/edição será salva através da pagina salva-form 
			        } else {
			            include('grid.php');
			            //pagina default caso nenhum paramentro sera passado na url
			        }
			    } else {
			        echo "Sem resultados.";
			        //aviso de erro caso a consulta no banco não retorne nenhum resultado
			    }
			?>

		<?php
			}
		?>		

		</div>		
	</body>
</html>