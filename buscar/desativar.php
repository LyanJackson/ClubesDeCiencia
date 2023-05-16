<?php 
	include '../../../web/seguranca.php';

	$id = $_POST['id'];

	$query = "DELETE FROM clubes_de_ciencia WHERE id = '$id'";

	if(mysqli_query($_SG['link'], $query)){
		$id_usuario = $_SESSION['usuarioID'];
	    $time = date("Y-m-d H:i:s");

	    $res = mysqli_query($_SG['link'], "INSERT INTO log_sistema_clube_de_ciencia (id_usuario, id_clube, acao, date_time) VALUES ('$id_usuario','$id', 'excluir', '$time')");

		echo '<script>$(".alerta").addClass("alert-success");</script>';
		echo '<span class="pull-left glyphicon glyphicon-ok"></span>&ensp;Clube de Ciência excluído com sucesso!';
	}
	else {
		echo '<script>$(".alerta").addClass("alert-danger");</script>';
		echo '<i class="fa fa-remove"></i>&ensp;Erro ao tentar excluir.';
		echo '<script>alert("'.mysqli_error().'")</script>';
	}

?>