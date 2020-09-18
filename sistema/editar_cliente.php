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

			$idcliente = $_POST['id'];
			$nif       = $_POST['nif'];
			$nome      = $_POST['nome'];
			$telefone  = $_POST['telefone'];
			$direcao   = $_POST['direcao'];

			$result = 0;

			if(is_numeric($nif) and $nif !=0)
			{
				$query = mysqli_query($conexao,"SELECT * FROM cliente 
												 WHERE (nif = '$nif' AND idcliente != $idcliente) ");

				$result = mysqli_fetch_array($query);
				$result = count($result);
			}
			
			if($result > 0) {
				$alert='<p class="msg_error">O nif ja existe, insere outro.</p>';
			}else{

				if($nif == '')
				{
					$nif = 0;
				}

				$sql_update = mysqli_query($conexao, "UPDATE cliente
														  SET nif = '$nif',nome = '$nome',telefone='$telefone',
														  direcao='$direcao' 
														  WHERE idcliente = $idcliente ");

				if($sql_update){
					$alert='<p class="msg_save">Cliente atualizado corretamente.</p>';
				}else{
					$alert='<p class="msg_error">Erro ao atualizar cliente.</p>';
				}
			}
		}
	}

	//Mostrar Dados
	if(empty($_REQUEST['id']))
	{
		header('location: lista_clientes.php');
		mysqli_close($conexao);
	}
	$idcliente = $_REQUEST['id'];

	$sql = mysqli_query($conexao, "SELECT * FROM cliente WHERE idcliente = $idcliente and estatus = 1 ");

	mysqli_close($conexao);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_clientes.php');
	}else{

		while ($data = mysqli_fetch_array($sql)) {
			# code...
			$idcliente = $data['idcliente'];
			$nif 	   = $data['nif'];
			$nome      = $data['nome'];
			$telefone  = $data['telefone'];
			$direcao   = $data['direcao'];

		}

	}

 ?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php" ?>
	<title>Actualizar Cliente</title>
</head>
<body>
	<?php include "includes/header.php" ?>

	<section id="container">
		
		<div class="form_register">
			<h1>Actualizar cliente</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="POST">
				<input type="hidden" name="id" value="<?php echo $idcliente; ?>" >
				<label for="nif">NIF</label>
				<input type="number" name="nif" id="nif" placeholder="Numero de NIF" value="<?php echo $nif; ?>">
				<label for="nome">Nome</label>
				<input type="text" name="nome" id="nome" placeholder="Nome completo" value="<?php echo $nome; ?>">
				<label for="telefone">Telefone</label>
				<input type="number" name="telefone" id="telefone" placeholder="Numero de telefone" value="<?php echo $telefone; ?>">
				<label for="direcao">Direção</label>
				<input type="text" name="direcao" id="direcao" placeholder="Direcao completa" value="<?php echo $direcao; ?>">
				<input type="submit" value="Actualizar cliente" class="btn_save">

			</form>

		</div>

	</section>

	<?php include "includes/footer.php" ?>

</body>
</html>














