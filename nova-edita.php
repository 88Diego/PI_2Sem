<form action="salva-form.php" enctype="multipart/form-data" method="post" id="novo-edita" >
	<input type="hidden" id="idQuestao" value="<?php $codQuestao;?>">
    <label for="assunto">
    <?php 
	$consultAss=("SELECT codAssunto, descricao FROM assunto");
	$resultAss=odbc_exec($connect,$consultAss);
	?>
		Assunto da Questão:
		<select name="codAssunto" id="assunto" class="form-control">
			<option>Selecione o Assunto</option>
			<?php while($assOpt=odbc_fetch_array($resultAss)){?>
                <option value="<?php echo $assOpt['codAssunto']?>"><?php echo $assOpt['descricao'] ?></option>
                <?php } ?>
		</select>
	</label>
	<label for="tipoQuestao">
		Tipo da Questão:
		<select name="codTipoQuestao" id="tipoQuestao" class="form-control">
			<option value="a">Alternativas</option>
			<option value="t">Texto Objetivo</option>
			<option value="v">Verdadeiro ou Falso</option>
		</select>
	</label>
	<label for="">
		Dificuldade da Questão:
		<select name="dificuldade" id="dificuldade" class="form-control">
			<option value="f">Fácil</option>
			<option value="m">Médio</option>
			<option value="d">Difícil</option>
		</select>
	</label>
	<label for="txQuestao">
		Título da Questão:
		<input type="text" id="txQuestao" name="txQuestao" class="form-control">
	</label>
	
	<label for="ativo">
		Pergunta ativa?
		<input type="checkbox" id="ativo" name="ativo" value="1" checked>
	</label>
	<label for="alternativas">
		<input type="text" name="alternativas0" class="form-control" placeholder="Alternativa 1">
		<input type="text" name="alternativas1" class="form-control" placeholder="Alternativa 2">
		<input type="text" name="alternativas2" class="form-control" placeholder="Alternativa 3">
		<input type="text" name="alternativas3" class="form-control" placeholder="Alternativa 4">
	</label>
    <label for="imagem">
		Imagem da Questão:
		<input type="file" id="imagem" name="imagem">
	</label>
	<input type="submit" value="Salvar nova" class="btn btn-default">
</form>