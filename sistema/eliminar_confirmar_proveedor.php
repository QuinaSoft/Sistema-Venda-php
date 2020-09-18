<?php 

	session_start();
	if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2)
	{
		header("location: ./");
	}
	
	include "../conexao.php";

	if(!empty($_POST))
	{
		if(empty($_POST['idprovedor']))
		{
			header("location: lista_provedor.php");
			mysqli_close($conexao);
		}

		$idprovedor = $_POST['idprovedor'];

		//$query_delete = mysqli_query($conexao,"DELETE FROM proveedor WHERE codproveedor = '$idprovedor' ");

		$query_delete = mysqli_query($conexao,"UPDATE proveedor SET estatus = 0 WHERE codproveedor = $idprovedor");
		mysqli_close($conexao);
		if($query_delete){
			header("location: lista_provedor.php");
		}else{
			echo "Erro ao eliminar";
		}

	}



	if(empty($_REQUEST['id']) )
	{
		header("location: lista_provedor.php");
		mysqli_close($conexao);
	}else{

		$idprovedor = $_REQUEST['id'];

		$query = mysqli_query($conexao,"SELECT * FROM proveedor WHERE codproveedor = $idprovedor ");
		mysqli_close($conexao);
		$result = mysqli_num_rows($query);

		if($result > 0){
			while ($data = mysqli_fetch_array($query)) {
				# code...
				$proveedor = $data['proveedor'];
			}
		}else{
			header("location: lista_provedor.php");
		}


	}



 ?>

 <!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php" ?>
	<title>Eliminar Provedor</title>
</head>
<body>
	<?php include "includes/header.php"; ?>

	<section id="container">
		
		<div class="data_delete">
			<h2>Tens certeza que pretendes eliminar o seguinte registro?</h2>
			<p>Nome do provedor: <span><?php echo $proveedor; ?></span></p>

			<form method="POST" action="">
				<input type="hidden" name="idprovedor" value="<?php echo $idprovedor; ?>">
				<a href="lista_provedor.php" class="btn_cancel">Cancelar</a>
				<input type="submit" value="Eliminar" class="btn_ok">
			</form>
		</div>


	</section>

	<?php include "includes/footer.php"; ?>

</body>
</html>
