<?php 

	if(empty($_SESSION['active']))
	{
		header('location: ../');
	}

 ?>

<header>
	<div class="header">
		<h1>Sistema de facturação</h1>
		<div class="optionsBar">
			<p>Angola|Luanda, <?php echo fechaC(); ?></p>
			<span>|</span>
			<span class="user"><?php echo $_SESSION['user'].' -'.$_SESSION['rol'].' - '.$_SESSION['email']; ?></span>
			<img class="photouser" src="img/user.png" alt="Usuario">
			<a href="sair.php"><img src="img/sair.png" alt="sair do sistema" title="sair"></a>
		</div>
	</div>

	<?php include "nav.php"; ?>

</header>
