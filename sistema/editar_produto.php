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
		if(empty($_POST['proveedor']) || empty($_POST['produto']) || empty($_POST['precio']) || empty($_POST['id']) || empty($_POST['foto_atual']) || empty($_POST['foto_remove']))
		{
			$alert='<p class="msg_error">Todos os campos  são obrigatorios.</p>';
		}else{

			$codproduto = $_POST['id'];
			$proveedor  = $_POST['proveedor'];
			$produto = $_POST['produto'];
			$precio = $_POST['precio'];
			$imgProduto = $_POST['foto_atual'];
			$imgRemove = $_POST['foto_remove'];

			$foto = $_FILES['foto'];
			$nome_foto = $foto['name'];
			$type      = $foto['type'];
			$url_temp  = $foto['tmp_name'];

			$upd = '';

			if($nome_foto != '')
			{
				$destino = 'img/uploads/';
				$img_nome = 'img_'.md5(date('d-m-Y H:m:s'));
				$imgProduto = $img_nome.'.jpg';
				$src        = $destino.$imgProduto;
			}else{
				if($_POST['foto_atual'] != $_POST['foto_remove']){
					$imgProduto = 'img_produto.png';
				}
			}

			$query_update = mysqli_query($conexao,"UPDATE produto
													SET descripcion = '$produto',
														proveedor = $proveedor,
														precio =  $precio,
														foto = '$imgProduto'
													WHERE codproduto = $codproduto");

			if($query_update){
				if(($nome_foto != '' && ($_POST['foto_atual'] != 'img_produto.png')) || ($_POST['foto_atual'] != $_POST['foto_remove']))
				{
					unlink('img/uploads/'.$_POST['foto_atual']);
				}
				if($nome_foto != ''){
					move_uploaded_file($url_temp,$src);
				}
				$alert='<p class="msg_save">Produto atualizado corretamente.</p>';
			}else{
				$alert='<p class="msg_error">Erro ao atualizar produto.</p>';
			}
		}

	}

	//VALIDAR PRODUTO
	if(empty($_REQUEST['id'])){
		header("location: lista_produto.php");
	}else{

		$id_produto = $_REQUEST['id'];
		if(!is_numeric($id_produto)){
			header("location: lista_produto.php");
		}

		$query_produto = mysqli_query($conexao,"SELECT p.codproduto, p.descripcion, p.precio, p.foto, pr.codproveedor, pr.proveedor FROM produto p INNER JOIN proveedor pr ON p.proveedor = pr.codproveedor WHERE p.codproduto = $id_produto AND p.estatus = 1 ");
		$result_produto = mysqli_num_rows($query_produto);

		$foto = '';
		$classRemove = 'notBlock';

		if($result_produto > 0){
			$data_produto = mysqli_fetch_assoc($query_produto);

			if($data_produto['foto'] != 'img_produto.png'){
				$classRemove = '';
				$foto = '<img id="img" src="img/uploads/'.$data_produto['foto'].'" alt="Produto">';
			}
		}else{
			header("location: lista_produto.php");
		}

	}

 ?>

 <!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php" ?>
	<title>Atualizar Produto</title>
</head>
<body>
	<?php include "includes/header.php" ?>

	<section id="container">
		
		<div class="form_register">
			<h1>Atualizar produto</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $data_produto['codproduto']; ?>">
				<input type="hidden" id="foto_atual" name="foto_atual" value="<?php echo $data_produto['foto']; ?>">
				<input type="hidden" id="foto_remove" name="foto_remove" value="<?php echo $data_produto['foto']; ?>">
				<label for="proveedor">Proveedor</label>

				<?php 

					$query_proveedor = mysqli_query($conexao,"SELECT codproveedor, proveedor FROM proveedor WHERE estatus = 1 ORDER BY proveedor ASC");
					$result_proveedor = mysqli_num_rows($query_proveedor);
					mysqli_close($conexao);

				 ?>


				<select name="proveedor" id="proveedor" class="notItemOne">
				<option value="<?php echo $data_produto['codproveedor']; ?>" selected><?php echo $data_produto['proveedor']; ?></option>
				<?php 

					if($result_proveedor > 0){
						while ($proveedor = mysqli_fetch_array($query_proveedor)) {
							# code...
				?>
					<option value="<?php echo $proveedor['codproveedor']; ?>"><?php echo  $proveedor['proveedor']; ?></option>
				<?php
						}
					}

				 ?>

				</select>

				<label for="produto">Produto</label>
				<input type="text" name="produto" id="produto" placeholder="Nome do produto" value="<?php echo $data_produto['descripcion'];  ?>">

				<label for="precio">Preço</label>
				<input type="number" name="precio" id="precio" placeholder="preço do produto" value="<?php echo $data_produto['precio'];  ?>">

				<div class="photo">
					<label for="foto">Foto</label>
						<div class="prevPhoto">
							<span class="delPhoto <?php echo $classRemove; ?>">X</span>
							<label for="foto"></label>
							<?php echo $foto; ?>
						</div>
						<div class="upimg">
							<input type="file" name="foto" id="foto">
						</div>
						<div id="form_alert"></div>
				</div>

				<input type="submit" value="Atualizar produto" class="btn_save">

			</form>



		</div>

	</section>

	<?php include "includes/footer.php" ?>

</body>
</html>