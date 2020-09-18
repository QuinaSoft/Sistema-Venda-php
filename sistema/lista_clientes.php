<?php 
	session_start();
	include "../conexao.php";

 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php" ?>
	<title>Lista de cliente</title>
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>
<body>

<?php include "includes/header.php" ?>
	<section id="container">

		<h1>Lista de clientes</h1>
		<a href="registro_cliente.php" class="btn_new">Cadastrar cliente</a>

		<form action="buscar_cliente.php" method="GET" class="form_search">
			<input type="text" name="pesquisa" id="busca" placeholder="Pesquisar">
			<input type="submit" value="Buscar" class="btn_search">
		</form>

		<table>
			<tr>
				<th>ID</th>
				<th>NIF</th>
				<th>Nome</th>
				<th>Telefone</th>
				<th>Direção</th>
				<th>Acciones</th>
			</tr>
	<?php 

			//Paginador
				$sql_registe = mysqli_query($conexao, "SELECT COUNT(*) as total_registro FROM cliente WHERE estatus = 1");
				$result_register = mysqli_fetch_array($sql_registe);
				$total_registro = $result_register['total_registro'];

				$por_pagina = 5;

				if(empty($_GET['pagina'])){
					$pagina = 1;
				}else{
					$pagina = $_GET['pagina'];
				}

				$desde = ($pagina-1) * $por_pagina;
				$total_paginas = ceil($total_registro / $por_pagina);

				$query = mysqli_query($conexao,"SELECT * FROM cliente WHERE estatus = 1 ORDER BY idcliente ASC LIMIT $desde,$por_pagina
					");

				mysqli_close($conexao);

				$result = mysqli_num_rows($query);
				if($result > 0){
					
					while ($data = mysqli_fetch_array($query)) {
					if($data["nif"] == 0)
					{
						$nif = 'C/F';
					}else{
						$nif = $data["nif"];
					}	


	 ?>

	 	<tr>
			<td><?php echo $data['idcliente']; ?></td>
			<td><?php echo $nif; ?></td>
			<td><?php echo $data['nome']; ?></td>
			<td><?php echo $data['telefone']; ?></td>
			<td><?php echo $data['direcao']; ?></td>
			
			<td>
				<a class="link_edit" href="editar_cliente.php?id=<?php echo $data['idcliente']; ?>">Editar</a>
				<?php if($_SESSION['rol'] == 1 || $_SESSION['rol'] ==2){ ?>
				|
				<a class="link_delete" href="eliminar_confirmar_cliente.php?id=<?php echo $data['idcliente']; ?>">Eliminar</a>
				<?php } ?>
			</td>
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