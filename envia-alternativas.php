<?php 
//pagina que efetua o envio das alternativas
$i = 1;


$queryDelAlternativa  = "DELETE FROM alternativa WHERE codQuestao = ?";    
$paramsDelAlternativa = array($_GET['codquestao']);      
$prepDelAlternativa   = odbc_prepare($connect, $queryDelAlternativa);
$resultDelAlternativa = odbc_execute($prepDelAlternativa, $paramsDelAlternativa);


if (isset($_POST['alternativas'])) {

    foreach ($_POST['alternativas'] as $key => $value) {

        
       
        $queryTipoPr  = "SELECT * FROM questao WHERE codQuestao = " . $_GET['codquestao'] . "";
        $tipoPr       = odbc_exec($connect, $queryTipoPr);
        $linhasTipoPr = odbc_fetch_array($tipoPr);
        

        if ($_SESSION['codProfessor'] == $linhasTipoPr['codProfessor'] || $_SESSION['tipoProfessor'] == 'A') {//verifica se o professor pode editar as alternativas


            $queryAlternativa = "INSERT INTO ALTERNATIVA (codQuestao, codAlternativa, textoAlternativa, correta) VALUES (?, ?, ?, ?)";


        } else {
            
            echo '<p class="erro">Você não pode alterar as alternativas.</p>';
            $queryAlternativa = NULL;
        }

        
        if ($_POST['opcao_certa'] == $i || $_POST['opcao_certa'] == 'T') {   //define qual a opção correta nas alternativas            
            

            $paramsAlternativa = array(
                $_GET['codquestao'],
                $i,
                utf8_encode($value),
                1
            );//parametros da alternativa correta


        } 
        else {
            $paramsAlternativa = array(
                $_GET['codquestao'],
                $i,
                utf8_encode($value),
                0
            );//parametros das alternativas erradas
        }

        if (isset($queryAlternativa) && $queryAlternativa != NULL) {
            $prepAlternativa   = odbc_prepare($connect, $queryAlternativa);
            $resultAlternativa = odbc_execute($prepAlternativa, $paramsAlternativa);
        }

        $i++;
    }

} 

?>