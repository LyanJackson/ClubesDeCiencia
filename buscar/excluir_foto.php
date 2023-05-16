<?php 
	include '../../../web/seguranca.php';

	$id = $_POST['id'];
	$arquivo = htmlentities($_POST['nome']);
	$path = "../../../img/clubes_de_ciencia/";
	$pasta = $path.$arquivo;

	// echo '<script>alert("'.$pasta.'")</script>';
	if(file_exists($pasta)){

		$res = mysqli_query($_SG['link'], "SELECT * FROM clubes_de_ciencia WHERE id = ".$id." LIMIT 1");
		$clube = mysqli_fetch_assoc($res);

		$ano = $clube['ano'];
		$titulo_projeto = $clube['titulo_projeto'];
		$nome_clube = $clube['nome_clube'];

		$fotos = $clube['fotos'];
		$foto = explode(",", $fotos);



		for($i = 0; $i < count($foto); $i++){
			if($foto[$i] == $arquivo){
				unset($foto[$i]);
			}
		}

		$fotos = implode(",", $foto);

		echo '<script>alert("'.$fotos.'")</script>';

		$query = "UPDATE clubes_de_ciencia SET fotos = '".$fotos."' WHERE id = ".$id;

		if(!mysqli_query($_SG['link'], $query)){
			echo 'Problema encontrado ao remover a foto, entre em contato com o administrador.<br>';
			echo mysqli_error();
		}
		else{
			if(unlink($pasta)){
                $fotoss = explode(",", $fotos);

                for($i = 0; $i < count($fotoss); $i++){

                	if(file_exists($path.$fotoss[$i])){
	                    if($i == 0 || $i % 3 == 0)
	                        echo '<div class="row">';

	                    echo '<div class="col-md-4">';
	                        echo '<button data-id="'.$id.'" data-nome="'.$id.'-'.$i.'.jpg" class="btn btn-circle alert-danger btn-excluir-foto" type="button" style="position: absolute; top: -15px; right: 5px;"><i class="fa fa-times fa-1x"></i></button>';
	                        echo '<img src="../../../../img/clubes_de_ciencia/'.$id.'-'.$i.'.jpg" alt="" class="img-responsive"/>';
	                    echo '</div>';

	                    if($i == 3)
	                        echo '</div>';
	                }
	                else{
	                	continue;
	                }
                }
            }
            else{
            	echo 'Arquivo não pode ser excluido';
            }
		}

	}
	else{
		echo 'NAO EXISTE';
		echo $pasta;
	}

	

 ?>