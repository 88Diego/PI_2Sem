<?php 
if(isset($_GET['codquestao'])){
	$codQuestao = $_GET['codquestao'];	

	$queryUpdate = 
			"SELECT * FROM questao LEFT JOIN imagem ON (questao.codImagem = imagem.codImagem) WHERE codQuestao = ".$codQuestao."";

	$consultaUpdate = odbc_exec($connect,$queryUpdate);
	$resultadoUpdate = odbc_num_rows($consultaUpdate);
	while ($resultadoUpdate = odbc_fetch_array($consultaUpdate)) {
		$textoQuestao = $resultadoUpdate['textoQuestao'];
		$codAssunto = $resultadoUpdate['codAssunto'];
		$imageData = base64_encode($resultadoUpdate['bitmapImagem']);			
		$codTipoQuestao =  $resultadoUpdate['codTipoQuestao'];
		$codProfessor = $resultadoUpdate['codProfessor'];
		$dificuldade = $resultadoUpdate['dificuldade'];
	}
} else{
	// zero variaveis do formulario
}
?>

<form action="salva-form.php" enctype="multipart/form-data" method="post" id="novo-edita" >
	<input type="hidden" id="codQuestao" value="<?php echo $codQuestao; ?>">
    <label for="assunto">
    <?php 
		$consultAss=("SELECT codAssunto, descricao FROM assunto");
		$resultAss=odbc_exec($connect,$consultAss);
	?>
	Assunto da Questão:
	<select name="codAssunto" id="assunto" class="form-control">
		<option>Selecione o Assunto</option>
		<?php while($assOpt=odbc_fetch_array($resultAss)){?>
            <option value="<?php echo $assOpt['codAssunto']?>" <?=($assOpt['codAssunto']==$codAssunto)?"selected":""?> ><?php echo $assOpt['descricao'] ?></option>

        <?php } ?>
	</select>
	</label>
	<label for="tipoQuestao">
		Tipo da Questão:
		<?php 
			$consultQuestao=("SELECT codTipoQuestao, descricao FROM tipoQuestao");
			$resultQuestao=odbc_exec($connect,$consultQuestao);
		?>

		<select name="codTipoQuestao" id="tipoQuestao" class="form-control">
			<option>Selecione o Tipo da Questão</option>
			<?php while($tipoQuestao = odbc_fetch_array($resultQuestao)){?>
	            <option value="<?php echo $tipoQuestao['codTipoQuestao']?>" <?=(strtoupper($tipoQuestao['codTipoQuestao']) == strtoupper($codTipoQuestao))?"selected":""?> ><?php echo $tipoQuestao['descricao'] ?></option>

	    <?php } ?>
	    </select>
	</label>
	<label for="">
		Dificuldade da Questão:
		<?php 
			$consultQuestao=("SELECT codTipoQuestao, descricao FROM tipoQuestao");
			$resultQuestao=odbc_exec($connect,$consultQuestao);
		?>
		<select name="dificuldade" id="dificuldade" class="form-control">
			<option>Selecione a Dificuldade</option>
			<option value="f" <?=(($dificuldade == "F")||($dificuldade == "f"))?"selected":""?>>Fácil</option>
			<option value="m" <?=(($dificuldade == "M")||($dificuldade == "m"))?"selected":""?>>Médio</option>
			<option value="d" <?=(($dificuldade == "D")||($dificuldade == "d"))?"selected":""?>>Difícil</option>
		</select>
	</label>
	<label for="txQuestao">
		Título da Questão:
		<input type="text" id="txQuestao" name="txQuestao" class="form-control" value="<?=(isset($textoQuestao))?"echo $textoQuestao;":""?>">
	</label>
	
	<label for="alternativas">
		<input type="text" name="alternativas0" class="form-control" placeholder="Alternativa 1">		
	</label>
    <label for="imagem">
		Imagem da Questão:
		<input type="file" id="imagem" name="imagem">		
	</label>
	<?php echo "<img width=\"50\" height=\"50\" src=\"data:image/jpeg;base64,".$imageData."\">"; ?>
	<input type="submit" value="Salvar nova" class="btn btn-default">
</form>