<table id="grid" class="table-striped">
	<thead>
		<th>Código da Questão</th>
		<th>Titulo Questão</th>
		<th>Código do Assunto</th>
		<th>Imagem</th>
		<th>Tipo de Questão</th>
		<th>codProfessor</th>
		<th>Ativo?</th>
		<th>Dificuldade</th>
	</thead>
	<tbody>
	<?php
	include('conexao.php');
       while ($resultado = odbc_fetch_array($consulta)) {      	
		echo "<tr>";
			echo "<td>".$resultado['codQuestao']."</td>";
			echo "<td class=\"questao\">".$resultado['textoQuestao']."</td>";
			echo "<td>".$resultado['codAssunto']."</td>";
			$imageData = base64_encode($resultado['bitmapImagem']);
			if(!empty($imageData)){echo "<td><img width=\"50\" height=\"50\" src=\"data:image/jpeg;base64,".$imageData."\"></td>";}
			echo "<td>".$resultado['codTipoQuestao']."</td>";
			echo "<td>".$resultado['codProfessor']."</td>";
			echo "<td>".$resultado['ativo']."</td>";
			echo "<td>".$resultado['dificuldade']."</td>";
			echo "<td><a href='admin.php?page=form&codquestao=".$resultado['codQuestao']."'>Editar</a></td>";
		echo "</tr>";
       }
    ?>
	</tbody>
</table>

<h3><?php if($_SESSION['SUCESSO']){echo "Questão cadastrada com sucesso!";}?></h3>