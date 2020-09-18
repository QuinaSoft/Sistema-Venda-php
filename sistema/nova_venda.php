<?php 
	session_start();
	include "../conexao.php";

 ?>
 <!DOCTYPE html>
 <html lang="pt">
 <head>
 	<meta charset="UTF-8">
 	<?php include "includes/scripts.php"; ?>
 	<title>Nova Venda</title>
 	<link rel="stylesheet" type="text/css" href="css/styles.css">
 </head>
 <body>
	<?php include "includes/header.php"; ?>
 	
 	<section id="container">
 		<div class="title_page">
 			<h1>Nova venda</h1>
 		</div>
 		<div class="datos_cliente">
 			<div class="action_cliente">
 				<h4>Dados do cliente</h4>
 				<a href="#" class="btn_new btn_new_cliente">Novo cliente</a>
 			</div>
 			<form name="form_new_cliente_venta" id="form_new_cliente_venta" class="datos">
 				<input type="hidden" name="action" value="addCliente">
 				<input type="hidden" id="idcliente" name="idcliente" value="" required>
 				<div class="wd30">
 					<label>Nif</label>
 					<input type="text" name="nif_cliente" id="nif_cliente">
 				</div>
 				<div class="wd30">
 					<label>Nome</label>
 					<input type="text" name="nom_cliente" id="nom_cliente" disabled required>
 				</div>
 				<div class="wd30">
 					<label>Telefone</label>
 					<input type="number" name="tel_cliente" id="tel_cliente" disabled required>
 				</div>
 				<div class="wd100">
 					<label>Direção</label>
 					<input type="text" name="dir_cliente" id="dir_cliente" disabled required>
 				</div>
 				<div id="div_registro_cliente" class="wd100">
 					<button type="submit" class="btn_save" >Guardar</button>
 				</div>	
 			</form>
 		</div>

 		<div class="datos_venda">
 			<h4>Dados da venda</h4>
 			<div class="datos">
 				<div class="wd50">
 					<label>Vendedor</label>
 					<p>Carlos Domingos</p>
 				</div>
 				<div class="wd50">
 					<label>Acções</label>
 					<div id="acciones_venta">
 						<a href="#" class="btn_ok textcenter" id="btn_anular_venta" style="background: red;">Anular</a>
 						<a href="#" class="btn_new textcenter" id="btn_facturar_venta">Processar</a>
 					</div>
 				</div>
 			</div>
 		</div>


 		<table class="tbl_venta">
 			<thead>
 				<tr>
 					<th width="100px">Código</th>
 					<th>Descrição</th>
 					<th>Existencia</th>
 					<th width="100px">Quantidade</th>
 					<th class="textright">Preço</th>
 					<th class="textright">Preço Total</th>
 					<th>Acções</th>
 				</tr>
 				<tr>
 					<td><input type="text" name="txt_cod_producto"></td>
 					<td id="txt_descripcion">-</td>
 					<td id="txt_existencia">-</td>
 					<td><input type="text" name="txt_cant_producto" id="txt_cant_producto" value="0" min="1" disabled></td>
 					<td id="txt_precio" class="textright">0.00</td>
 					<td id="txt_precio_total" class="textright">0.00</td>
 						<td id="txt_precio_total" class="textright" style="color: red;">Delete</td>
 					<td><a href="#" id="add_product_venta" class="link_add">Agregar</a></td>
 				</tr>
 				<tr>
 					<th>Código</th>
 					<th colspan="2">Descrição</th>
 					<th>Quantidade</th>
 					<th class="textright">Preço</th>
 					<th class="textright">Preço total</th>
 					<th>Acção</th>
 				</tr>
 			</thead>
 			<tbody id="detalle_venta">
 				<tr>
 					<td>1</td>
 					<td colspan="2">Mouse USB</td>
 					<td class="textcenter">1</td>
 					<td class="textright">100.00</td>
 					<td class="textright">100.00</td>
 					<td class="textright" style="color: red;">Delete</td>
 					<td class="">
 						<a class="link_delete" href="#" onclick="event.preventDefault() del_product_detalle(1);"></a>
 					</td>
 				</tr>
 				<tr>
 					<td>10</td>
 					<td colspan="2">Teclado USB</td>
 					<td class="textcenter">1</td>
 					<td class="textright">150.00</td>
 					<td class="textright">150.00</td>
 					<td class="textright" style="color: red;">Delete</td>
 					<td class="">
 						<a class="link_delete" href="#" onclick="event.preventDefault() del_product_detalle(1);"></a>
 					</td>
 				</tr>
 			</tbody>
 			<tfoot>
 				<tr>
 					<td colspan="5" class="textright">SUBTOTAL Q.</td>
 					<td class="textright">1000.00</td>
 				</tr>
 				<tr>
 					<td colspan="5" class="textright">IVA (12%)</td>
 					<td class="textright">500</td>
 				</tr>
 				<tr>
 					<td colspan="5" class="textright">TOTAL Q.</td>
 					<td class="textright">1000.00</td>
 				</tr>
 			</tfoot>

 		</table>

 	</section>
 
 	<?php include "includes/footer.php"; ?>
 </body>
 </html>