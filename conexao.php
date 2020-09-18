<?php

	$host 	  = 'localhost';
	$user     = 'root';
	$password = '';
	$db       = 'faturacao';

	$conexao = mysqli_connect($host,$user,$password,$db);

	
	if(!$conexao){
		echo "Error ao conectar!";
	}



?>