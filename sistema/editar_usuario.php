<?php
	session_start();
	if($_SESSION['rol'] != 1)
	{
		header("location: ./");
	}
	include "../conexao.php";

	if(!empty($_POST)) 
	{
		$alert = '';
		if(empty($_POST['nome']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['rol']))
		{
			$alert='<p class="msg_error">Todos os campos são obrigatorios!</p>';
		}else{

			$id    = $_POST['id'];
			$nome  = $_POST['nome'];
			$correo = $_POST['correo'];
			$user  = $_POST['usuario'];
			$senha = md5($_POST['senha']);
			$rol   = $_POST['rol'];

			$query = mysqli_query($conexao,"SELECT * FROM usuario 
													 WHERE (usuario = '$user' AND id != $id) 
													 OR (correo = '$correo' AND id != $id) ");

			$result = mysqli_fetch_array($query);

			if($result > 0){
				$alert='<p class="msg_error">O usuario já existe!</p>';
			}else{

				if(empty($_POST['senha']))
				{
					$sql_update = mysqli_query($conexao,"UPDATE usuario
													     SET nome='$nome',correo='$correo',usuario='$user',rol='$rol' 
													     WHERE id = $id ");
				}else{

					$sql_update = mysqli_query($conexao,"UPDATE usuario
													     SET nome='$nome',correo='$correo',usuario='$user',clave='$senha',rol='$rol' 
													     WHERE id = $id ");
				}
				if($sql_update){
					$alert='<p class="msg_save">O usuario atualizado corretamente!</p>';
				}else{
					$alert='<p class="msg_error">Erro ao atualizar o usuario!</p>';
				}

			}

		}
		mysqli_close($conexao);
		
	}

	//Mostrar Dados
	if(empty($_GET['id']))
	{
		header('Location: lista_usuarios.php');
		mysqli_close($conexao);
	}
	$iduser = $_GET['id'];

	$sql = mysqli_query($conexao,"SELECT u.id,u.nome,u.correo,u.usuario, (u.rol) as idrol, (r.rol) FROM usuario u INNER JOIN rol r on u.rol = r.idrol WHERE id= $iduser and estatus = 1 ");

	mysqli_close($conexao);

	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_usuarios.php');
	}else{
		$option = '';
		while ($data = mysqli_fetch_array($sql)) {
			# code...
			$iduser  = $data['id'];
			$nome    = $data['nome'];
			$correo  = $data['correo'];
			$usuario = $data['usuario'];
			$idrol   = $data['idrol'];
			$rol     = $data['rol'];

			if($idrol == 1){
				$option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
			}else if($idrol == 2){
				$option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
			}else if($idrol == 3){
				$option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
			}


		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Atualizar Usuario</title>
</head>
<body>

	<?php include "includes/header.php"; ?>

	<section id="container">
		<div class="form_register">
			<h1>Atualizar usuario</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post">
				<input type="hidden" name="id" value="<?php echo $iduser; ?>">
				<label for="nome">Nome</label>
				<input type="text" name="nome" id="nome" placeholder="Nome completo" value="<?php echo $nome; ?>">
				<label for="correo">Correio electronico</label>
				<input type="email" name="correo" id="correo" placeholder="Correio electronico" value="<?php echo $correo; ?>">
				<label for="usuario">Usuario</label>
				<input type="text" name="usuario" id="usuario" placeholder="Usuario" value="<?php echo $usuario; ?>">
				<label for="senha">Senha</label>
				<input type="password" name="senha" id="senha" placeholder="Senha de acesso">
				<label for="rol">Tipo Usuarios</label>

				<?php 
					include "../conexao.php";
					$query_rol = mysqli_query($conexao,"SELECT * FROM rol");
					mysqli_close($conexao);
					$result_rol = mysqli_num_rows($query_rol);

				 ?>

				<select name="rol" id="rol" class="notItemOne">
				<?php 

					echo $option;

					if($result_rol > 0){

						while ($rol = mysqli_fetch_array($query_rol)){
				?>
					<option value="<?php echo $rol['idrol']; ?>"><?php echo $rol['rol']; ?></option>
				<?php

						}

					}

				 ?>

				</select>
				<input type="submit" value="Atualizar usuario" class="btn_save">

			</form>

		</div>



	</section>

	<?php include "includes/footer.php"; ?>

</body>
</html>