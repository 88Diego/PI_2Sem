<?php 

$i = 1;

if (isset($_POST['alternativas'])) {

        
        foreach ($_POST['alternativas'] as $key => $value) {
            
            
            if (isset($_GET['codquestao']) && !is_null($_GET['codquestao'])) {
                
                $queryTipoPr  = "SELECT * FROM questao WHERE codQuestao = " . $_GET['codquestao'] . "";
                $tipoPr       = odbc_exec($connect, $queryTipoPr);
                $linhasTipoPr = odbc_fetch_array($tipoPr);
                
                if ($_SESSION['codProfessor'] == $linhasTipoPr['codProfessor'] || $_SESSION['tipoProfessor'] == 'A') {
                    
                    $queryAlternativa = "UPDATE ALTERNATIVA SET textoAlternativa = ?, correta = ? WHERE codQuestao = " . $_GET['codquestao'] . " and codAlternativa = ?";
                } else {
                    
                    echo '<p class="erro">Você não pode alterar as alternativas.</p>';
                    $queryAlternativa = NULL;
                }
            } else {
                
                $queryAlternativa = "INSERT INTO ALTERNATIVA (codQuestao, codAlternativa, textoAlternativa, correta) VALUES (?, ?, ?, ?)";
            }
            if($_POST['codTipoQuestao'] == "V"){
                if ($_POST['opcao_certa'] ==0){
                    if (isset($_GET['codquestao']) && $_GET['codquestao'] != "") {
                        $paramsAlternativa = array(
                            $value,
                            0,
                            $i
                        );
                    } else {
                        $paramsAlternativa = array(
                            $codQuestaoRecent,
                            $i,
                            $value,
                            0
                        );
                    }
                }else{
                    if (isset($_GET['codquestao']) && $_GET['codquestao'] != "") {
                        $paramsAlternativa = array(
                            $value,
                            1,
                            $i
                        );
                    } else {
                        $paramsAlternativa = array(
                            $codQuestaoRecent,
                            $i,
                            $value,
                            1
                        );
                    }

                }
            }
            else if($_POST['codTipoQuestao'] == "T"){
                if (isset($_GET['codquestao']) && $_GET['codquestao'] != "") {
                    $paramsAlternativa = array(
                        $value,
                        1,
                        $i
                    );
                } else {
                    $paramsAlternativa = array(
                        $codQuestaoRecent,
                        $i,
                        $value,
                        1
                    );
                }
            }
            else if ($_POST['opcao_certa'] == $i) {
                if (isset($_GET['codquestao']) && $_GET['codquestao'] != "") {
                    $paramsAlternativa = array(
                        $value,
                        1,
                        $i
                    );
                } else {
                    $paramsAlternativa = array(
                        $codQuestaoRecent,
                        $i,
                        $value,
                        1
                    );
                }
            } 

            else {
                if (isset($_GET['codquestao']) && $_GET['codquestao'] != "") {
                    $paramsAlternativa = array(
                        $value,
                        0,
                        $i
                    );
                } else {
                    $paramsAlternativa = array(
                        $codQuestaoRecent,
                        $i,
                        $value,
                        0
                    );
                }
            }
            if (isset($queryAlternativa) && $queryAlternativa != NULL) {
                $prepAlternativa   = odbc_prepare($connect, $queryAlternativa);
                $resultAlternativa = odbc_execute($prepAlternativa, $paramsAlternativa);
            }
            $i++;
        }
    }

    ?>