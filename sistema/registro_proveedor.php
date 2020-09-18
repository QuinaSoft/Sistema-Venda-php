<?php 
	
	session_start();

	if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2)
	{
		header("location: ./");
	}

	include "../conexao.php";

	if(!empty($_POST))
	{
		$alert='';
		if(empty($_POST['proveedor']) || empty($_POST['contacto']) || empty($_POST['telefone']) || empty($_POST['direcao']))
		{
			$alert='<p class="msg_error">Todos os campos  são obrigatorios.</p>';
		}else{

			$proveedor  = $_POST['proveedor'];
			$contacto = $_POST['contacto'];
			$telefone = $_POST['telefone'];
			$direcao = $_POST['direcao'];
			$usuario_id = $_SESSION['idUser'];

			$query_insert = mysqli_query($conexao,"INSERT INTO proveedor
											(proveedor,contacto,telefone,direcao,usuario_id) VALUES
											('$proveedor','$contacto','$telefone','$direcao','$usuario_id')");

			if($query_insert){
				$alert='<p class="msg_save">Proveedor guardado corretamente.</p>';
			}else{
				$alert='<p class="msg_error">Erro ao guardar proveedor.</p>';
			}
		}
		mysqli_close($conexao);
	}

 ?>

 <!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php" ?>
	<title>Registro Proveedor</title>
</head>
<body>
	<?php include "includes/header.php" ?>

	<section id="container">
		
		<div class="form_register">
			<h1>Registro proveedor</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="POST">
				<label for="proveedor">Proveedor</label>
				<input type="text" name="proveedor" id="proveedor" placeholder="Nome do proveedor">
				<label for="contacto">Contacto</label>
				<input type="text" name="contacto" id="contacto" placeholder="Nome do contacto">
				<label for="telefone">Telefone</label>
				<input type="number" name="telefone" id="telefone" placeholder="Numero de telefone">
				<label for="direcao">Direção</label>
				<input type="text" name="direcao" id="direcao" placeholder="Direcao completa">
				<input type="submit" value="Guardar proveedor" class="btn_save">

			</form>



		</div>

	</section>

	<?php include "includes/footer.php" ?>

</body>
</html>