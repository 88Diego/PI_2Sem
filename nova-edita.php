<?php

include_once('session.php');

?>


<?php
if (isset($_GET['codquestao'])) {
    $idQuestao        = $_GET['codquestao'];
    $queryQuestao     = "SELECT * FROM questao LEFT JOIN imagem ON (questao.codImagem = imagem.codImagem) WHERE codQuestao = " . $idQuestao . "";
    $queryAlternativa = "SELECT q.codQuestao, q.textoQuestao, q.codAssunto, q.codTipoQuestao, a.textoAlternativa, a.correta FROM questao Q INNER JOIN alternativa A ON q.codQuestao = a.codQuestao";
    $arrayQuestao     = odbc_exec($connect, $queryQuestao);
    odbc_binmode($arrayQuestao, ODBC_BINMODE_RETURN);
    odbc_longreadlen($arrayQuestao, 90000000);
    $arrayAlternativas = odbc_exec($connect, $queryAlternativa);
    $opcao_certa       = null;
    
    while ($linhasQuestao = odbc_fetch_array($arrayQuestao)) {
        $textoQuestao   = utf8_encode($linhasQuestao['textoQuestao']);
        $codAssunto     = $linhasQuestao['codAssunto'];
        $imageData      = base64_encode($linhasQuestao['bitmapImagem']);
        $codTipoQuestao = $linhasQuestao['codTipoQuestao'];
        $id_professor   = $linhasQuestao['codProfessor'];
        $dificuldade    = $linhasQuestao['dificuldade'];
    }
    
    while ($linhasAlternativas = odbc_fetch_array($arrayAlternativas)) {
        $codQuestaoAlter     = $linhasAlternativas['codQuestao'];
        $codAssuntoAlter     = $linhasAlternativas['codAssunto'];
        $codTipoQuestaoAlter = $linhasAlternativas['codTipoQuestao'];
        $correta             = $linhasAlternativas['correta'];
    }
    
} else {
    $textoQuestao   = NULL;
    $codAssunto     = NULL;
    $codTipoQuestao = NULL;
    $textoQuestao   = NULL;
    $imageData      = NULL;
    $dificuldade    = NULL;
}
?>

<?php

$condition = (isset($_GET['codquestao'])) ? '&codquestao='.$_GET['codquestao'] : "";

?>

<form action=<?php echo 'admin.php?page=salva-form' . $condition . ''; ?> enctype="multipart/form-data" method="post" id="novo-edita" >
	<!-- <input type="hidden" id="id_questao" value="<?php
echo $idQuestao;
?>"> -->
    <label for="assunto">
	    <?php
		$queryAssunto     = "SELECT codAssunto, descricao FROM assunto ORDER BY descricao";
		$resultadoAssunto = odbc_exec($connect, $queryAssunto);
		?>
		Assunto da Questão:
		<select name="codAssunto" id="assunto" class="form-control" required>
			<option value="">Selecione o Assunto</option>
			<?php
				while ($opcoesAssunto = odbc_fetch_array($resultadoAssunto)) {
				?>
	                <option value="<?php echo $opcoesAssunto['codAssunto']; ?>" 
	                	<?= ($opcoesAssunto['codAssunto'] == $codAssunto) ? "selected" : "" ?> >
	                	<?php echo utf8_encode($opcoesAssunto['descricao']); ?>
	                </option>
			<?php
				}
			?>
		</select>
	</label>

	<label for="tipoQuestao">
		Tipo da Questão:
		<?php
			$consultQuestao = "SELECT codTipoQuestao, descricao FROM tipoQuestao ORDER BY descricao";
			$resultQuestao  = odbc_exec($connect, $consultQuestao);
		?>
		<select name="codTipoQuestao" id="tipoQuestao" class="form-control" required>
			<option value="">Selecione o Tipo da Questão</option>
			<?php
