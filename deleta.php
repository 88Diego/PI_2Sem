<div id="textos">
	<?php
		
		if( isset( $_GET['codquestao'] ) ){
			$idQuestao = $_GET['codquestao'];
			$pagination = 1;
			$queryQuestao = "SELECT * FROM questao LEFT JOIN imagem ON (questao.codImagem = imagem.codImagem) WHERE codQuestao = ".$idQuestao."";
			$queryEvento = "SELECT * FROM questaoevento WHERE codQuestao = ".$idQuestao."";
			$questao = odbc_exec( $connect, $queryQuestao );
			odbc_binmode($questao, ODBC_BINMODE_RETURN);
			odbc_longreadlen($questao, 90000000);
			$evento = odbc_exec($connect, $queryEvento);
			$linhasQuestao = odbc_fetch_array( $questao );
			$questaoEvento = odbc_num_rows($evento);

			if($questaoEvento<1){

				if ($_SESSION['codProfessor'] == $linhasQuestao['codProfessor'] && $linhasQuestao['ativo']==0) {

					$queryDeletAlternativa = "DELETE FROM alternativa WHERE codquestao = ".$idQuestao."";
					$deletAlternativa = odbc_exec($connect, $queryDeletAlternativa);

					$queryDeletQuestao = "DELETE FROM questao WHERE codQuestao = ".$idQuestao."";
					$deletQuestao = odbc_exec($connect, $queryDeletQuestao);

					$idImagem = $linhasQuestao['codImagem'];
					if(isset($idImagem)){
						$queryDeletImagem = "DELETE FROM imagem WHERE codImagem = ".$idImagem."";
						$deletImagem = odbc_exec($connect, $queryDeletImagem);
					}					

					echo "Questão deletada";
					header( "refresh:5;url=admin.php?page=grid&pagina=".$pagination."" );

				}else if($_SESSION['codProfessor'] == $linhasQuestao['codProfessor'] && $linhasQuestao['ativo']!=0){
					$queryAtivo = "UPDATE questao SET ativo=0 WHERE codQuestao = ".$idQuestao."";
					$updateAtivo = odbc_exec($connect, $queryAtivo);
					echo "Questão desativada";

					header( "refresh:5;url=admin.php?page=grid&pagina=".$pagination."" );
				}

				else {
					echo "Você não pode deletar esta questão";
					header( "refresh:5;url=admin.php?page=grid&pagina=".$pagination."" );
				}
			
			}
			else {
				echo "Questão já utilizada, não pode ser deletada";
				header( "refresh:5;url=admin.php?page=grid&pagina=".$pagination."" );
			}
		}

	?>
</div>