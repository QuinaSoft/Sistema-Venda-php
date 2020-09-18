<nav>
	<ul>
		<li><a href="index.php">Inicio</a></li>
		<?php 
			if($_SESSION['rol'] ==1){
		 ?>
		<li class="principal">
			<a href="#">Usuarios</a>
			<ul>
				<li><a href="registro_usuario.php">Nuevo usuario</a></li>
				<li><a href="lista_usuarios.php">Lista de Usuarios</a></li>
			</ul> 
		</li>
		<?php } ?>
		<li class="principal">
			<a href="#">Clientes</a>
				<ul>
				<li><a href="registro_cliente.php">Nuevo Cliente</a></li>
				<li><a href="lista_clientes.php">Lista de clientes</a></li>
			</ul> 
		</li>

		<?php  
			if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2){
		?>
		<li class="principal">
			<a href="#">Provedores</a>
				<ul>
				<li><a href="registro_proveedor.php">Novo Proveedor</a></li>
				<li><a href="lista_provedor.php">Lista de Provedores</a></li>
			</ul> 
		</li>
		<?php } ?>
		<li class="principal">
			<a href="#">Produtos</a>
			<ul>

			<?php  
				if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2){
			?>

				<li><a href="registro_produto.php">Novo Produtos</a></li>
				
			<?php } ?>

				<li><a href="lista_produto.php">Lista de Produtos</a></li>
			</ul> 
		</li>
		<li class="principal">
			<a href="#">Vendas</a>
				<ul>
				<li><a href="nova_venda.php">Nova Venda</a></li>
				<li><a href="#">Vendas</a></li>
			</ul> 
		</li>
	</ul>
</nav>