while ($tipoQuestao = odbc_fetch_array($resultQuestao)) {
?>
	            <option value="<?php
    echo $tipoQuestao['codTipoQuestao'];
?>" <?= strtoupper($tipoQuestao['codTipoQuestao']) == (strtoupper($codTipoQuestao)) ? "selected" : "" ?> ><?php
    echo $tipoQuestao['descricao'];
?></option>

	    <?php
}
?>
	    </select>
	</label>

	<label for="dificuldade">
		Dificuldade da Questão:
		<select name="dificuldade" id="dificuldade" class="form-control" required>
			<option value="">Selecione a Dificuldade</option>
			<option value="F" <?= (($dificuldade == "F") || ($dificuldade == "f")) ? "selected" : "" ?>>Fácil</option>
			<option value="M" <?= (($dificuldade == "M") || ($dificuldade == "m")) ? "selected" : "" ?>>Médio</option>
			<option value="D" <?= (($dificuldade == "D") || ($dificuldade == "d")) ? "selected" : "" ?>>Difícil</option>
			
		</select>
	</label>

	<label for="txQuestao">
		Título da Questão:
		<input type="text" id="txQuestao" name="txQuestao" class="form-control" required value="<?= (isset($textoQuestao)) ? "$textoQuestao" : "" ?>">
	</label>
	
	<label for="alternativas" id="alternativas" style="display: none;">
		Alternativas:	
		<div class="verdadeiro_falso dft" <?php
			if (!isset($_GET['codquestao'])) {
			    echo 'style=display:none;';
			}
			?>>
			<?php
			if (isset($_GET['codquestao']) && !is_null($_GET['codquestao'])) {
			    $consultAlternativa = "SELECT * FROM alternativa WHERE codQuestao = " . $_GET['codquestao'] . " ORDER BY codAlternativa";
			    $resultAlternativa  = odbc_exec($connect, $consultAlternativa);

			    while ($alternativas = odbc_fetch_array($resultAlternativa)) {

			        $opcao_certa = ($alternativas['correta']) ? $alternativas['codAlternativa'] : $opcao_certa;
			        $str_checked = $alternativas['correta'] ? 'true' : '';
			        
			        echo ('<input class="check_certa" value="' . $alternativas['correta'] . '" ' . $str_checked . ' type="hidden" data-index="' . $alternativas['codAlternativa'] . '" name="alternativacerta" />');
			        
			    }

			    $conditionV = ($opcao_certa == 1)?"checked":"";
			    $conditionF = ($opcao_certa == 0)?"checked":"";

			    echo ('<input type="radio" name="alternativas[]" value="1" '.$conditionV.'> Verdadeiro');
			    echo ('<input type="radio" name="alternativas[]" value="0" '.$conditionF.'> Falso');
			    

			} else {
			    echo ('<input type="radio" name="alternativas[]" value="1"> Verdadeiro');
			    echo ('<input type="radio" name="alternativas[]" value="0"> Falso');
			}
			?>
		</div>

		<div class="alternativas dft" <?php
			if (!isset($_GET['codquestao'])) {
			    echo 'style=display:none;';
			}
			?>>
			<?php
				if (isset($_GET['codquestao']) && !is_null($_GET['codquestao'])) {

				    $consultAlternativa = "SELECT * FROM alternativa WHERE codQuestao = " . $_GET['codquestao'] . " ORDER BY codAlternativa";
				    $resultAlternativa  = odbc_exec($connect, $consultAlternativa);
				    
				    while ($alternativas = odbc_fetch_array($resultAlternativa)) {
				        $opcao_certa = ($alternativas['correta']) ? $alternativas['codAlternativa'] : $opcao_certa;
				        $str_checked = $alternativas['correta'] ? 'checked' : '';
				        echo ('<input type="text" name="alternativas[]" class="form-control" value="' . $alternativas['textoAlternativa'] . '" /><input class="check_certa" value="' . $alternativas['correta'] . '" ' . $str_checked . ' type="radio" data-index="' . $alternativas['codAlternativa'] . '" name="alternativacerta" />');
				        
				    }
				}
				?>
			
			<a href="javascript:void(0)" class="add alternativas" title="Adicionar Campo">Adicionar Campo</a>
			<a href="javascript:void(0)" class="deleteOpc" title="Remover Campo">Remover Campo</a>
		</div>

		<div class="texto_objetivo dft" <?php
			if (!isset($_GET['codquestao'])) {
			    echo 'style=display:none;';
			}
			?>>
			<?php
			if (isset($_GET['codquestao']) && !is_null($_GET['codquestao'])) {
				    $consultAlternativa = "SELECT * FROM alternativa WHERE codQuestao = " . $_GET['codquestao'] . " ORDER BY codAlternativa";
				    $resultAlternativa  = odbc_exec($connect, $consultAlternativa);
				    while ($alternativas = odbc_fetch_array($resultAlternativa)) {
				        // $opcao_certa = 1;
				        echo ('<input type="text" name="alternativas[]" class="form-control" value="' . $alternativas['textoAlternativa'] . '" />');
				        
				    }
				}
				?>
			
			<a href="javascript:void(0)" class="add texto_objetivo">Adicionar Campo</a>
			<a href="javascript:void(0)" class="deleteOpc">Remover Campo</a>
		</div>		
		<input type="hidden" value="<?php
		echo $opcao_certa;
		?>" name="opcao_certa" class="opcao_certa" >		
	</label>

    <label for="imagem">
		Imagem da Questão:				
		<?php
		if (!empty($imageData)) {
		    echo "<img width=\"50\" height=\"50\" src=\"data:image/jpeg;base64," . $imageData . "\">";
		}
		?>
		<input type="file" id="imagem" name="imagem">
	</label>	

	<input type="submit" value="Salvar" class="btn btn-default">
	

