$(document).ready(function(){

	//-------- SELECCIONAR FOTO PRODUTO -----------

	$("#foto").on("change",function(){
		var uploadFoto = document.getElementById("foto").value;
		var foto       = document.getElementById("foto").files;
		var nav = window.URL || window.webkitURL;
		var contactAlert = document.getElementById('form_alert');;

			if(uploadFoto != '')
			{
				var type = foto[0].type;
				var name = foto[0].name;
				if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png')
				{
					contactAlert.innerHTML = '<p class="errorArquivo">Arquivo invalido</p>';
					$("#img").remove();
					$(".delPhoto").addClass('notBlock');
					$('#foto').val('');
					return false;
				}else{
					contactAlert.innerHTML='';
					$("#img").remove();
					$(".delPhoto").removeClass('notBlock');
					var objeto_url = nav.createObjectURL(this.files[0]);
					$(".prevPhoto").append("<img id='img' src="+objeto_url+">");
					$(".upimg label").remove();
				}
			}else{
				alert("Não seleciona a foto");
				$("#img").remove();
			}

	});

	$('.delPhoto').click(function(){
		$('#foto').val('');
		$(".delPhoto").addClass('notBlock');
		$("#img").remove();

		if ($("#foto_atual") && $("#foto_remove")){
			$("#foto_remove").val('img_produto.png');
		}

	});

	//Activa campos para registrar cliente
	$('.btn_new_cliente').click(function(e){
		e.preventDefault();
		$('#nom_cliente').removeAttr('disabled');
		$('#tel_cliente').removeAttr('disabled');
		$('#dir_cliente').removeAttr('disabled');

		$('#div_registro_cliente').slideDown();
	});

	//Modal form Add Product
//	$('.add_product').click(function(e) {
//		e.preventDefault();
//		var producto = $(this).attr('product');
//		$('.modal').fadeIn();

//	});

//});

//function coloseModal(){
//	$('.modal').fadeOut();
//}