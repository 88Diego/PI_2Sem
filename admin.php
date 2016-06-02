<?php
include('session.php');
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Logado</title>
		<link rel="stylesheet" type="text/css" href="assets/css/login.css" />
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://code.jquery.com/jquery-2.2.3.min.js" type="text/javascript"></script>
	
	</head>
	<body>
    <script src="assets/js/jquery.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
		<div class="container interna">

		<?php
		if(isset($_SESSION['showMenu']) && $_SESSION['showMenu']) {
			?>
			<nav id="menuCrud">	
				<a href="?page=form">Cadastrar Nova Questão</a>			
				<a href="?page=grid">Ver tabela de Questões</a>	
				<a href="index.php?logout=1">Sair</a>
			</nav>

			<?php

				include('conexao.php');

				$query = 
						"SELECT * FROM questao LEFT JOIN imagem ON (questao.codImagem = imagem.codImagem)";

				$consulta = odbc_exec($connect,$query);
				$resultado = odbc_num_rows($consulta);	

				if( $resultado > 0 ){
					if (isset($_GET['page']) && $_GET['page'] == "grid") {
						include('grid.php');
					} else if (isset($_GET['page']) && $_GET['page'] == "form") {
						include('nova-edita.php');
					} else if (isset($_GET['page']) && $_GET['page']== "deleta") {
						include('deleta.php');
					} else{
						include('grid.php');
					}				
				}
				else {
					echo "Sem resultados.";
				}
			?>

			<?php	
			}
		?>		

		</div>		
	</body>
</html>