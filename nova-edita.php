<form action="salva-form.php" method="get" id="novo-edita">
	<input type="hidden" id="idQuestao" value="<?php $codQuestao;?>">
	<label for="imagem">
		Imagem da Questão:
		<input type="file" id="imagem" name="imagem">
	</label>
	<label for="txQuestao">
		Título da Questão:
		<input type="text" id="txQuestao" name="txQuestao">
	</label>
	<label for="assunto">
		Assunto da Questão:
		<select name="assunto" id="assunto">
			<option value="0">Assunto 0</option>
			<option value="1">Assunto 1</option>
			<option value="2">Assunto 2</option>
			<option value="3">Assunto 3</option>
		</select>
	</label>
	<label for="tipoQuestao">
		Tipo da Questão:
		<select name="tipoQuestao" id="tipoQuestao">
			<option value="a">Alternativas</option>
			<option value="t">Texto Objetivo</option>
			<option value="v">Verdadeiro ou Falso</option>
		</select>
	</label>
	<label for="">
		Dificuldade da Questão:
		<select name="dificuldade" id="dificuldade">
			<option value="f">Fácil</option>
			<option value="m">Médio</option>
			<option value="d">Difícil</option>
		</select>
	</label>
	<label for="ativo">
		Pergunta ativa?
		<input type="checkbox" id="ativo" name="ativo" value="1" checked>
	</label>
	<label for="alternativas">
		<input type="text" name="alternativas0">
		<input type="text" name="alternativas1">
		<input type="text" name="alternativas2">
		<input type="text" name="alternativas3">
	</label>
	<input type="submit" value="Salvar nova">
</form>