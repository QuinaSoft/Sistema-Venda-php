 <?php 
	session_start();
	include "../conexao.php";

 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php" ?>
	<title>Lista de produtos</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	
</head>
<body>

<?php include "includes/header.php" ?>
	<section id="container">

		<h1>Lista de produtos</h1>
		<a href="registro_produto.php" class="btn_new">Registar produto</a>

		<form action="buscar_produto.php" method="GET" class="form_search">
			<input type="text" name="pesquisa" id="busca" placeholder="Pesquisar">
			<input type="submit" value="Buscar" class="btn_search">
		</form>

		<table>
			<tr>
				<th>Código</th>
				<th>Descrição</th>
				<th>Preço</th>
				<th>Existencia</th>
				<th>Provedor</th>
				<th>Foto</th>
				<th>Acções</th>
			</tr>
	<?php 

			//Paginador
				$sql_registe = mysqli_query($conexao, "SELECT COUNT(*) as total_registro FROM produto WHERE estatus = 1");
				$result_register = mysqli_fetch_array($sql_registe);
				$total_registro = $result_register['total_registro'];

				$por_pagina = 10;

				if(empty($_GET['pagina'])){
					$pagina = 1;
				}else{
					$pagina = $_GET['pagina'];
				}

				$desde = ($pagina-1) * $por_pagina;
				$total_paginas = ceil($total_registro / $por_pagina);

				$query = mysqli_query($conexao,"SELECT p.codproduto, p.descripcion, p.precio, p.existencia, pr.proveedor, p.foto 
												FROM produto p
												INNER JOIN proveedor pr
												ON p.proveedor = pr.codproveedor
												WHERE p.estatus = 1 ORDER BY p.codproduto DESC LIMIT $desde,$por_pagina
					");

				mysqli_close($conexao);

				$result = mysqli_num_rows($query);
				if($result > 0){
					
					while ($data = mysqli_fetch_array($query)) {
						if($data['foto'] != 'img_produto.png'){
							$foto = 'img/uploads/'.$data['foto'];
						}else{
							$foto = 'img/'.$data['foto'];
						}
	 		?>

	 	<tr>
			<td><?php echo $data['codproduto']; ?></td>
			<td><?php echo $data['descripcion']; ?></td>
			<td><?php echo $data['precio']; ?></td>
			<td><?php echo $data['existencia']; ?></td>
			<td><?php echo $data['proveedor']; ?></td>
			<td class="img_produto"><img src="<?php echo $foto; ?>" alt="<?php echo $data['descripcion']; ?>"></td>
			
			<?php if($_SESSION['rol'] == 1 || $_SESSION['rol'] ==2){ ?>
			<td>
				<a class="link_add add_product" product="<?php echo $data['codproduto']; ?>" href="#">Agregar</a>
				|
				<a class="link_edit" href="editar_produto.php?id=<?php echo $data['codproduto']; ?>">Editar</a>
				|
				<a class="link_delete" href="eliminar_confirmar_produto.php?id=<?php echo $data['codproduto']; ?>">Eliminar</a>
			</td>
			<?php } ?>
		</tr>


	 <?php 

	 	}
			}

	  ?>

	</table>

		<div class="paginador">
			<ul>
			<?php 
				if($pagina != 1)
				{

			 ?>

				<li><a href="?pagina=<?php echo 1; ?>">|<</a></li>
				<li><a href="?pagina=<?php echo $pagina-1; ?>"><<</a></li>

				<?php
					}
					for ($i=1; $i <= $total_paginas; $i++) { 
						# code...
						if($i == $pagina)
						{
							echo '<li class="pageSelected">'.$i.'</li>';
						}else
						{
							echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
						}
					}
					if($pagina != $total_paginas)
					{
				?>

				<li><a href="?pagina=<?php echo $pagina + 1; ?>">>></a></li>
				<li><a href="?pagina=<?php echo $total_paginas; ?>">>|</a></li>
				<?php } ?>
			</ul>
		</div>

	</section>

	<?php include "includes/footer.php" ?>

</body>
</html>