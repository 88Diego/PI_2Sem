<table id="grid">
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
       while ($resultado = odbc_fetch_array($consulta)) {      	
           echo "<tr>";
	           echo "<td>".$resultado['codQuestao']."</td>";
	           echo "<td>".$resultado['textoQuestao']."</td>";
	           echo "<td>".$resultado['codAssunto']."</td>";
	           echo "<td>".$resultado['codImagem']."</td>";
	           echo "<td>".$resultado['codTipoQuestao']."</td>";
	           echo "<td>".$resultado['codProfessor']."</td>";
	           echo "<td>".$resultado['ativo']."</td>";
	           echo "<td>".$resultado['dificuldade']."</td>";
           echo "</tr>";
       }
    ?>
	</tbody>
</table>