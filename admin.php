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
				<a href="javascript:void(0)">Crud A</a>
				<a href="javascript:void(0)">Crud B</a>
				<a href="javascript:void(0)">Crud C</a>
				<a href="index.php?logout=1">Sair</a>
			</nav>
			<?php
				echo "nomeProfessor ".$_SESSION['nomeProfessor'].'<br/>';
				echo "showMenu ".$_SESSION['showMenu'].'<br/>';
				echo "codProfessor ".$_SESSION['codProfessor'].'<br/>';
				echo "tipoProfessor ".$_SESSION['tipoProfessor'].'<br/>';
				echo "msgError ".$_SESSION['msgError'].'<br/>';
			?>
			<?php	
			}
		?>
		</div>		
	</body>
</html>