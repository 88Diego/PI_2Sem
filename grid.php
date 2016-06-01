<?php
	$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;
	$limite = 10;

	include('conexao.php');
		$queryGrid = "SELECT * FROM questao LEFT JOIN imagem ON (questao.codImagem = imagem.codImagem) 
		ORDER BY questao.codQuestao
		OFFSET ($pagina-1)* $limite ROWS 
		FETCH NEXT $limite ROWS ONLY ";
		$consultaGrid = odbc_exec($connect,$queryGrid);
		$resultadoGrid = odbc_num_rows($consultaGrid);
?>

<table id="grid" class="table-striped">

	<thead>
		<!-- <th>Código da Questão</th> -->
		<th>Titulo Questão</th>
		<!-- <th>Código do Assunto</th> -->
		<th>Imagem</th>
		<th>Tipo de Questão</th>
		<!-- <th>codProfessor</th> -->
		<!-- <th>Ativo?</th> -->
		<th>Dificuldade</th>
		<th>Editar</th>
	</thead>
	<tbody>
	<?php

       while ($resultado = odbc_fetch_array($consultaGrid)) {      	
		echo "<tr>";
			// echo "<td>".$resultado['codQuestao']."</td>";
			echo "<td class=\"questao\">".utf8_encode( $resultado['textoQuestao'] )."</td>";
			// echo "<td>".$resultado['codAssunto']."</td>";
			$imageData = base64_encode($resultado['bitmapImagem']);
			echo "<td>";
			if( !empty( $imageData ) ){
				echo "<img width=\"50\" height=\"50\" src=\"data:image/jpeg;base64,".$imageData."\">";
			} else{
				echo "-";
			}
			echo "</td>";
			echo "<td>".strtoupper( $resultado['codTipoQuestao'] )."</td>";
			// echo "<td>".$resultado['codProfessor']."</td>";
			// echo "<td>".$resultado['ativo']."</td>";
			echo "<td>".strtoupper( $resultado['dificuldade'] )."</td>";
			echo "<td><a href='admin.php?page=form&codquestao=".$resultado['codQuestao']."'>Editar</a></td>";
		echo "</tr>";
       }
   

    ?>
	</tbody>
</table>
<div id="paginacao">
<?php
	$queryPage = "SELECT * FROM questao LEFT JOIN imagem ON (questao.codImagem = imagem.codImagem) ";
	$consultaPage = odbc_exec($connect,$queryPage);
	$total = odbc_num_rows($consultaPage);
	$numPage = ceil($total/$limite);
		
	for($i = 1; $i < $numPage + 1; $i++) {
             echo "<a href='admin.php?page=grid&&pagina=$i'>"."&nbsp &nbsp".$i."</a> ";
        }

?>
</div>
<!-- <h3><?php if($_SESSION['SUCESSO']){echo "Questão cadastrada com sucesso!";}?></h3> -->