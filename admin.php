<?php
include('session.php');
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Logado</title>
		<link rel="stylesheet" type="text/css" href="assets/css/login.css" />
	</head>
	<body>
		<div class="container">
		<?php
		if(isset($_SESSION['showMenu']) && $_SESSION['showMenu']) {
			?>
			<nav id="menuCrud">	
				<a href="#">Cadastrar Nova Questão</a>			
				<a href="#">Ver tabela de Questões</a>			
				<a href="index.php?logout=1">Sair</a>
			</nav>

			<?php

			include('conexao.php');

			$query = 
					"SELECT
						*
					FROM
						questao";

			$consulta = odbc_exec($connect,$query);
			$resultado = odbc_num_rows($consulta);	

			if( $resultado > 0 ){
				$resultado = odbc_fetch_array($consulta);
				include('grid.php');
				include('nova-edita.php');
			}
			else {
				echo "Sem resultados.";
			}
			?>

			<!-- <?php
				// echo "nomeProfessor ".$_SESSION['nomeProfessor'].'<br/>';
				// echo "showMenu ".$_SESSION['showMenu'].'<br/>';
				// echo "codProfessor ".$_SESSION['codProfessor'].'<br/>';
				// echo "tipoProfessor ".$_SESSION['tipoProfessor'].'<br/>';
				// echo "msgError ".$_SESSION['msgError'].'<br/>';
			?> -->
			<?php	
			}
		?>
		</div>		
	</body>
</html>