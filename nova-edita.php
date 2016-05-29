<?php 
if( isset( $_GET['codquestao'] ) ){
	$id_questao = $_GET['codquestao'];
	$query_questao = "SELECT * FROM questao LEFT JOIN imagem ON (questao.codImagem = imagem.codImagem) WHERE codQuestao = ".$id_questao."";
	$query_alternativa = "SELECT q.codQuestao, q.textoQuestao, q.codAssunto, q.codTipoQuestao, a.textoAlternativa, a.correta FROM questao Q INNER JOIN alternativa A ON q.codQuestao = a.codQuestao";
	$array_questao = odbc_exec( $connect, $query_questao );
	$array_alternativas = odbc_exec( $connect, $query_alternativa );
	while ($linhas_questao = odbc_fetch_array( $array_questao )) {
		$textoQuestao = utf8_encode($linhas_questao['textoQuestao']);
		$codAssunto = $linhas_questao['codAssunto'];
		$imageData = base64_encode($linhas_questao['bitmapImagem']);			
		$codTipoQuestao =  $linhas_questao['codTipoQuestao'];
		$id_professor = $linhas_questao['codProfessor'];
		$dificuldade = $linhas_questao['dificuldade'];
	}

	while($linhas_alternativas = odbc_fetch_array( $array_alternativas )){
		$codQuestao = $linhas_alternativas['codQuestao'];
		$codAssunto = $linhas_alternativas['codAssunto'];
		$codTipoQuestao = $linhas_alternativas['codTipoQuestao'];
		$correta = $linhas_alternativas['correta'];

		// echo $codQuestao;
		// echo "<br/><br/><br/>";
		// echo $codAssunto;
		// echo "<br/><br/><br/>";
		// echo $codTipoQuestao;
		// echo "<br/><br/><br/>";
		// echo $correta;
		// echo "<br/><br/><br/>";
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
		<select name="codTipoQuestao" id="tipoQuestao" class="form-control" required>
			<option value="">Selecione o Tipo da Questão</option>
			<?php while( $tipoQuestao = odbc_fetch_array( $resultQuestao ) ){?>
	            <option value="<?php echo $tipoQuestao['codTipoQuestao']?>" <?=( strtoupper( $tipoQuestao['codTipoQuestao'] ) == strtoupper( $codTipoQuestao ) )? "selected" : "" ?> ><?php echo $tipoQuestao['descricao'] ?></option>

	    <?php } ?>
	    </select>
	</label>

	<label for="dificuldade">
		Dificuldade da Questão:
		<select name="dificuldade" id="dificuldade" class="form-control" required>
			<option value="">Selecione a Dificuldade</option>
			<option value="D" <?=(($dificuldade == "D")||($dificuldade == "d"))?"selected":""?>>Difícil</option>
			<option value="F" <?=(($dificuldade == "F")||($dificuldade == "f"))?"selected":""?>>Fácil</option>
			<option value="M" <?=(($dificuldade == "M")||($dificuldade == "m"))?"selected":""?>>Médio</option>
		</select>
	</label>

	<label for="txQuestao">
		Título da Questão:
		<input type="text" id="txQuestao" name="txQuestao" class="form-control" required value="<?=( isset ($textoQuestao) ) ? "$textoQuestao" : "" ?>">
	</label>
	
	<label for="alternativas" id="alternativas" style="display: none;">
		Alternativas:	
		<div class="verdadeiro_falso dft" style="display: none;">
			<input type="radio" name="verdadeirofalso" value="V"> Verdadeiro
			<input type="radio" name="verdadeirofalso" value="F"> Falso
		</div>
		<div class="alternativas dft" style="display: none;">
			<a href="javascript:void(0)" class="add alternativas">Adicionar Campo</a>
			<a href="javascript:void(0)" class="deleteOpc">Remover Campo</a>
		</div>
		<div class="texto_objetivo dft" style="display: none;">
			<input type="hidden" value="corretas" name="opcao_certa">
			<a href="javascript:void(0)" class="add texto_objetivo">Adicionar Campo</a>
			<a href="javascript:void(0)" class="deleteOpc">Remover Campo</a>
		</div>				
	</label>

    <label for="imagem">
		Imagem da Questão:
		<input type="file" id="imagem" name="imagem">		
		<?php if( !empty( $imageData ) ){
			echo "<img width=\"50\" height=\"50\" src=\"data:image/jpeg;base64,".$imageData."\">"; 
		}?>
	</label>	

	<input type="submit" value="Salvar" class="btn btn-default">
	<div id="del">
		<?php 
			if(isset($_GET['codquestao'])){
				echo"<a href='admin.php?page=deleta&codquestao=".$_GET['codquestao']."'>Deletar</a>";
			}	
		?>
	</div>
</form>

<script>
	$(document).ready(function(){

		if($('#tipoQuestao').val() != ""){
			if($('#tipoQuestao').val() == "A"){
				$('.dft').hide();
				$('#alternativas, .alternativas').show();
			} else if($('#tipoQuestao').val() == "T"){
				$('.dft').hide();
				$('#alternativas, .text_objetivo').show();
			} else{
				$('.dft').hide();
				$('#alternativas, .verdadeiro_falso').show();
			}
		}

		$('#tipoQuestao').on('change', function(){
			if(this.value == "A"){
				$('.dft').hide();
				$('#alternativas, .alternativas').show();
			} else if(this.value == "T"){
				$('.dft').hide();
				$('#alternativas, .texto_objetivo').show();
			} else{
				$('.dft').hide();
				$('#alternativas, .verdadeiro_falso').show();
			}
		});

		var i = 0;

		$('#alternativas a').on('click', function(){
		
			if ($(this).hasClass('add')) {
				i++;
				if($(this).hasClass('alternativas')){
					$(this).parent().prepend('<input type="text" name="alternativas[]" data-index="'+ i + '" class="form-control" value="<?=( isset( $txAlternativas )) ? "echo $txAlternativas;" : "" ?>"><input class="check_certa" type="radio" name="opcao_certa">');

				} else{
					$(this).parent().prepend('<input type="text" name="alternativas[]" class="form-control" value="<?=( isset( $txObjetivo )) ? "echo $txObjetivo;" : "" ?>">');
				}							
			} else {				
				$(this).parent().children('input').eq(0).remove();
				i--;
			}
		});

		$('.alternativas').on('change', 'input[type=radio]', function(){
			$(this).val($($(this).prev()).data('index'));
		});
	});
</script>