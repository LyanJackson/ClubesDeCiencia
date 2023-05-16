<?php 

include '../../../web/seguranca.php';

$titulo_projeto = htmlentities($_POST['titulo_projeto']);
$nome_clube = htmlentities($_POST['nome_clube']);
$integrantes = htmlentities($_POST['integrantes']);
$supervisor = htmlentities($_POST['supervisor']);
$ano = $_POST['ano'];   
$cidade = htmlentities($_POST['cidade']);
$escola = htmlentities($_POST['escola']);
$notas = ($_POST['notass']);



$query = "SELECT * FROM clubes_de_ciencia WHERE titulo_projeto LIKE '%".$titulo_projeto."%' AND nome_clube LIKE '%".$nome_clube."%' AND integrantes LIKE '%".$integrantes."%' AND supervisor LIKE '%".$supervisor."%'";

if(isset($_POST['ano']) AND !empty($ano) AND $ano != 'all'){
    $query .= " AND ano = '$ano'";
}

if(isset($_POST['cidade']) AND !empty($cidade) AND $cidade != 'all'){
    $query .= " AND cidade LIKE '$cidade'";
}

if(isset($_POST['escola']) AND !empty($escola) AND $escola != 'all'){
    $query .= " AND id_escola LIKE '$escola'";
}



if(isset($_POST['notass']) AND !empty($notas) AND $notas != 'all'){
    if($notas == 'maior'){
        $query .= " ORDER BY nota_fase1 DESC";
    } elseif($notas == 'menor'){
        $query .= " ORDER BY nota_fase1 ASC";
    } else {
        $query .= " ORDER BY  ano, cidade, titulo_projeto, nome_clube";
    }
}


if(isset($_POST['qtd_resultados'])){
    $query .= " LIMIT " . $_POST['qtd_resultados'];
}


//if($_SESSION['h'] == 3 OR $_SESSION['h'] == 7){
  ///  $sql_todos = "SELECT count(*) AS qtd_total FROM clubes_de_ciencia WHERE cidade LIKE '".$_SESSION['supervisorCidade']."'";
//}
//else{
 //   $sql_todos = "SELECT count(*) AS qtd_total FROM clubes_de_ciencia";
//}

$resultado = mysqli_query($_SG['link'], $query);

//$todos = mysql_fetch_assoc(mysql_query($sql_todos))['qtd_total'];

$query_todos = "SELECT count(*) AS qtd_total FROM clubes_de_ciencia";
$todos = mysqli_fetch_assoc(mysqli_query($_SG['link'], $query_todos))['qtd_total'];
echo '<br><p class="text-left">Exibindo <b>'.mysqli_num_rows($resultado).'</b>, filtrados de <b>'.$todos.'</b> resultados</p><hr>';

if (mysqli_num_rows($resultado) != 0){
    while ($clube = mysqli_fetch_assoc($resultado)) {

            echo '<div class="alunoContainer">

                <div align="left" class="alunoNome pull-left col-md-8">
                    
                    <h3 class="">'.$clube['nome_clube'].'</h3>';

                    echo '<p style="font-size: 1.1em;"><b>Título do Projeto:</b> '.$clube['titulo_projeto'].' <br> <b>Ano:</b> '.$clube['ano'].'
                        ';


                    echo '<br><b>Escola:</b> '.$clube["nome_escola"].'
                    <br><b>Cidade:</b> '.$clube["cidade"].'
                    <br><b>Supervisor:</b> '.$clube["supervisor"].'
                        <br><b>Integrantes:</b> '.$clube["integrantes"].'
                        <br><b>Nota 1º Fase:</b> '.$clube["nota_fase1"].'
                        <br><b>Nota 2º Fase:</b> '.$clube["nota_fase2"].'
                        <br><b>Média das Duas Fases:</b> '.$clube["media"].'

                    </p>
                </div>

                <div class="alunoMenu pull-right col-md-2">
                    <a href="?p=editar&r='.$clube['id'].'" class="btn btn-warning btn-block"><span class="pull-left glyphicon glyphicon-pencil"></span> Editar
                    </a>';

                     if($_SESSION['h'] == 999):
                        // Botão de excluir
                        echo '<button data-toggle="modal" data-target="#confirm'.$clube['id'].'" class="btn btn-danger btn-block"><span class="pull-left glyphicon glyphicon-trash"></span>&ensp;Excluir</button>';
                        // Modal de confirmação exclusão
                        echo '<div class="modal fade" id="confirm'.$clube['id'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                              <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Confirmação</h4>
                                  </div>
                                  <div class="modal-body">
                                    Você tem certeza que deseja excluir o evento <b>'.$clube['nome_clube'].'</b>?
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                                    <button data-link="'.$clube['id'].'" type="button" class="btn btn-danger desativar" id="enviar_respostas"><i class="fa fa-trash"></i>&ensp;Excluir</button>
                                  </div>
                                </div>
                              </div>
                            </div>';
                     endif;                    
                echo '</div>

            </div>';

        }
} else {

        echo "<br><br><div class='alert alert-danger'> <span class='glyphicon glyphicon-exclamation-sign'></span> Nenhum resultado encontrado</div>";
}

 ?>

 <script>

             $('.desativar').click(function () {
                var $id = $(this).attr('data-link');

                var data = {
                    id: $id
                }

                $.ajax({
                    url: '<?php echo $root_html?>sistema/clubes_de_ciencia/buscar/desativar.php',
                    type: 'POST',
                    data: data,
                    success: function (data) {
                        $("#confirm"+$id).modal('hide');
                        $('.alerta').hide().show();
                        $('#alerta_conteudo').html(data);

                        setTimeout(function(){ $('.alerta').fadeOut(500).removeClass('alert-success', 500);}, 4000);
                    },
                    complete: function (e) {
                        setTimeout(function(){
                           window.location.reload(0); 
                        }, 400);
                    },
                    error: function (e) {
                        $('#resultado1').html("<option>Nenhum resultado encontrado.</option>");
                    },
                });

            });            

</script>