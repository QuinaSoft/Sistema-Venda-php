<?php 
	session_start();
	include "../conexao.php";

		if(!empty($_POST))
	{
		$alert='';
		if(empty($_POST['nome']) || empty($_POST['telefone']) || empty($_POST['direcao']))
		{
			$alert='<p class="msg_error">Todos os campos  são obrigatorios.</p>';
		}else{

			$nif  = $_POST['nif'];
			$nome = $_POST['nome'];
			$telefone = $_POST['telefone'];
			$direcao = $_POST['direcao'];
			$usuario_id = $_SESSION['idUser'];

			$result = 0;

			if(is_numeric($nif) and $nif != 0)
			{
				$query = mysqli_query($conexao,"SELECT * FROM cliente WHERE nif = '$nif' ");
				$result = mysqli_fetch_array($query);
			}

			if($result > 0){
				$alert='<p class="msg_error">O numero de nif ja existe.</p>';
			}else{
				$query_insert = mysqli_query($conexao,"INSERT INTO cliente
												(nif,nome,telefone,direcao,usuario_id) VALUES
												('$nif','$nome','$telefone','$direcao','$usuario_id')");

				if($query_insert){
					$alert='<p class="msg_save">Cliente guardado corretamente.</p>';
				}else{
					$alert='<p class="msg_error">Erro ao guardar cliente.</p>';
				}
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
	<title>Registro Usuario</title>
</head>
<body>
	<?php include "includes/header.php" ?>

	<section id="container">
		
		<div class="form_register">
			<h1>Registro cliente</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="POST">
				<label for="nif">NIF</label>
				<input type="number" name="nif" id="nif" placeholder="Numero de NIF">
				<label for="nome">Nome</label>
				<input type="text" name="nome" id="nome" placeholder="Nome completo">
				<label for="telefone">Telefone</label>
				<input type="number" name="telefone" id="telefone" placeholder="Numero de telefone">
				<label for="direcao">Direção</label>
				<input type="text" name="direcao" id="direcao" placeholder="Direcao completa">
				<input type="submit" value="Guardar cliente" class="btn_save">

			</form>



		</div>

	</section>

	<?php include "includes/footer.php" ?>

</body>
</html>