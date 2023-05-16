<?php 
	include '../../../web/seguranca.php';

	$id = $_POST['id'];
	$myfiles = $_FILES['fotos'];
	$offset = 0;

	$query = "SELECT * FROM clubes_de_ciencia WHERE id = ".$id." LIMIT 1";

	$clube = mysqli_fetch_assoc(mysqli_query($_SG['link'], $query));

	echo mysqli_error($_SG['link']);

	if($clube['fotos'] != ""){
		$fotos = explode(",", $clube['fotos']);

		$foto = $fotos[count($fotos)-1];

		$indices = explode("-", $foto);

		$indice = $indices[1];

		$offset = $indice[0];

		$offset++;
	}
	else{
		$offset = 0;
	}

	// echo '<script>alert("'.$offset.'")</script>';

	$fotos = $clube['fotos'];

	// Pasta onde as imagens serao salvas
	$_UP['pasta'] = '../../../img/clubes_de_ciencia/';	

	for( $i = $offset, $cont = 0; $i < count($myfiles['name']) + $offset; $i++, $cont++)
	{
	    $nome_final = $id.'-'.$i.'.jpg';

		if (move_uploaded_file($_FILES['fotos']['tmp_name'][$cont], $_UP['pasta'] . $nome_final)) {
			$fotos .= ",".$nome_final;
		}
		else
			$upload = 0;  
	}

	$query = "UPDATE clubes_de_ciencia SET fotos = '".$fotos."' WHERE id = ".$id;

	if(mysqli_query($_SG['link'], $query)){
	$id_usuario = $_SESSION['usuarioID'];
    $time = date("Y-m-d H:i:s");

    $res = mysqli_query($_SG['link'], "INSERT INTO log_sistema_clube_de_ciencia (id_usuario, id_clube, acao, date_time) VALUES ('$id_usuario','$id', 'alterar-fotos', '$time')");	
    	
		echo 'Fotos adicionadas com sucesso!';
	}
	else{
		echo 'Fotos não adicionadas.';
		echo mysqli_error($_SG['link']);
	}

?>
		
