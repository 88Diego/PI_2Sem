<?php
include('session.php');
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Logado</title>
		<link rel="stylesheet" type="text/css" href="assets/css/login.css" />
        <link href="css/bootstrap.min.css" rel="stylesheet">
		<script src="https://code.jquery.com/jquery-2.2.3.min.js" type="text/javascript"></script>
	
	</head>
	<body>
    <script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
		<div class="container interna">
		<?php
		if(isset($_SESSION['showMenu']) && $_SESSION['showMenu']) {
			?>
			<nav id="menuCrud">	
				<a href="#" data-target="form">Cadastrar Nova Questão</a>			
				<a href="#" data-target="grid">Ver tabela de Questões</a>			
				<a href="index.php?logout=1">Sair</a>
			</nav>

			<?php

			include('conexao.php');

			$query = 
					"SELECT
						*
					FROM
						questao
					LEFT JOIN 
						imagem  
					ON 
						(questao.codImagem = imagem.codImagem)";

			$consulta = odbc_exec($connect,$query);
			$resultado = odbc_num_rows($consulta);	

			if( $resultado > 0 ){						
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
		<!--script type="text/javascript">
		   function qntAlternativas(qnt) {
		        for (var i = 0; i <= qnt - 1; i++) {
		            $('#alternativas').append('<input type="text" class="form-control">');
		        }
		    }

		    $(document).ready(function() {
		        $('#tipoQuestao').on('change', function() {
		            switch ($("#tipoQuestao option:selected").text()) {
		                case 'a':
		                    qnt = 4;
		                    break;
		                case 't':
		                    qnt = 1;
		                    break;
		                case 'v':
		                    qnt = 2;
		                    break;
		            }
		            $('#alternativas').empty();
		            qntAlternativas(qnt);
		        });
		    });
		</script-->
		</div>		
	</body>
</html>