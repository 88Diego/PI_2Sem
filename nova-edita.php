<?php 
if( isset( $_GET['codquestao'] ) ){
	$id_questao = $_GET['codquestao'];
	$query_questao = "SELECT * FROM questao LEFT JOIN imagem ON (questao.codImagem = imagem.codImagem) WHERE codQuestao = ".$id_questao."";
	$array_questao = odbc_exec( $connect, $query_questao );
	while ($linhas_questao = odbc_fetch_array( $array_questao )) {
		$textoQuestao = $linhas_questao['textoQuestao'];
		$codAssunto = $linhas_questao['codAssunto'];
		$imageData = base64_encode($linhas_questao['bitmapImagem']);			
		$codTipoQuestao =  $linhas_questao['codTipoQuestao'];
		$id_professor = $linhas_questao['codProfessor'];
		$dificuldade = $linhas_questao['dificuldade'];
	}
} else{
	$textoQuestao = NULL;
	$codAssunto = NULL;
	$codTipoQuestao = NULL;
	$textoQuestao = NULL;
	$imageData = NULL;
	$dificuldade = NULL;
}
?>

<form action="salva-form.php" enctype="multipart/form-data" method="post" id="novo-edita" >
	<input type="hidden" id="id_questao" value="<?php echo $id_questao; ?>">
    <label for="assunto">
	    <?php 
			$query_assunto = "SELECT codAssunto, descricao FROM assunto ORDER BY descricao";
			$resultado_assunto = odbc_exec( $connect, $query_assunto );
		?>
		Assunto da Questão:
		<select name="codAssunto" id="assunto" class="form-control" required>
			<option value="">Selecione o Assunto</option>
			<?php while( $opcoes_assunto = odbc_fetch_array( $resultado_assunto ) ){?>
                <option value="<?php echo $opcoes_assunto['codAssunto']?>" <?=( $opcoes_assunto['codAssunto'] == $codAssunto ) ? "selected" : "" ?> ><?php echo $opcoes_assunto['descricao'] ?></option>
            <?php } ?>
		</select>
	</label>

	<label for="tipoQuestao">
		Tipo da Questão:
		<?php 
			$consultQuestao = "SELECT codTipoQuestao, descricao FROM tipoQuestao ORDER BY descricao";
			$resultQuestao = odbc_exec( $connect, $consultQuestao );
		?>
		<select name="codTipoQuestao" id="tipoQuestao" class="form-control">
			<option value="">Selecione o Tipo da Questão</option>
			<?php while( $tipoQuestao = odbc_fetch_array( $resultQuestao ) ){?>
	            <option value="<?php echo $tipoQuestao['codTipoQuestao']?>" <?=( strtoupper( $tipoQuestao['codTipoQuestao'] ) == strtoupper( $codTipoQuestao ) )? "selected" : "" ?> ><?php echo $tipoQuestao['descricao'] ?></option>

	    <?php } ?>
	    </select>
	</label>

	<label for="dificuldade">
		Dificuldade da Questão:
		<select name="dificuldade" id="dificuldade" class="form-control">
			<option value="">Selecione a Dificuldade</option>
			<option value="D" <?=(($dificuldade == "D")||($dificuldade == "d"))?"selected":""?>>Difícil</option>
			<option value="F" <?=(($dificuldade == "F")||($dificuldade == "f"))?"selected":""?>>Fácil</option>
			<option value="M" <?=(($dificuldade == "M")||($dificuldade == "m"))?"selected":""?>>Médio</option>
		</select>
	</label>

	<label for="txQuestao">
		Título da Questão:
		<input type="text" id="txQuestao" name="txQuestao" class="form-control" required>
	</label>
	
	<label for="alternativas" id="alternativas">
		Alternativas:	
		<div class="verdadeiro_falso">
			<!-- dois input radio verdadeiro ou falso -->
		</div>
		<div class="alternativas">
			<input type="text" name="txAlternativas" class="form-control" value="<?=( isset( $txAlternativas )) ? "echo $txAlternativas;" : "" ?>">
			<!-- um input padrào, checkbox para saber qual [e a correta e botoes de add e remove -->
		</div>
		<div class="text_objetivo">
			<input type="text" name="txAlternativas" class="form-control" value="<?=( isset( $txAlternativas )) ? "echo $txAlternativas;" : "" ?>">
			<!-- um input padrao, todos sáo corretos, botao add e rtemove -->
		</div>		
		<a href="javascript:void(0)" id="addAlternativas">Adicionar</a>
		<a href="javascript:void(0)" id="delAlternativas">Remover</a>
	</label>

    <label for="imagem">
		Imagem da Questão:
		<input type="file" id="imagem" name="imagem">		
		<?php if( !empty( $imageData ) ){
			echo "<img width=\"50\" height=\"50\" src=\"data:image/jpeg;base64,".$imageData."\">"; 
		}?>
	</label>	

	<input type="submit" value="Salvar nova" class="btn btn-default">
</form>

<script>
	$(document).ready(function(){
		$('#alternativas a').on('click', function(){
			if ($(this).attr('id') == "addAlternativas") {
				// cria input
			} else{
				// remove ultimo input
			}
		});

		// checar tipo da questao e exibir tipo de alternativa
		// if( ) {
		// 	// verdadeiro e falso
		// } else if(){
		// 	// alternativas
		// } else {
		// 	// texto objetivo
		// }
	});
</script>