</form>
<script>
	$(document).ready(function(){

		var i = 0;

		if($('#tipoQuestao').val() != ""){
			i = 0;
			if($('#tipoQuestao').val() == "A"){
				$('.opcao_certa').val("");
				$('.dft').hide();
				$('#alternativas, .alternativas').show();
			} else if($('#tipoQuestao').val() == "T"){
				$('.opcao_certa').val("");
				$('.dft').hide();
				$('#alternativas, .text_objetivo').show();
			} else{
				$('.opcao_certa').val("");
				$('.dft').hide();
				$('#alternativas, .verdadeiro_falso').show();
			}
		}

		$('#tipoQuestao').on('change', function(){			
			i = 0;
			if(this.value == "A"){
				$('.opcao_certa').val("");
				$('.dft').hide();
				$('.alternativas input').remove();
				$('#alternativas, .alternativas').show();
			} else if(this.value == "T"){
				$('.opcao_certa').val("");
				$('.dft').hide();
				$('.texto_objetivo input').remove();
				$('#alternativas, .texto_objetivo').show();
			} else{
				$('.opcao_certa').val("");
				$('.dft').hide();
				$('#alternativas, .verdadeiro_falso').show();
			}
		});

		

		$('#alternativas a').on('click', function(){
		
			if ($(this).hasClass('add')) {
				i++;
				if($(this).hasClass('alternativas')){
					$(this).parent().prepend('<input type="text" name="alternativas[]" class="form-control" value="<?= (isset($txAlternativas)) ? "echo $txAlternativas;" : "" ?>"><input class="check_certa" type="radio" data-index="'+ i + '" name="alternativacerta">');

				} else{
					$(this).parent().prepend('<input type="text" name="alternativas[]" class="form-control" value="<?= (isset($txObjetivo)) ? "echo $txObjetivo;" : "" ?>">');
					$('.opcao_certa').val('1');
				}							
			} else {				
				$(this).parent().children('input').eq(0).remove();
				$(this).parent().children('input').eq(0).remove();
				i--;
			}
		});

		$('.alternativas').on('change', 'input[type=radio]', function(){
			console.log($(this).data('index'));
			$('.opcao_certa').val($(this).data('index'));
		});
		$('.verdadeiro_falso').on('change', 'input[type=radio]', function(){
			$('.opcao_certa').val($(this).val());
		});
	});
</script>