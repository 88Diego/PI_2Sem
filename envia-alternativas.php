<?php 

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
        

        if ($_SESSION['codProfessor'] == $linhasTipoPr['codProfessor'] || $_SESSION['tipoProfessor'] == 'A') {


            $queryAlternativa = "INSERT INTO ALTERNATIVA (codQuestao, codAlternativa, textoAlternativa, correta) VALUES (?, ?, ?, ?)";


        } else {
            
            echo '<p class="erro">Você não pode alterar as alternativas.</p>';
            $queryAlternativa = NULL;
        }

        
        if ($_POST['opcao_certa'] == $i || $_POST['opcao_certa'] == 'T') {               
            

            $paramsAlternativa = array(
                $_GET['codquestao'],
                $i,
                $value,
                1
            );


        } 
        else {
            $paramsAlternativa = array(
                $_GET['codquestao'],
                $i,
                $value,
                0
            );
        }



        if (isset($queryAlternativa) && $queryAlternativa != NULL) {
            $prepAlternativa   = odbc_prepare($connect, $queryAlternativa);
            $resultAlternativa = odbc_execute($prepAlternativa, $paramsAlternativa);
        }

        $i++;
    }



} 

    ?>