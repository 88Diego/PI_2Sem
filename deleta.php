<?php
	
	if( isset( $_GET['codquestao'] ) ){
		$id_questao = $_GET['codquestao'];
		$query_questao = "SELECT * FROM questao LEFT JOIN imagem ON (questao.codImagem = imagem.codImagem) WHERE codQuestao = ".$id_questao."";
		$questao = odbc_exec( $connect, $query_questao );
		$linhas_questao = odbc_fetch_array( $questao );
		if ($_SESSION['codProfessor'] == $linhas_questao['codProfessor']) {
			$query_delet = "DELETE FROM questao WHERE codQuestao = ".$id_questao."";
			$delet = odbc_exec($connect, $query_delet);
			echo "deletado";
		}else echo "Não pode deletar";
		
		
	}

?>