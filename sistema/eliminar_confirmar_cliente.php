<?php 
	
	session_start();
	if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2)
	{
		header("location: ./");
	}
	
	include "../conexao.php";

	if(!empty($_POST))
	{
		if(empty($_POST['idcliente']))
		{
			header("location: lista_clientes.php");
			mysqli_close($conexao);
		}

		$idcliente = $_POST['idcliente'];

		//$query_delete = mysqli_query($conexao,"DELETE FROM cliente WHERE id = '$id' ");

		$query_delete = mysqli_query($conexao,"UPDATE cliente SET estatus = 0 WHERE idcliente = $idcliente");
		mysqli_close($conexao);
		if($query_delete){
			header("location: lista_clientes.php");
		}else{
			echo "Erro ao eliminar";
		}

	}

	if(empty($_REQUEST['id']) )
	{
		header("location: lista_clientes.php");
		mysqli_close($conexao);
	}else{

		$idcliente = $_REQUEST['id'];

		$query = mysqli_query($conexao,"SELECT * FROM cliente WHERE idcliente = $idcliente ");
		mysqli_close($conexao);
		$result = mysqli_num_rows($query);

		if($result > 0){
			while ($data = mysqli_fetch_array($query)) {
				# code...
				$nif  = $data['nif'];
				$nome = $data['nome'];
			}
		}else{
			header("location: lista_clientes.php");
		}


	}
 ?>

 <!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php" ?>
	<title>Eliminar Cliente</title>
</head>
<body>
	<?php include "includes/header.php"; ?>

	<section id="container">
		
		<div class="data_delete">
			<h2>Tens certeza que pretendes eliminar o seguinte registro?</h2>
			<p>Nome do cliente: <span><?php echo $nome; ?></span></p>
			<p>nif: <span><?php echo $nif; ?></span></p>

			<form method="POST" action="">
				<input type="hidden" name="idcliente" value="<?php echo $idcliente; ?>">
				<a href="lista_clientes.php" class="btn_cancel">Cancelar</a>
				<input type="submit" value="Eliminar" class="btn_ok">
			</form>
		</div>


	</section>

	<?php include "includes/footer.php"; ?>

</body>
</html>
