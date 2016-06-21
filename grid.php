<?php
//pagina de visualização das questões
include_once('session.php');

?>


<?php
    $pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;
    $limite = 15;

    include('conexao.php');
    $queryGrid     = "SELECT * FROM questao LEFT JOIN imagem ON (questao.codImagem = imagem.codImagem) 
    		ORDER BY questao.codQuestao DESC
    		OFFSET ($pagina-1)* $limite ROWS 
    		FETCH NEXT $limite ROWS ONLY ";//query de consulta no banco
    $consultaGrid  = odbc_exec($connect, $queryGrid);//busca dos dados no banco de acordo com a query
    odbc_binmode($consultaGrid, ODBC_BINMODE_RETURN);//codificação do dados em binario
    odbc_longreadlen($consultaGrid, 90000000);// habilita a utlitização de dados long
    $resultadoGrid = odbc_num_rows($consultaGrid);//resultado da consulta no banco
?>
    
<div class="grid">
<table id="grid" class="table-striped">

	<thead>
		
		<th>Titulo Questão</th>
		<th>Imagem</th>
		<th>Tipo de Questão</th>
		<th>Dificuldade</th>
		<th>Editar</th>
		<th>Deletar</th>
	</thead>
	<tbody>
	<?php

while ($resultado = odbc_fetch_array($consultaGrid)) {//laço que renderiza cada linha referente a uma questão no grid
    echo "<tr>";
    echo "<td class=\"questao\">" . utf8_decode($resultado['textoQuestao']) . "</td>";
    $imageData = base64_encode($resultado['bitmapImagem']);
    echo "<td>";
    if (!empty($imageData)) {
        echo "<img width=\"50\" height=\"50\" src=\"data:image/jpeg;base64," . $imageData . "\">    ";
    } else {
        echo "-";
    }
    echo "</td>";
    echo "<td>" . strtoupper($resultado['codTipoQuestao']) . "</td>";
    echo "<td>" . strtoupper($resultado['dificuldade']) . "</td>";
    echo "<td><a href='admin.php?page=form&codquestao=" . $resultado['codQuestao'] . "' class='editar'>Editar</a></td>";
    echo "<td><a href='admin.php?page=deleta&codquestao=" . $resultado['codQuestao'] . "' class='deletar'>Deletar</a></td>";
    echo "</tr>";
}


?>
	</tbody>
</table>
</div>
<div id="paginacao">
<?php
//divisão das questões em paginas
    $queryPage    = "SELECT * FROM questao LEFT JOIN imagem ON (questao.codImagem = imagem.codImagem) ";
    $consultaPage = odbc_exec($connect, $queryPage);
    $total        = odbc_num_rows($consultaPage);
    $numPage      = ceil($total / $limite);

    for ($i = 1; $i < $numPage + 1; $i++) {
        echo "<a href='admin.php?page=grid&pagina=$i'>" . "&nbsp &nbsp" . $i . "</a> ";
    }

?>
</div>