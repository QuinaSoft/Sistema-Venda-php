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

			$idprovedor = $_POST['id'];
			$proveedor  = $_POST['proveedor'];
			$contacto   = $_POST['contacto'];
			$telefone   = $_POST['telefone'];
			$direcao    = $_POST['direcao'];

			$sql_update = mysqli_query($conexao, "UPDATE proveedor
													  SET proveedor = '$proveedor',contacto = '$contacto',telefone='$telefone',
													  direcao='$direcao' 
													  WHERE codproveedor = '$idprovedor' ");

			if($sql_update){
				$alert='<p class="msg_save">Provedor atualizado corretamente.</p>';
			}else{
				$alert='<p class="msg_error">Erro ao atualizar proveedor.</p>';
			}
		}
	}

	//Mostrar Dados
	if(empty($_REQUEST['id']))
	{
		header('location: lista_provedor.php');
		mysqli_close($conexao);
	}
	$idprovedor = $_REQUEST['id'];

	$sql = mysqli_query($conexao, "SELECT * FROM proveedor WHERE codproveedor = $idprovedor and estatus = 1 ");
	mysqli_close($conexao);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_provedor.php');
	}else{

		while ($data = mysqli_fetch_array($sql)) {
			# code...
			$idprovedor = $data['codproveedor'];
			$proveedor 	= $data['proveedor'];
			$contacto   = $data['contacto'];
			$telefone   = $data['telefone'];
			$direcao    = $data['direcao'];
		}

	}

 ?>

 <!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php" ?>
	<title>Actualizar Provedor</title>
</head>
<body>
	<?php include "includes/header.php" ?>

	<section id="container">
		
		<div class="form_register">
			<h1>Actualizar provedor</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="POST">
				<input type="hidden" name="id" value="<?php echo $idprovedor ?>">
				<label for="proveedor">Proveedor</label>
				<input type="text" name="proveedor" id="proveedor" placeholder="Nome do proveedor" value="<?php echo $proveedor; ?>">
				<label for="contacto">Contacto</label>
				<input type="text" name="contacto" id="contacto" placeholder="Nome do contacto" value="<?php echo $contacto; ?>">
				<label for="telefone">Telefone</label>
				<input type="number" name="telefone" id="telefone" placeholder="Numero de telefone" value="<?php echo $telefone; ?>">
				<label for="direcao">Direção</label>
				<input type="text" name="direcao" id="direcao" placeholder="Direcao completa" value="<?php echo $direcao; ?>">
				<input type="submit" value="Actualizar proveedor" class="btn_save">

			</form>


		</div>

	</section>

	<?php include "includes/footer.php" ?>

</body>
</html>














