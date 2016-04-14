<?php 

session_start();

if(isset($_GET['logout']) && $_GET['logout'] == "1" ) {
  session_destroy();
  header('Location: index.php');
  exit;
}



// if(__FILE__ != "index.php" && !isset($_SESSION['codProfessor'])) {
// 	echo "Acesso negado.";
// 	exit;
// 	// header('Location: index.php');
// 	$_SESSION['msgError'] = NULL;
// }

?>