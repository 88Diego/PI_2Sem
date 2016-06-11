<?php

include_once('session.php');

?>



<div id="textos">
Questão Salva
</div>
<?php

// include('session.php');

include('conexao.php');

// INSERT INTO QUESTAO (textoQuestao, codAssunto, codImagem, codTipoQuestao, codProfessor, ativo, dificuldade )
// VALUES (
// 'Teste 4',
// '1',
// NULL,
// 'A',
// '1',
// '1',
// '1'
// )

if ($_FILES['imagem']['size'] > 0) {
    
    $fileName = $_FILES['imagem']['name'];
    $tmpName  = $_FILES['imagem']['tmp_name'];
    $fileSize = $_FILES['imagem']['size'];
    $fileType = $_FILES['imagem']['type'];
    
    
    
    $fp      = fopen($tmpName, 'r');
    $content = fread($fp, filesize($tmpName));
    fclose($fp);
    
    if (isset($_GET['codquestao']) && $_GET['codquestao'] != "") {
        
        $queryTipoPr  = "SELECT * FROM questao WHERE codQuestao = " . $_GET['codquestao'] . "";
        $tipoPr       = odbc_exec($connect, $queryTipoPr);
        $linhasTipoPr = odbc_fetch_array($tipoPr);
        
        if ($_SESSION['codProfessor'] == $linhasTipoPr['codProfessor'] || $_SESSION['tipoProfessor'] == 'A') {
            
            
            $queryQuestao  = "SELECT * FROM questao LEFT JOIN imagem ON (questao.codImagem = imagem.codImagem) WHERE codQuestao = " . $_GET['codquestao'] . "";
            $questao       = odbc_exec($connect, $queryQuestao);
            $linhasQuestao = odbc_fetch_array($questao);
            
            
            if (!isset($linhasQuestao['codImagem'])) {
                
                
                $queryImg = "INSERT INTO imagem (tituloImagem, bitmapImagem) output INSERTED.codImagem VALUES (? , ?)";
                
                $paramsImg = array(
                    $fileName,
                    $content
                );
                
                
                $prepImg   = odbc_prepare($connect, $queryImg);
                $resultImg = odbc_execute($prepImg, $paramsImg);
                
                $resultCodImagemScope = odbc_fetch_array($prepImg);
                
                
                $queryQuestao = "UPDATE questao SET textoQuestao = '" . $_POST['txQuestao'] . "', codAssunto = " . $_POST['codAssunto'] . ", codImagem = " . $resultCodImagemScope['codImagem'] . ",codTipoQuestao = '" . $_POST['codTipoQuestao'] . "', codProfessor = " . $_SESSION['codProfessor'] . ", ativo = 1, dificuldade = '" . $_POST['dificuldade'] . "' WHERE codQuestao = " . $_GET['codquestao'] . "";
                
                
                
            } else {
                
                $idImagem = $linhasQuestao['codImagem'];
                
                $queryImg = "UPDATE IMAGEM SET tituloImagem = ?, bitmapImagem = ? WHERE codImagem = " . $idImagem . "";
                
                
                $paramsImg = array(
                    $fileName,
                    $content
                );
                
                
                $prepImg   = odbc_prepare($connect, $queryImg);
                $resultImg = odbc_execute($prepImg, $paramsImg);
                
                
                $queryQuestao = "UPDATE questao SET textoQuestao = '" . $_POST['txQuestao'] . "', codAssunto = " . $_POST['codAssunto'] . ", codTipoQuestao = '" . $_POST['codTipoQuestao'] . "', codProfessor = " . $_SESSION['codProfessor'] . ", ativo = 1, dificuldade = '" . $_POST['dificuldade'] . "' WHERE codQuestao = " . $_GET['codquestao'] . "";
                
            }
            
            
            
            $resultQuestao = odbc_exec($connect, $queryQuestao);
            
        } else {
            echo '<p class="erro">Você não pode editar essa questão.';
        }
        
        
    } else {
        
        
        $queryImg = "INSERT INTO imagem (tituloImagem, bitmapImagem) VALUES (? , ?)";
        
        $paramsImg = array(
            $fileName,
            $content
        );
        $prepImg   = odbc_prepare($connect, $queryImg);
        $resultImg = odbc_execute($prepImg, $paramsImg);
        
        $queryQuestao          = "INSERT INTO QUESTAO (textoQuestao, codAssunto, codImagem, codTipoQuestao, codProfessor, ativo, dificuldade ) output INSERTED.codQuestao VALUES (?,?, IDENT_CURRENT( 'IMAGEM' ), ?, ?, ?, ?)";
        $paramsQuestao         = array(
            $_POST['txQuestao'],
            $_POST['codAssunto'],
            $_POST['codTipoQuestao'],
            $_SESSION['codProfessor'],
            1,
            $_POST['dificuldade']
        );
        $prepQuestao           = odbc_prepare($connect, $queryQuestao);
        $resultQuestao         = odbc_execute($prepQuestao, $paramsQuestao);
        $resultCodQuestaoScope = odbc_fetch_array($prepQuestao);
    }
    
    $i = 1;
    
    if (isset($_POST['alternativas'])) {
        foreach ($_POST['alternativas'] as $key => $value) {
            
            
            if (isset($_GET['codquestao']) && $_GET['codquestao'] != "") {
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
            
            
            if ($_POST['opcao_certa'] == $i) {
                if (isset($_GET['codquestao']) && $_GET['codquestao'] != "") {
                    $paramsAlternativa = array(
                        $value,
                        1,
                        $i
                    );
                } else {
                    $paramsAlternativa = array(
                        $resultCodQuestaoScope['codQuestao'],
                        $i,
                        $value,
                        1
                    );
                }
            } else {
                if (isset($_GET['codquestao']) && $_GET['codquestao'] != "") {
                    $paramsAlternativa = array(
                        $value,
                        0,
                        $i
                    );
                } else {
                    $paramsAlternativa = array(
                        $resultCodQuestaoScope['codQuestao'],
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
    
} else {
    
    if (isset($_GET['codquestao']) && $_GET['codquestao'] != "") {
        
        
        $queryTipoPr  = "SELECT * FROM questao WHERE codQuestao = " . $_GET['codquestao'] . "";
        $tipoPr       = odbc_exec($connect, $queryTipoPr);
        $linhasTipoPr = odbc_fetch_array($tipoPr);
        
        if ($_SESSION['codProfessor'] == $linhasTipoPr['codProfessor'] || $_SESSION['tipoProfessor'] == 'A') {
            $queryQuestao = "UPDATE questao SET textoQuestao = '" . $_POST['txQuestao'] . "', codAssunto = " . $_POST['codAssunto'] . ", codTipoQuestao = '" . $_POST['codTipoQuestao'] . "', codProfessor = " . $_SESSION['codProfessor'] . ", ativo = 1, dificuldade = '" . $_POST['dificuldade'] . "' WHERE codQuestao = " . $_GET['codquestao'] . "";
            
            
            $resultQuestao = odbc_exec($connect, $queryQuestao);
        } else {
            echo '<p class="erro">Você não pode editar essa questão.';
        }
        
    }
    
    else {
        $queryQuestao          = "INSERT INTO QUESTAO (textoQuestao, codAssunto, codTipoQuestao, codProfessor, ativo, dificuldade ) output INSERTED.codQuestao VALUES (?, ?, ?, ?, ?, ?)";
        $paramsQuestao         = array(
            $_POST['txQuestao'],
            $_POST['codAssunto'],
            $_POST['codTipoQuestao'],
            $_SESSION['codProfessor'],
            1,
            $_POST['dificuldade']
        );
        $prepQuestao           = odbc_prepare($connect, $queryQuestao);
        $resultQuestao         = odbc_execute($prepQuestao, $paramsQuestao);
        $resultCodQuestaoScope = odbc_fetch_array($prepQuestao);
        
    }
    
    $i = 1;
    
    if (isset($_POST['alternativas'])) {
        foreach ($_POST['alternativas'] as $key => $value) {
            
            
            if (isset($_GET['codquestao']) && $_GET['codquestao'] != "") {
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
            
            
            if ($_POST['opcao_certa'] == $i) {
                if (isset($_GET['codquestao']) && $_GET['codquestao'] != "") {
                    $paramsAlternativa = array(
                        $value,
                        1,
                        $i
                    );
                } else {
                    $paramsAlternativa = array(
                        $resultCodQuestaoScope['codQuestao'],
                        $i,
                        $value,
                        1
                    );
                }
            } else {
                if (isset($_GET['codquestao']) && $_GET['codquestao'] != "") {
                    $paramsAlternativa = array(
                        $value,
                        0,
                        $i
                    );
                } else {
                    $paramsAlternativa = array(
                        $resultCodQuestaoScope['codQuestao'],
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
}

?>
