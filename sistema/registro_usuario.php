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
		if(empty($_POST['nome']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['senha']) || empty($_POST['rol']))
		{
			$alert='<p class="msg_error">Todos os campos são obrigatorios!</p>';
		}else{

			$nome  = $_POST['nome'];
			$email = $_POST['correo'];
			$user  = $_POST['usuario'];
			$senha = md5($_POST['senha']);
			$rol   = $_POST['rol'];

			$query = mysqli_query($conexao,"SELECT * FROM usuario WHERE usuario = '$user' OR correo = '$email' ");
			//mysqli_close($conexao); esta a dar erro
			
			$result = mysqli_fetch_array($query);

			if($result > 0){
				$alert='<p class="msg_error">O usuario já existe!</p>';
			}else{

				$query_insert = mysqli_query($conexao,"INSERT INTO usuario(nome,correo,usuario,clave,rol)
														VALUES('$nome','$email','$user','$senha','$rol')");

				if($query_insert){
					$alert='<p class="msg_save">O usuario criado corretamente!</p>';
				}else{
					$alert='<p class="msg_error">Erro ao criar o usuario!</p>';
				}

			}

		}

		
	}

 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Registro Usuario</title>
</head>
<body>

	<?php include "includes/header.php"; ?>

	<section id="container">
		<div class="form_register">
			<h1>Registro usuario</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post">
				<label for="nome">Nome</label>
				<input type="text" name="nome" id="nome" placeholder="Nome completo">
				<label for="correo">Correio electronico</label>
				<input type="email" name="correo" id="correo" placeholder="Correio electronico">
				<label for="usuario">Usuario</label>
				<input type="text" name="usuario" id="usuario" placeholder="Usuario">
				<label for="senha">Senha</label>
				<input type="password" name="senha" id="senha" placeholder="Senha de acesso">
				<label for="rol">Tipo Usuarios</label>

				<?php 

					$query_rol = mysqli_query($conexao,"SELECT * FROM rol");
				//	mysqli_close($conexao); esta a dar erro
					$result_rol = mysqli_num_rows($query_rol);

				 ?>

				<select name="rol" id="rol">
				<?php 

					if($result_rol > 0){

						while ($rol = mysqli_fetch_array($query_rol)){
				?>
					<option value="<?php echo $rol['idrol']; ?>"><?php echo $rol['rol']; ?></option>
				<?php

						}

					}

				 ?>

				</select>
				<input type="submit" value="Criar usuario" class="btn_save">

			</form>

		</div>



	</section>

	<?php include "includes/footer.php"; ?>

</body>
</html>