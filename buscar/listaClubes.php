<?php 

include '../../../web/seguranca.php';
$title = "LISTA DE CLUBES DE CIÊNCIAS";
include '../../head.php';

$titulo_projeto = htmlentities($_POST['titulo_projeto']);
$nome_clube = htmlentities($_POST['nome_clube']);
$integrantes = htmlentities($_POST['integrantes']);
$ano = $_POST['ano'];   
$cidade = htmlentities($_POST['cidade']);

$query = "SELECT * FROM clubes_de_ciencia WHERE titulo_projeto LIKE '%".$titulo_projeto."%' AND nome_clube LIKE '%".$nome_clube."%' AND integrantes LIKE '%".$integrantes."%'";

if(isset($_POST['ano']) AND !empty($ano) AND $ano != 'all'){
    $query .= " AND ano = '$ano'";
}

if(isset($_POST['cidade']) AND !empty($cidade) AND $cidade != 'all'){
    $query .= " AND cidade = '$cidade'";
}


$query .= " ORDER BY  ano DESC, cidade, titulo_projeto, nome_clube";

if(isset($_POST['qtd_resultados']) AND $_POST['qtd_resultados'] != 'all'){
    $query .= " LIMIT " . $_POST['qtd_resultados'];
}

$resultado = mysqli_query($_SG['link'], $query);

// echo '<script>alert("'.$query.'")</script>';

echo '
<div class="container" align="center">
	<div class="row">
		<div class="col-md-12 text-center">
			<button onclick="imprimir()" class="btn btn-default" id="btn-print" style="margin-top: 30px;"><i class="fa fa-print"></i> IMPRIMIR</button>
		</div>
		<div class="col-md-12">';

echo '<h1>Lista de clubes de ciências</h1>';
echo '<h3>'.$cidade.' <br> '.$ano.'</h3>';

echo '<table class="table table-hover table-stripped table-bordered">

<thead>
	<tr>
		<td><b>Título do projeto</b></td>
		<td><b>Nome do clube</b></td>
		<td><b>Alunos</b></td>
		<td><b>Cidade</b></td>
		<td><b>Ano</b></td>
	</tr>
</thead>';

echo '<tbody>';

if (mysqli_num_rows($resultado) != 0){
    while ($clube = mysqli_fetch_assoc($resultado)) {
    		echo '
    		<tr>
				<td>'.$clube["titulo_projeto"].'</td>
				<td>'.$clube["nome_clube"].'</td>
				<td>'.$clube["integrantes"].'</td>
				<td>'.$clube["cidade"].'</td>
				<td>'.$clube["ano"].'</td>
    		</tr>';
        }
} else {

        echo "<br><br><div class='alert alert-danger'> <span class='glyphicon glyphicon-exclamation-sign'></span> Nenhum resultado encontrado</div>";
}

echo '</tbody>';

echo '</table>';

echo '</div></div></div>';
 ?>


<script>
	function imprimir(){
		$('#btn-print').hide();
		window.print();

		setTimeout(function(){
			$('#btn-print').show();
		}, 1000);
	}
</script>