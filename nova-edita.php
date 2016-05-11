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
<<<<<<< HEAD
		Assunto da Questão:
		<select name="codAssunto" id="assunto" class="form-control" required>
			<option value="">Selecione o Assunto</option>
			<?php while($assOpt=odbc_fetch_array($resultAss)){?>
                <option value="<?php echo $assOpt['codAssunto']?>"><?php echo $assOpt['descricao'] ?></option>
                <?php } ?>
		</select>
	</label>
	<label for="tipoQuestao">
		Tipo da Questão:
		<select required name="codTipoQuestao" id="tipoQuestao" class="form-control">
			<option value="">Selecione o tipo da questão</option>
			<option value="a">Alternativas</option>
			<option value="t">Texto Objetivo</option>
			<option value="v">Verdadeiro ou Falso</option>
		</select>
	</label>
	<label for="">
		Dificuldade da Questão:
		<select name="dificuldade" id="dificuldade" class="form-control" required>
			<option value="">Selecione a dificuldade da questão</option>
			<option value="f">Fácil</option>
			<option value="m">Médio</option>
			<option value="d">Difícil</option>
=======
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
>>>>>>> 50f16c3cc906a0826c82eabe3a8be9176db562dc
		</select>
	</label>
	<label for="txQuestao">
		Título da Questão:
<<<<<<< HEAD
		<input type="text" id="txQuestao" name="txQuestao" class="form-control" required>
	</label>
	
	<label for="ativo">
		Pergunta ativa?
		<input type="checkbox" id="ativo" name="ativo" value="1" checked>
	</label>
	<label for="alternativas" id="alternativas">
		<input type="text" name="alternativas0" class="form-control" placeholder="Alternativa 1">
		<input type="text" name="alternativas1" class="form-control" placeholder="Alternativa 2">
		<input type="text" name="alternativas2" class="form-control" placeholder="Alternativa 3">
		<input type="text" name="alternativas3" class="form-control" placeholder="Alternativa 4">
=======
		<input type="text" id="txQuestao" name="txQuestao" class="form-control" value="<?=(isset($textoQuestao))?"echo $textoQuestao;":""?>">
	</label>
	
	<label for="alternativas">
		<input type="text" name="alternativas0" class="form-control" placeholder="Alternativa 1">		
>>>>>>> 50f16c3cc906a0826c82eabe3a8be9176db562dc
	</label>
    <label for="imagem">
		Imagem da Questão:
		<input type="file" id="imagem" name="imagem">		
	</label>
	<?php echo "<img width=\"50\" height=\"50\" src=\"data:image/jpeg;base64,".$imageData."\">"; ?>
	<input type="submit" value="Salvar nova" class="btn btn-default">
</form>