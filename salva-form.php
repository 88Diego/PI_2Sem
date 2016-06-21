<?php
//pagina para salvar os dados da questão passada no formulario
include_once('session.php');

?>


<?php


include('conexao.php');

$textoQuestao = utf8_encode($_POST['txQuestao']);

$codQuestaoRecent = "";

if ($_FILES['imagem']['size'] > 0) {//verificação se existe imagem
    
    $fileName = $_FILES['imagem']['name'];
    $tmpName  = $_FILES['imagem']['tmp_name'];
    $fileSize = $_FILES['imagem']['size'];
    $fileType = $_FILES['imagem']['type'];
    
  
    
    $fp      = fopen($tmpName, 'rb');
    $content = fread($fp, filesize($tmpName));
    fclose($fp);
    
    if (isset($_GET['codquestao']) && $_GET['codquestao'] != "") {//verifica se esta sendo feita uma edição

        
        $queryTipoPr  = "SELECT * FROM questao WHERE codQuestao = " . $_GET['codquestao'] . "";
        $tipoPr       = odbc_exec($connect, $queryTipoPr);
        $linhasTipoPr = odbc_fetch_array($tipoPr);
        
        if ($_SESSION['codProfessor'] == $linhasTipoPr['codProfessor'] || $_SESSION['tipoProfessor'] == 'A') {//verifica se o professor pode fazer a edição

            
            
            $queryQuestao  = "SELECT imagem.codImagem FROM questao LEFT JOIN imagem ON (questao.codImagem = imagem.codImagem) WHERE codQuestao = " . $_GET['codquestao'] . "";
            $questao       = odbc_exec($connect, $queryQuestao);
            $linhasQuestao = odbc_fetch_array($questao);
            
            
            if (!isset($linhasQuestao['codImagem'])) {//verifica se não existe imagem vinculada a questão em edição
                
                
                $queryImg = "INSERT INTO imagem (tituloImagem, bitmapImagem) output INSERTED.codImagem VALUES (? , ?)";//query da imagem
                
                $paramsImg = array(
                    $fileName,
                    $content
                );//parametros da imagem
                
                
                $prepImg   = odbc_prepare($connect, $queryImg);//função de inserção no banco de acordo com a query
                $resultImg = odbc_execute($prepImg, $paramsImg);//função de finalização da função de inserção de acordo com os dados do paramentro da imagem
                
                $resultCodImagemScope = odbc_fetch_array($prepImg);
                
                
                $queryQuestao = "UPDATE questao SET textoQuestao = '" . $textoQuestao . "', codAssunto = " . $_POST['codAssunto'] . ", codImagem = " . $resultCodImagemScope['codImagem'] . ",codTipoQuestao = '" . $_POST['codTipoQuestao'] . "', codProfessor = " . $_SESSION['codProfessor'] . ", ativo = 1, dificuldade = '" . $_POST['dificuldade'] . "' WHERE codQuestao = " . $_GET['codquestao'] . "";//query de update da questão
                
                
                
            } else {
                
                $idImagem = $linhasQuestao['codImagem'];
                
                $queryImg = "UPDATE IMAGEM SET tituloImagem = ?, bitmapImagem = ? WHERE codImagem = " . $idImagem . "";
                
                
                $paramsImg = array(
                    $fileName,
                    $content
                );//parametros da imagem
                
                
                $prepImg   = odbc_prepare($connect, $queryImg);//função de update no banco de acordo com a query
                $resultImg = odbc_execute($prepImg, $paramsImg);//função de finalização da função de update de acordo com os dados do paramentro da imagem
                
                
                $queryQuestao = "UPDATE questao SET textoQuestao = '" . $textoQuestao . "', codAssunto = " . $_POST['codAssunto'] . ", codTipoQuestao = '" . $_POST['codTipoQuestao'] . "', codProfessor = " . $_SESSION['codProfessor'] . ", ativo = 1, dificuldade = '" . $_POST['dificuldade'] . "' WHERE codQuestao = " . $_GET['codquestao'] . "";
                //query de update da questão
            }
            
            
            
            $resultQuestao = odbc_exec($connect, $queryQuestao);//função de update no banco de acordo com a query
            echo '<p id="textos">Questão Salva.</p>';
            
        } else {
            echo '<p class="erro">Você não pode editar essa questão.';
        }
        
        
    } else {
        
        
        $queryImg = "INSERT INTO imagem (tituloImagem, bitmapImagem) output INSERTED.codImagem VALUES (? , ?)";//query de inserção da imagem no banco
        
        $paramsImg = array(
            $fileName,
            $content
        );// parametros da imagem

        $prepImg   = odbc_prepare($connect, $queryImg);//função de inserção no banco de acordo com a query
        $resultImg = odbc_execute($prepImg, $paramsImg);//função de finalização da função de inserção de acordo com os dados do paramentro da imagem
        
        $resultCodImagemScope = odbc_fetch_array($prepImg);


        $queryQuestao          = "INSERT INTO QUESTAO (textoQuestao, codAssunto, codImagem, codTipoQuestao, codProfessor, ativo, dificuldade ) output INSERTED.codQuestao VALUES (?,?, ?, ?, ?, ?, ?)";//query de inserção da questão no banco

        $paramsQuestao         = array(
            $textoQuestao,
            $_POST['codAssunto'],
            $resultCodImagemScope['codImagem'],
            $_POST['codTipoQuestao'],
            $_SESSION['codProfessor'],
            1,
            $_POST['dificuldade']
        );//paramentros da questão

        $prepQuestao           = odbc_prepare($connect, $queryQuestao);//função de inserção no banco de acordo com a query
        $resultQuestao         = odbc_execute($prepQuestao, $paramsQuestao);//função de finalização da função de inserção de acordo com os dados do paramentro da questão
        $resultCodQuestaoScope = odbc_fetch_array($prepQuestao);


        $_GET['codquestao'] = $resultCodQuestaoScope['codQuestao'];

        echo '<p id="textos">Questão Salva.</p>';

    }   
    include('envia-alternativas.php');
    
    
} else {

    
    if (isset($_GET['codquestao']) && $_GET['codquestao'] != "") {//verifica se esta sendo feita uma edição da questão

        
        
        $queryTipoPr  = "SELECT * FROM questao WHERE codQuestao = " . $_GET['codquestao'] . "";
        $tipoPr       = odbc_exec($connect, $queryTipoPr);
        $linhasTipoPr = odbc_fetch_array($tipoPr);
        
        if ($_SESSION['codProfessor'] == $linhasTipoPr['codProfessor'] || $_SESSION['tipoProfessor'] == 'A') {//verifica se o professor pode editar a questão


            $queryQuestao = "UPDATE questao SET textoQuestao = '" . $textoQuestao . "', codAssunto = " . $_POST['codAssunto'] . ", codTipoQuestao = '" . $_POST['codTipoQuestao'] . "', codProfessor = " . $_SESSION['codProfessor'] . ", ativo = 1, dificuldade = '" . $_POST['dificuldade'] . "' WHERE codQuestao = " . $_GET['codquestao'] . "";
            
            
            $resultQuestao = odbc_exec($connect, $queryQuestao);//função de update no banco de acordo com a query
            echo '<p id="textos">Questão Salva.</p>';
        } else {
            echo '<p class="erro">Você não pode editar essa questão.';
        }
        
    }
    
    else {
        $queryQuestao          = "INSERT INTO QUESTAO (textoQuestao, codAssunto, codTipoQuestao, codProfessor, ativo, dificuldade ) output INSERTED.codQuestao VALUES (?, ?, ?, ?, ?, ?)";
        $paramsQuestao         = array(
            $textoQuestao,
            $_POST['codAssunto'],
            $_POST['codTipoQuestao'],
            $_SESSION['codProfessor'],
            1,
            $_POST['dificuldade']
        );
        $prepQuestao           = odbc_prepare($connect, $queryQuestao);//função de inserção no banco de acordo com a query
        $resultQuestao         = odbc_execute($prepQuestao, $paramsQuestao);//função de finalização da função de inserção de acordo com os dados do paramentro da questão
        $resultCodQuestaoScope = odbc_fetch_array($prepQuestao);


        $_GET['codquestao'] = $resultCodQuestaoScope['codQuestao'];


        echo '<p id="textos">Questão Salva.</p>';
        
    }
    
    
    include('envia-alternativas.php');
}



?>
