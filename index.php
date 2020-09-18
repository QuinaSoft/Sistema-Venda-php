<?php 

	
$alert = ''; 
session_start();
if(!empty($_SESSION['active']))
{
	header('location: sistema/');
}else{


	if(!empty($_POST))
	{
		if(empty($_POST['usuario']) || empty($_POST['senha']))
		{
			$alert = 'informar o usuario e a sua senha';
		}else{

			require_once "conexao.php";

			$user = mysqli_real_escape_string($conexao,$_POST['usuario']);
			$pass = md5(mysqli_real_escape_string($conexao,$_POST['senha']));

			$query = mysqli_query($conexao, "SELECT * FROM usuario WHERE usuario= '$user' AND clave='$pass'");
			mysqli_close($conexao);
			$result = mysqli_num_rows($query);

			if($result > 0)
			{
				$data = mysqli_fetch_array($query);
				$_SESSION['active'] = true;
				$_SESSION['idUser'] = $data['id'];
				$_SESSION['nome']   = $data['nome'];
				$_SESSION['email']  = $data['correo'];
				$_SESSION['user']   = $data['usuario'];
				$_SESSION['rol']    = $data['rol'];

				header('Location: sistema/');

			}else {
				$alert = 'O utilizador e senha incorreta!';
				session_destroy();
			}


		}
	}

}


?>

<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="UTF-8">
	<title>Login | Sistema de Facturação</title>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>

	<section id="container">
		
		<form action="" method="POST">
			
			<h3>Iniciar Sessão</h3>
			<img src="img/login.png" alt="Login">

			<input type="text" name="usuario" placeholder="Usuario">
			<input type="password" name="senha" placeholder="Palavra passe">
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
			<input type="submit" value="ACESSAR">

		</form>

	</section>

</body>
</html>