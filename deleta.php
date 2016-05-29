<div id="delete">
	<?php
		
		if( isset( $_GET['codquestao'] ) ){
			$id_questao = $_GET['codquestao'];
			$query_questao = "SELECT * FROM questao LEFT JOIN imagem ON (questao.codImagem = imagem.codImagem) WHERE codQuestao = ".$id_questao."";
			$query_alternativa = "SELECT q.codQuestao, q.textoQuestao, q.codAssunto, q.codTipoQuestao, a.textoAlternativa, a.correta FROM questao Q INNER JOIN alternativa A ON q.codQuestao = a.codQuestao";
			$questao = odbc_exec( $connect, $query_questao );
			$alternativa = odbc_exec($connect, $query_alternativa);
			$linhas_questao = odbc_fetch_array( $questao );
			$linhas_alternativa = odbc_fetch_array($alternativa);
			if ($_SESSION['codProfessor'] == $linhas_questao['codProfessor'] && $linhas_questao['ativo']==0) {
				$query_delet_alternativa = "DELETE FROM alternativa WHERE codquestao = ".$id_questao."";
				$delet_alternativa = odbc_exec($connect, $query_delet_alternativa);

				$query_delet_questao = "DELETE FROM questao WHERE codQuestao = ".$id_questao."";
				$delet_questao = odbc_exec($connect, $query_delet_questao);

				echo "Questão deletada";
			}else if($_SESSION['codProfessor'] == $linhas_questao['codProfessor'] && $linhas_questao['ativo']!=0){
				$query_ativo = "UPDATE questao SET ativo=0 WHERE codQuestao = ".$id_questao."";
				$update_ativo = odbc_exec($connect, $query_ativo);
				echo "O campo ativo foi atualizado";
			}

			else echo "Você não pode deletar esta questão";
			
			
		}

	?>
</div>