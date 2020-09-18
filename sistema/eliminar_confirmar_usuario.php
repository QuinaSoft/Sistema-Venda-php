<?php 
	session_start();
	if($_SESSION['rol'] != 1)
	{
		header("location: ./");
	}
	include "../conexao.php";

	if(!empty($_POST))
	{
		if($_POST['id'] == 1){
			header("location: lista_usuarios.php");
			mysqli_close($conexao);
			exit;
		}
		$id = $_POST['id'];

		//$query_delete = mysqli_query($conexao,"DELETE FROM usuario WHERE id = $id ");
		$query_delete = mysqli_query($conexao,"UPDATE usuario SET estatus = 0 WHERE id = $id ");
		mysqli_close($conexao);

		if($query_delete){
			header('location: lista_usuarios.php');
		}else{
			echo "Erro ao eliminar";
		}

	}

	if(empty($_REQUEST['id']) || $_REQUEST['id'] ==1)
	{
		header("location: lista_usuarios.php");
		mysqli_close($conexao);
	}else{

		$id = $_REQUEST['id'];

		$query = mysqli_query($conexao,"SELECT u.nome,u.usuario,r.rol
										 FROM usuario u
										 INNER JOIN 
										 rol r
										 ON u.rol = r.idrol
										 WHERE u.id = $id ");

		mysqli_close($conexao);
		$result = mysqli_num_rows($query);

		if($result > 0){
			while ($data = mysqli_fetch_array($query)) {
				# code...
				$nome = $data['nome'];
				$usuario = $data['usuario'];
				$rol = $data['rol'];
			}
		}else{
			header("location: lista_usuarios.php");
		}

	}


 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Eliminar Usuario</title>
</head>
<body>

	<?php include "includes/header.php"; ?>

	<section id="container">
		<div class="data_delete">
			<h2>Estais seguro que pretendes eliminar o seguinte registro?</h2>
			<p>Nome: <span><?php echo $nome; ?></span></p>
			<p>Usuario: <span><?php echo $usuario; ?></span></p>
			<p>Tipo Usuario: <span><?php echo $rol; ?></span></p>

			<form action="" method="post">
				<input type="hidden" name="id" value="<?php echo $id; ?>">
				<a href="lista_usuarios.php" class="btn_cancel">Cancelar</a>
				<input type="submit" value="Aceitar" class="btn_ok">
			</form>
		</div>


	</section>

	<?php include "includes/footer.php"; ?>

</body>
</html>