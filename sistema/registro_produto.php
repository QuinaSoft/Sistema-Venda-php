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
		if(empty($_POST['proveedor']) || empty($_POST['produto']) || empty($_POST['precio']) || $_POST['precio'] <= 0 || empty($_POST['cantidad'] || $_POST['cantidad'] <= 0))
		{
			$alert='<p class="msg_error">Todos os campos  são obrigatorios.</p>';
		}else{

			$proveedor  = $_POST['proveedor'];
			$produto = $_POST['produto'];
			$precio = $_POST['precio'];
			$cantidad = $_POST['cantidad'];
			$usuario_id = $_SESSION['idUser'];

			$foto = $_FILES['foto'];
			$nome_foto = $foto['name'];
			$type      = $foto['type'];
			$url_temp  = $foto['tmp_name'];

			$imgProduto = 'img_produto.png';

			if($nome_foto != '')
			{
				$destino = 'img/uploads/';
				$img_nome = 'img_'.md5(date('d-m-Y H:m:s'));
				$imgProduto = $img_nome.'.jpg';
				$src        = $destino.$imgProduto;
			}

			$query_insert = mysqli_query($conexao,"INSERT INTO produto(proveedor,descripcion,precio,existencia,usuario_id,foto) 
				VALUES('$proveedor','$produto','$precio','$cantidad','$usuario_id','$imgProduto')");

			if($query_insert){
				if($nome_foto != ''){
					move_uploaded_file($url_temp,$src);
				}
				$alert='<p class="msg_save">Produto guardado corretamente.</p>';
			}else{
				$alert='<p class="msg_error">Erro ao guardar produto.</p>';
			}
		}

	}

 ?>

 <!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php" ?>
	<title>Registro Produto</title>
</head>
<body>
	<?php include "includes/header.php" ?>

	<section id="container">
		
		<div class="form_register">
			<h1>Registro produto</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="POST" enctype="multipart/form-data">

				<label for="proveedor">Proveedor</label>

				<?php 

					$query_proveedor = mysqli_query($conexao,"SELECT codproveedor, proveedor FROM proveedor WHERE estatus = 1 ORDER BY proveedor ASC");
					$result_proveedor = mysqli_num_rows($query_proveedor);
					mysqli_close($conexao);

				 ?>


				<select name="proveedor" id="proveedor">

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
				<input type="text" name="produto" id="produto" placeholder="Nome do produto">

				<label for="precio">Preço</label>
				<input type="number" name="precio" id="precio" placeholder="preço do produto">

				<label for="cantidad">Quantidade</label>
				<input type="number" name="cantidad" id="cantidad" placeholder="Quantidade do produto">

				<div class="photo">
					<label for="foto">Foto</label>
						<div class="prevPhoto">
							<span class="delPhoto notBlock">X</span>
							<label for="foto"></label>
						</div>
						<div class="upimg">
							<input type="file" name="foto" id="foto">
						</div>
						<div id="form_alert"></div>
				</div>

				<input type="submit" value="Guardar produto" class="btn_save">

			</form>



		</div>

	</section>

	<?php include "includes/footer.php" ?>

</body>
</html>