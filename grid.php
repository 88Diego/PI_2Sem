<table id="grid" class="table-striped">
	<caption>Grid de perguntas</caption>
	<thead>
		<th>codQuestao</th>
		<th>textoQuestao</th>
		<th>codAssunto</th>
		<th>codImagem</th>
		<th>codTipoQuestao</th>
		<th>codProfessor</th>
		<th>ativo</th>
		<th>dificuldade</th>
	</thead>
	<tbody>
	<?php
	include('conexao.php');
       while ($resultado = odbc_fetch_array($consulta)) {      	
		echo "<tr>";
			echo "<td>".$resultado['codQuestao']."</td>";
			echo "<td>".$resultado['textoQuestao']."</td>";
			echo "<td>".$resultado['codAssunto']."</td>";
			$imageData = base64_encode($resultado['bitmapImagem']);
			echo "<td><img width=\"50\" height=\"50\" src=\"data:image/jpeg;base64,".$imageData."\"></td>";
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