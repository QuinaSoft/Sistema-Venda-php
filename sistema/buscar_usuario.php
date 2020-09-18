<?php
	session_start();
	if($_SESSION['rol'] != 1)
	{
		header("location: ./");
	}
	include "../conexao.php";

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Lista de usuarios</title>
</head>
<body>

	<?php include "includes/header.php"; ?>

	<section id="container">

	<?php 

		$busca = strtolower($_REQUEST['busca']);
		if(empty($busca))
		{
			header("location: lista_usuarios.php");
			mysqli_close($conexao);
		}

	 ?>

		<h1>Lista de usuarios</h1>
		<a href="registro_usuario.php" class="btn_new">Criar usuarios</a>

		<form action="buscar_usuario.php" method="get" class="form_search">
			<input type="text" name="busca" id="busca" placeholder="Pesquisar" value="<?php $busca; ?>">
			<input type="submit" value="buscar" class="btn_search">
		</form>


		<table>
			<tr>
				<th>ID</th>
				<th>Nome</th>
				<th>Correio</th>
				<th>Usuario</th>
				<th>Função</th>
				<th>Acção</th>
			</tr>

			<?php 

				//Paginador
				$rol = '';
				if($busca == 'administrador')
				{
					$rol = " OR rol LIKE '%1%' ";
				}else if($busca == 'supervisor'){

					$rol = " OR rol LIKE '%2%' ";
				}else if($busca == 'vendedor'){

					$rol = " OR rol LIKE '%3%' ";
				}

				$sql_registe = mysqli_query($conexao,"SELECT COUNT(*) as total_registro FROM usuario 												WHERE (id LIKE '%$busca%' OR
																   nome LIKE '%$busca%' OR
																   correo LIKE '%$busca%' OR
																   usuario LIKE '%$busca%'
																   $rol ) 
																   AND estatus = 1 ");
				$result_register = mysqli_fetch_array($sql_registe);
				$total_registro = $result_register['total_registro'];

				$por_pagina = 5;

				if(empty($_GET['pagina']))
				{
					$pagina = 1;
				}else{
					$pagina = $_GET['pagina'];
				}

				$desde = ($pagina-1) * $por_pagina;
				$total_paginas = ceil($total_registro / $por_pagina);



				$query = mysqli_query($conexao,"SELECT u.id, u.nome, u.correo, u.usuario, r.rol FROM usuario 								u INNER JOIN rol r ON u.rol = r.idrol 
													WHERE 			
												    ( u.id LIKE '%$busca%' OR
													   u.nome LIKE '%$busca%' OR
													   u.correo LIKE '%$busca%' OR
													   u.usuario LIKE '%$busca%' OR
													   r.rol LIKE '%$busca%' )
													 AND
													estatus = 1 ORDER BY u.id ASC LIMIT $desde,$por_pagina ");

				mysqli_close($conexao);
				$result = mysqli_num_rows($query);
				if($result > 0){

					while ($data = mysqli_fetch_array($query)){
				
				?>

					<tr>
						<td><?php echo $data['id']; ?></td>
						<td><?php echo $data['nome']; ?></td>
						<td><?php echo $data['correo']; ?></td>
						<td><?php echo $data['usuario']; ?></td>
						<td><?php echo $data['rol']; ?></td>
						<td>
							<a class="link_edit" href="editar_usuario.php?id=<?php echo $data['id']; ?>">Editar</a>

							<?php if($data['id'] != 1){ ?>
							|
							<a class="link_delete" href="eliminar_confirmar_usuario.php?id=<?php echo $data['id']; ?>">Eliminar</a>
							<?php } ?>

						</td>
					</tr>

				<?php
					}

				}

			 ?>



		</table>

		<?php 

			if($total_registro != 0)
			{
		 ?>


		<div class="paginador">
			<ul>
			<?php 
				if($pagina != 1)
				{

			 ?>
				<li><a href="?pagina=<?php echo 1; ?>&busca=<?php echo $busca; ?>">|<</a></li>
				<li><a href="?pagina=<?php echo $pagina-1; ?>&busca=<?php echo $busca; ?>"><<</a></li>
				
				<?php 
					}
					for($i=1; $i <= $total_paginas; $i++){

						if($i == $pagina)
						{
							echo '<li class="pageSelected">'.$i.'</li>';
						}else{
							echo '<li><a href="?pagina='.$i.'&busca='.$busca.' ">'.$i.'</a></li>';
						}
						
					}

					if($pagina != $total_paginas)
					{

				 ?>
			
				<li><a href="?pagina=<?php echo $pagina + 1; ?>&busca=<?php echo $busca; ?>">>></a></li>
				<li><a href="?pagina=<?php echo $total_paginas; ?>&busca=<?php echo $busca; ?>">>|</a></li>
				<?php } ?>
			</ul>
		</div>
		<?php } ?>

	</section>

	<?php include "includes/footer.php"; ?>

</body>
</html>
