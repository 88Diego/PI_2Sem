<?php
//pagina onde é feito o delete da questão
include_once('session.php');

?>

<div id="textos">
	<?php

if (isset($_GET['codquestao'])) {//caso o exista o parametro de codquestao na url o sistema dara continuidade
    $idQuestao    = $_GET['codquestao'];
    $pagination   = 1;
    $queryQuestao = "SELECT * FROM questao LEFT JOIN imagem ON (questao.codImagem = imagem.codImagem) WHERE codQuestao = " . $idQuestao . "";//query de consulta da questão onde o codquestao deve ser igual ao paramentro passado
    $queryEvento  = "SELECT * FROM questaoevento WHERE codQuestao = " . $idQuestao . "";//query que verifica se a questão já foi utilizada em algum evento
    $questao      = odbc_exec($connect, $queryQuestao);//função de conexão utilizando a query da questão
    odbc_binmode($questao, ODBC_BINMODE_RETURN);//função que codifica a imagem
    odbc_longreadlen($questao, 90000000);//função que armazena o tamanho da imagem
    $evento        = odbc_exec($connect, $queryEvento);//função de conexão com o banco utilizando a pesquisa sobre o evento
    $linhasQuestao = odbc_fetch_array($questao);//variavel que armazena o resultado da busca da questão
    $questaoEvento = odbc_num_rows($evento);//variavel que armazena o resultado sobre o evento
    
    if ($questaoEvento < 1) {//caso a questão não tenha sido utilizada em um evento ela podera ser excluida
        
        if ($_SESSION['codProfessor'] == $linhasQuestao['codProfessor'] || $_SESSION['tipoProfessor'] == 'A') {
            
            $queryDeletAlternativa = "DELETE FROM alternativa WHERE codquestao = " . $idQuestao . "";
            $deletAlternativa      = odbc_exec($connect, $queryDeletAlternativa);//função que deleta as alternativas vinvulada a questão
            
            $queryDeletQuestao = "DELETE FROM questao WHERE codQuestao = " . $idQuestao . "";
            $deletQuestao      = odbc_exec($connect, $queryDeletQuestao);//função que deleta a questão
            
            $idImagem = $linhasQuestao['codImagem'];
            if (isset($idImagem)) {
                $queryDeletImagem = "DELETE FROM imagem WHERE codImagem = " . $idImagem . "";
                $deletImagem      = odbc_exec($connect, $queryDeletImagem);//função que deleta a imagem vinculada a questão caso ela exista
            }
            
            echo "Questão deletada";
            header("refresh:3;url=admin.php?page=grid&pagina=" . $pagination . "");
        }
        
        else {
            echo "Você não pode deletar esta questão";
            header("refresh:3;url=admin.php?page=grid&pagina=" . $pagination . "");
        }
        
    } else {
        echo "Questão já utilizada, não pode ser deletada";
        $queryAtivo  = "UPDATE questao SET ativo=0 WHERE codQuestao = " . $idQuestao . "";
        $updateAtivo = odbc_exec($connect, $queryAtivo);//função que modifica a campo ativo da questão para que ela fique desativada
        header("refresh:3;url=admin.php?page=grid&pagina=" . $pagination . "");
    }
}

?>
</div>