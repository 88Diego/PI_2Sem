<?php
session_start();
?>	
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<link rel="stylesheet" type="text/css" href="assets/css/login.css" />
</head>
<body>	
<div class="container">
	<section id="content">
		<form action="banco.php" method="post">
			<h1>Login</h1>				
			<div>
				<input type="text" placeholder="Username" required id="username" name="username"/>
			</div>
			<div>
				<input type="password" placeholder="Password" required id="password" name="password" />
			</div>			
			<div>
				<p class="error">
					<?php  
						if (isset($_SESSION['msgError']) && $_SESSION['msgError'] != NULL) {	
							echo $_SESSION['msgError'];
						}						
					?>
				</p>
			</div>			
			<div>
				<input type="submit" value="Logar" />
			</div>
		</form>		
	</section>
</div>
</body>
</html>