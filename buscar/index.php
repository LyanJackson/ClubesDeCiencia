<?php include '../../../web/seguranca.php'; 

// protegePaginaUnica(3, 901);
protectPage("3;901;902;7;8;");

$title = "AdminPFC - Clubes de Ciência";

if (isset($_GET['p']) && isset($_GET['r'])){
    $p = $_GET['p'];
    $r = $_GET['r'];
}
include '../../head.php';
?>
<body class="hold-transition skin-black sidebar-mini fixed">

    <div class="wrapper">

    <?php include '../../menu.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <?php if(!isset($p)): ?>
                    <a href="<?php echo $root_html ?>sistema/" class="btn btn-default"><i class="fa fa-arrow-left"></i>&ensp;Voltar</a>                
                <?php elseif(isset($p)): ?>
                    <a href="<?php echo $root_html ?>sistema/clubes_de_ciencia/buscar/" class="btn btn-default"><i class="fa fa-arrow-left"></i>&ensp;Voltar</a>                

                <?php endif; ?>
              <ol class="breadcrumb">
                <li><a href="<?php echo $root_html ?>sistema/"><i class="fa fa-dashboard"></i> Home</a></li>
                <li>Clubes de Ciência</li>
                <?php if(!isset($p)): ?>
                <li class="active">Buscar</li>
                <?php elseif(isset($p) && $p == 'editar'): ?>
                <li><a href="<?php echo $root_html ?>sistema/clubes_de_ciencia/buscar/">Buscar</a></li>
                <li class="active">Editar</li>
            <?php endif; ?>
              </ol> 
            </section>
<br><br>

            <div class="container-fluid">

                <?php if (!isset($_GET['p']) && !isset($_GET['r'])):
                ?>

                <form class="alunoCadastro forms-buscar" action="listaClubes.php" method="POST">
                    <h2>
                        <i class="fa fa-search"></i> Busca
                    </h2>
                    <hr>
                    <div class="row"><br>
                        <div class="form-group col-md-6">
                        <label for="nomeclube">Nome do Clube</label>
                            <!-- <label for="busca_nome_clube">Nome do Clube</label> -->
                            <input type="text" id="busca_nome_clube" name="nome_clube" class="form-control input-lg" placeholder="Busque pelo nome do clube de ciência">
                        </div>

                        <div class="form-group col-md-6">
                        <label for="nomeclube">Nome do Projeto</label>
                            <!-- <label for="busca_titulo_projeto">Título do Projeto</label> -->
                            <input type="text" id="busca_titulo_projeto" name="titulo_projeto" class="form-control input-lg" placeholder="Busque pelo título do projeto">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group col-md-6">
                        <!-- =======================================================
                        ============================================================
                        ======================== VISAO SUPERVISOR ==================
                        ============================================================
                        ======================================================== -->

                        <?php if($_SESSION['h'] == 3 OR $_SESSION['h'] == 7 ): 

                        $id = $_SESSION['usuarioID'];
                        if($_SESSION['h'] == 3)
                            $query = "SELECT * FROM supervisores WHERE id_usuario = '$id' LIMIT 1";
                        else
                            $query = "SELECT * FROM secretario_educacao WHERE id_usuario = '$id' LIMIT 1";
                        $res = mysqli_query($_SG['link'], $query);
                        $supervisor = mysqli_fetch_assoc($res);

                        $query_escola = "SELECT id_escola, nome_escola FROM escola WHERE cidade LIKE '".$supervisor['cidade']."'";
                        $result = mysqli_query($_SG['link'], $query_escola);


                        ?> 

                    <?php 
                        if($_SESSION['h'] == 3 OR $_SESSION['h'] == 7){
                            
                            $id = $_SESSION['usuarioID'];

                            if($_SESSION['h'] == 3)
                                $query_aux = mysqli_query($_SG['link'], "SELECT * FROM supervisores WHERE id_usuario = '$id' LIMIT 1");
                            else
                                $query_aux = mysqli_query($_SG['link'], "SELECT * FROM secretario_educacao WHERE id_usuario = '$id' LIMIT 1");                                
                            
                            $supervisor = mysqli_fetch_assoc($query_aux);

                            echo '<input type="hidden" name="supervisorCidade" value="'.$supervisor["cidade"].'">';
                        }
                      ?>
                        
                        
                            <select name="cidade" id="buscaCidade" class="form-control input-lg">
                                <option value="<?php echo $supervisor['cidade'];?>" selected><?php echo $supervisor['cidade'];?></option>
                            </select>

                        
                        
                        <!-------------------------------------------------------------------------------------------->
                        <!-- =======================================================
                        ============================================================
                        ======================== VISAO DIRETOR/ESCOLA ==================
                        ============================================================
                        ======================================================== -->
                        <?php elseif($_SESSION['h'] == 8 ): 

                        $id = $_SESSION['usuarioID'];
                        if($_SESSION['h'] == 8)
                            $query = "SELECT * FROM diretor_escola WHERE id_usuario = '$id' LIMIT 1";
                        
                        $res = mysqli_query($_SG['link'], $query);
                        $dir_esc = mysqli_fetch_assoc($res);

                        ?> 

                    <?php 
                        if($_SESSION['h'] == 8){
                            
                            $id = $_SESSION['usuarioID'];

                            if($_SESSION['h'] == 8)
                            $query_aux = mysqli_query($_SG['link'], "SELECT * FROM diretor_escola WHERE id_usuario = '$id' LIMIT 1");                                                            
                            $dir_esc = mysqli_fetch_assoc($query_aux);

                            echo '<input type="hidden" name="diretorEscola" value="'.$dir_esc["cidade"].'">';
                        }
 ?>
                        
                       
                            <select name="cidade" id="buscaCidade" class="form-control input-lg">
                                <option value="<?php echo $dir_esc['cidade'];?>" selected><?php echo $dir_esc['cidade'];?></option>
                            </select>

                        
                        <!-------------------------------------------------------------------------------------------->

                       <!-- =======================================================
                        ============================================================
                        ========================== VISAO ADMIN =====================
                        ============================================================
                        ======================================================== -->

                        <?php else: 

                        $escola = mysqli_query($_SG['link'], "SELECT DISTINCT cidade FROM escola ORDER BY cidade");

                        ?>
                        <label for="cidade">Cidade</label>
        
                            <select class="form-control input-lg" name="cidade" id="cidade">
                                <option value="" hidden>Escolha uma cidade</option>
                                <option value="todas">Todas</option>
                                <?php
                                while ($e = mysqli_fetch_array($escola)) {
                                    echo '<option value="' . $e['cidade'] . '">' . $e['cidade'] . '</option>';
                                }
                                ?>
                            </select>

                        <?php endif; ?>
                        <!-------------------------------------------------------------------------------------------->
                            
                        </div>

                        <div class="form-group col-md-6">
                        <label for="ano">Ano</label>
                            <select name="ano" id="ano" class="form-control input-lg">
                            <option value="" hidden>Selecione um ano</option>
                            <option value="all">Todos</option>
                            <?php 
                                $sql = "SELECT DISTINCT ano FROM clubes_de_ciencia ORDER BY ano";
                                $res = mysqli_query($_SG['link'], $sql);
                                while ($row = mysqli_fetch_assoc($res)) {
                                    echo '<option value="'.$row["ano"].'">'.$row["ano"].'</option>';
                                }
                             ?>
                        </select>
                            
                        </div>
             
                    
<!-------------------------------------------------------------------------------------------->

                    <div class="form-group col-md-6">
                            <label for="escola">Escola</label>
                            <option value="" hidden>Selecine uma Escola</option>
                            <select name="escola" id="escola" class="form-control text-uppercase">
                                            <option value="" selected>Selecione uma cidade antes</option>
        
         <script>
           $('#cidade').change(function(event) {
			
            var data = {
                cidade: $(this).val()
            }
    
            $.ajax({
                url: '<?php echo $root_html ?>sistema/clubes_de_ciencia/buscar/busca_escola.php',
                type: 'POST',
                data: data,
            })
            .done(function(data) {
                $('#escola').html(data);
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
        
        });

       </script>                            
                            </select>
        </div>
             
<!-------------------------------------------------------------------------------------------->
                           

                    <div class="form-group col-md-6">
                        <label for="busca_integrantes">Integrantes</label>
                        <input type="text" id="busca_integrantes" name="integrantes" class="form-control input-lg" placeholder=" Começe a digitar o nome do aluno e em seguida selecione-o na lista abaixo." >
                    </div>

                
<!-------------------------------------------------------------------------------------------->
                           
                    <div class="form-group col-md-6">
                    <label for="busca_integrantes">Nota</label>
                    <select name="notass" id="notass" class="form-control input-lg">
                            <option value="" hidden>Selecione uma opção</option>
                            <option id="maior" value="maior">Maior Nota</option>
                            <option id="menor" value="menor">Menor Nota</option>
                            </select>
                    </div>

                    <div class="form-group col-md-6">
                    <label for="busca_integrantes">Supervisor</label>
                    <input type="supervisor" id="supervisor" name="supervisor" class="form-control input-lg" placeholder=" Começe a digitar o nome do supervisor." >
                    </div>

                    </div>

                    <div class="row">
                        <div  align="center" class="col-md-4">
                            <select name="qtd_resultados" id="qtd_resultados" class="form-control">
                                <option value="50">50 resultados</option>
                                <option value="100">100 resultados</option>
                                <option value="200">200 resultados</option>
                                <option value="500">500 resultados</option>
                                <option value="all">Todos resultados</option>
                            </select>
                        </div>
                    </div>
					
					<div class="row">
						<div class="col-md-12 text-center">
	                    	<button class="btn btn-default" type="submit" id="obter_lista"><i class="fa fa-print"></i> IMPRIMIR</button>
						</div>
					</div>

                </form>


    <div align="center" class="row">
                    <div  id="resultado" class="container">

<?php 

$city = $_SESSION['supervisorCidade'];
$city2 = $_SESSION['diretorEscola'];

if($_SESSION['h'] == 3 OR $_SESSION['h'] == 7)
    $query = "SELECT * FROM clubes_de_ciencia WHERE cidade LIKE '$city' ORDER BY nome_clube LIMIT 50";
elseif($_SESSION['h'] == 8){
    $query = "SELECT * FROM clubes_de_ciencia, escola WHERE clubes_de_ciencia.cidade = escola.cidade AND escola.id_escola LIKE '". $dir_esc['id_escola'] ."' ORDER BY nome_clube LIMIT 50";
    
}else{

    $query = "SELECT * FROM clubes_de_ciencia ORDER BY nome_clube LIMIT 50";
}

if($_SESSION['h'] == 3 OR $_SESSION['h'] == 7)
    $query_todos = "SELECT count(*) AS qtd_total FROM clubes_de_ciencia WHERE cidade LIKE '$city'";
else
    $query_todos = "SELECT count(*) AS qtd_total FROM clubes_de_ciencia";

$todos = mysqli_fetch_assoc(mysqli_query($_SG['link'], $query_todos))['qtd_total'];
echo mysqli_error();

//echo '<p>'.$query.'</p>'; 
$resultado = mysqli_query($_SG['link'], $query);

echo '<br><p class="text-left">Exibindo <b>'.mysqli_num_rows($resultado).'</b>, de <b>'.$todos.'</b> resultados.</p><hr>';

if (mysqli_num_rows($resultado) != 0){
    while ($clube = mysqli_fetch_assoc($resultado)) {

            echo '<div class="alunoContainer">

                <div align="left" class="alunoNome pull-left col-md-8">
                    
                    <h3 class="">'.$clube['nome_clube'].'</h3>';

                    echo '<p style="font-size: 1.1em;"><b>Título do Projeto:</b> '.$clube['titulo_projeto'].' <br> <b>Ano:</b> '.$clube['ano'].'
                        ';


                    echo '<br><b>Escola:</b> '.$clube["escola"].'
                    <br><b>Cidade:</b> '.$clube["cidade"].'
                    <br><b>Supervisor:</b> '.$clube["nomesup"].'
                        <br><b>Integrantes:</b> '.$clube["integrantes"].'
                        <br><b>Nota 1º Fase:</b> '.$clube["nota_fase1"].'
                        <br><b>Nota 2º Fase:</b> '.$clube["nota_fase2"].'
                        <br><b>Média das Duas Fases:</b> '.$clube["media"].'
                    </p>
                </div>
                
                
                 <div class="alunoMenu pull-right col-md-2">
                 <a href="?p=editar&r='.$clube['id'].'" class="btn btn-warning btn-block"><span class="pull-left glyphicon glyphicon-pencil"></span> Editar</a>';

         
                 
                        
                if($_SESSION['h'] != 7 AND $_SESSION['h' != 8]):
                        // Botão de excluir
                        echo '<button data-toggle="modal" data-target="#confirm'.$clube['id'].'" class="btn btn-danger btn-block"><span class="pull-left glyphicon glyphicon-trash"></span>&ensp;Excluir</button>';
                        echo '<form class="formsHidden'.$clube['id'].'">
                            <input type="hidden" value="'.$clube['id'].'" name="id" />
                            <input id="input'.$clube['id'].'" type="hidden" value="'.$clube['id'].'" name="ativo" />';
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


                    echo '</form>';

                echo '</div>

            </div>';

        }
} else {

        echo "<br><br><div class='alert alert-danger'> <span class='glyphicon glyphicon-exclamation-sign'></span> Nenhum resultado encontrado</div>";
}
?>

                    </div>           
                </div>   
                <?php elseif($p == 'editar'):

                    $r = $_GET['r'];

                    $query = "SELECT * FROM clubes_de_ciencia WHERE id = '$r'";

                    $result = mysqli_query($_SG['link'], $query);
                    $row = mysqli_fetch_assoc($result);
                ?>
                    <h3>Clube de Ciência</h3>
                    <hr>

                    <?php if($_SESSION['h'] == 7 || $_SESSION['h'] == 8): ?>
                        <script>
                            jQuery(document).ready(function($) {
                                $('input, select').attr('disabled', 'true');
                                $('button').hide();
                            });
                        </script>
                    <?php endif; ?>

                <form id="forms-cadastro" enctype="multipart/form-data" method="POST" action="cadastrar.php" class="alunoCadastro">
                                        <div class="form-group">
                        <label for="titulo_projeto">Título do Projeto</label>
                        <input type="text" id="titulo_projeto" name="titulo_projeto" class="form-control" value="<?php echo $row['titulo_projeto'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="nome_clube">Nome do Clube</label>
                        <input type="text" id="nome_clube" name="nome_clube" class="form-control" value="<?php echo $row['nome_clube'] ?>">
                    </div>
                    
                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="ano">Ano</label>
                            <input type="text" id="ano" name="ano" class="form-control" value="<?php echo $row['ano'] ?>">
                            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="cidade">Cidade</label>
                            <select name="cidadee" id="cidadee" class="form-control">
                            <option value="" hidden>Selecine uma cidade</option>
                                <?php 
                                    $sql = "SELECT DISTINCT cidade FROM escola WHERE ativo = 1 ORDER BY cidade";
                                    $result = mysqli_query($_SG['link'], $sql);

                                    while($res = mysqli_fetch_assoc($result)):
                                 ?>
                                    <option value="<?php echo $res['cidade'] ?>" <?php echo ($row['cidade'] == $res['cidade']) ? 'selected' : '' ?>><?php echo $res['cidade'] ?></option>

        
                                <?php endwhile; ?>                                
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="escolae">Escola</label>
                            <option value="" hidden>Selecine uma Escola</option>
                            <select name="escolae" id="escolae" class="form-control text-uppercase">
                                            <option value="" selected>Selecione uma cidade antes</option>
                                          
                                 
         <script>
           $('#cidadee').change(function(event) {
			
            var data = {
                cidade: $(this).val()
            }
    
            $.ajax({
                url: '<?php echo $root_html ?>sistema/clubes_de_ciencia/buscar/busca_escola.php',
                type: 'POST',
                data: data,
            })
            .done(function(data) {
                $('#escolae').html(data);
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
        
        });
       </script>           
       
       <?php

    // código para buscar as escolas do banco de dados
        // verifica se a escola atual é a mesma que a escola armazenada no banco de dados
        $selected = ($row['escola'] == $escola) ? 'selected' : '';
        echo '<option value="' . $row['escola'] . '" ' . $selected . '>' . $row['nome_escola'] . '</option>';

?>

                            </select>
                        </div>
             
                        <div class="form-group col-md-6">
                            <label for="nomesup">Supervisor</label>
                            <input type="text" id="nomesup" name="nomesup" class="form-control" placeholder="Digite o nome do supervisor responsável" value="<?php echo $row['supervisor'] ?>">
                        </div>

                    </div>


                    
                    <div class="form-group">
                        <label for="integrantes">Integrantes</label>
                        <input type="text" id="integrantes" name="integrantes" class="form-control" value="<?php echo $row['integrantes'] ?>">
                        <p class="help-block">Começe a digitar o nome do aluno e em seguida selecione-o na lista abaixo.</p>                        
                    </div>
                    <!----------------------------------------->

                    <div class="form-group col-md-6">
                        <label for="integrante1">Integrante 1</label>
                        <input type="text" id="integrante1" name="integrante1" class="form-control" value="<?php echo $row['integrante1'] ?>">
                        <p class="help-block">Começe a digitar o nome do aluno e em seguida selecione-o na lista abaixo.</p>                        
                    </div>
                    <!----------------------------------------->
                    <div class="form-group col-md-6">
                        <label for="integrante2">Integrante 2</label>
                        <input type="text" id="integrante2" name="integrante2" class="form-control" value="<?php echo $row['integrante2'] ?>">
                        <p class="help-block">Começe a digitar o nome do aluno e em seguida selecione-o na lista abaixo.</p>                        
                    </div>
                    <!----------------------------------------->
                    <div class="form-group col-md-6">
                        <label for="integrante3">Integrante 3</label>
                        <input type="text" id="integrante3" name="integrante3" class="form-control" value="<?php echo $row['integrante3'] ?>">
                        <p class="help-block">Começe a digitar o nome do aluno e em seguida selecione-o na lista abaixo.</p>                        
                    </div>
                    <!----------------------------------------->
                    <div class="form-group col-md-6">
                        <label for="integrante4">Integrante 4</label>
                        <input type="text" id="integrante4" name="integrante4" class="form-control" value="<?php echo $row['integrante4'] ?>">
                        <p class="help-block">Começe a digitar o nome do aluno e em seguida selecione-o na lista abaixo.</p>                        
                    </div>
                    <!----------------------------------------->
                    <div class="form-group col-md-6">
                        <label for="integrante5">Integrante 5</label>
                        <input type="text" id="integrante5" name="integrante5" class="form-control" value="<?php echo $row['integrante5'] ?>">
                        <p class="help-block">Começe a digitar o nome do aluno e em seguida selecione-o na lista abaixo.</p>                        
                    </div>
                    <!----------------------------------------->
                    <div class="form-group col-md-6">
                        <label for="integrante6">Integrante 6</label>
                        <input type="text" id="integrante6" name="integrante6" class="form-control" value="<?php echo $row['integrante6'] ?>">
                        <p class="help-block">Começe a digitar o nome do aluno e em seguida selecione-o na lista abaixo.</p>                        
                    </div>
                    <!----------------------------------------->

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="nota_fase1">Nota da 1° fase</label>
                            <input type="text" id="nota_fase1" name="nota_fase1" class="form-control" value="<?= $row['nota_fase1'] ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nota_fase2">Nota da 2° fase</label>
                            <input type="text" id="nota_fase2" name="nota_fase2" class="form-control" value="<?= $row['nota_fase2'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="link_video">Link do video</label>
                        <input type="text" id="link_video" name="link_video" class="form-control" value="<?php echo $row['link_video'] ?>">
                    </div>

                    <div class="text-center col-md-12">
                        <button id="salvar-clube" type="button" class="btn btn-lg btn-primary">
                            Salvar
                        </button>
                    </div>
                </form>

                <h3>Upload de Arquivos</h3>
                <hr>
                    <div class="row">
                        <form id="formDoc" action="../adicionarDocumento.php" enctype="multipart/form-data" method="POST">
                            <div  class="form-group col-md-6" >
                                <label for="doc">Documento</label>
                                <input type="file" id="doc" name="doc" class="form-control">
                                <p class="help-block">Envie o documento referente ao projeto do clube "<?php echo $row['nome_clube']; ?>"</p>
                                <button data-id="<?php echo $r ?>" id="adicionarDocs" class="btn btn-primary">Enviar</button>
                            </div>
                        </form>

                        <div class="form-group col-md-6">
                            <form id="formFotos" action="../adicionarFotos.php" enctype="multipart/form-data" method="POST">

                                <label for="fotos">Anexar fotos</label>
                                <input type="file" id="fotos" name="fotos[]" class="form-control" multiple="multiple">
                                <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                <p class="help-block">Selecione todas as fotos de uma só vez</p>
                                <button data-id="<?php echo $r ?>" id="adicionarFotos" class="btn btn-primary">Enviar</button>
                            </form>
                        </div>
                    </div><br>
                    <h3>Download de Arquivos</h3>
                    <hr>
                        <div class="col-md-6" align="center">
                            <h4 class="text-bold">Documento</h4>
                            <?php
                                if($row['resumo'] != ""):
                             ?>
                            <a download href="../documentos/<?php echo $row['resumo'] ?>"><i class="fa fa-3x fa-file-word-o"></i></a>
                        <?php else: ?>
                            <div class="alert alert-warning"><i class="fa fa-warning"></i> Nenhum documento enviado</div>
                        <?php endif; ?>
                        </div>
                        <div class="col-md-6" align="center">
                            <h4 class="text-bold">Fotos</h4>
                            <?php 
                                if($row['fotos'] != ""){
        
                                    $fotos = explode(",", $row['fotos']);

                                    for($i = 0, $cont = 0; $i < count($fotos); $i++){

                                        $file = $root_html.'img/clubes_de_ciencia/'.$row['id'].'-'.$i.'.jpg';

                                        echo '<a download class="fa-2x" href="'.$file.'">'.($i+1).') <i class="fa fa-file-image-o"></i>&ensp;</a>';

                                        if($cont == 3){
                                            echo '<br><br>';
                                            $cont = 0;
                                        }
                                        else
                                            $cont++;
                                    }
                                }
                                else {
                                    echo '<div class="alert alert-warning"><i class="fa fa-warning"></i> Nenhuma foto enviada</div>';
                                }

                             ?>
                        </div>
                        <br><br><br>
                    <h3>Galeria de fotos</h3>
                    <hr>

                    <div id="galeria_fotos">
                        <div class="container-fluid">
                        <?php 
                        if($row['fotos'] != ""){
                            
                            $fotos = explode(",", $row['fotos']);


                            for($i = 0, $cont = 0; $i < count($fotos); $i++){
                                $file = $_SERVER["DOCUMENT_ROOT"].$root_html.'img/clubes_de_ciencia/'.$row['id'].'-'.$i.'.jpg';


                                if(file_exists($file)){

                                    if($cont == 0){
                                        echo '<div class="row" style="margin-top: 15px;">';
                                    }
                                    
                                    echo '<div class="col-md-3">';
                                        echo '<button data-id="'.$row['id'].'" data-nome="'.$row['id'].'-'.$i.'.jpg" class="hidden btn btn-circle alert-danger btn-excluir-foto" type="button" style="position: absolute; top: -15px; right: 5px;"><i class="fa fa-times fa-1x"></i></button>';
                                        echo '<img src="../../../../img/clubes_de_ciencia/'.$row['id'].'-'.$i.'.jpg" alt="" class="img-responsive"/>';
                                    echo '</div>';


                                    if($cont == 3){
                                        echo '</div>';
                                        $cont = 0;
                                    }
                                    else
                                        $cont++;
                                }
                                else
                                    continue;
                            }
                        }
                        else {
                        }
                         ?>
                        </div>
                     </div>
                </form>

                <?php endif; ?>

            </div>
        </div>

    </div>

    <?php include '../../footer.php'; ?>
<?php 
    if($_SESSION['h'] == 3 || $_SESSION['h'] == 7 ){
        $cidade = $_SESSION['supervisorCidade'];
        $query = "SELECT DISTINCT u.nome FROM alunos AS a JOIN usuario AS u ON u.id_usuario = a.id_usuario JOIN escola AS e ON e.id_escola = a.id_escola WHERE u.h <> 0 AND e.cidade = '".$cidade."' ORDER BY u.nome";
    }
    else {
        $query = "SELECT DISTINCT u.nome FROM alunos AS a JOIN usuario AS u ON u.id_usuario = a.id_usuario WHERE u.h <> 0 ORDER BY u.nome";
    }
    $res = mysqli_query($_SG['link'], $query);
    $total = mysqli_num_rows($res);
    $i = 0;
    $alunos = "";
    while($aluno = mysqli_fetch_assoc($res)){
        $alunos .= "\"";
        $alunos .= html_entity_decode($aluno['nome']);
        $alunos .= "\"";
        if($i != $total-1)
            $alunos .= ", ";
        $i++;
    }
 ?>


<script type="text/javascript">


            $("#salvar-clube").click(function(event) {
                event.preventDefault();

                var data = $('#forms-cadastro').serialize();

                $.ajax({
                    url: '<?php echo $root_html?>sistema/clubes_de_ciencia/buscar/editar.php',
                    type: 'POST',
                    data: data,
                })
                .done(function(form) {
                    $('.alerta').show().addClass('alert-success');
                    $('#alerta_conteudo').html(form);

                    setTimeout(function(){ $('.alerta').fadeOut(500).removeClass('alert-success', 500);}, 4000);

                    window.location.reload();
                })
                .fail(function() {
                    console.log("error");
                })
                .always(function() {
                    console.log("complete");
                });
                
            });

            $('#formDoc').submit(function(event) {

                event.preventDefault();

                var form = new FormData(this);

                $id = $("#adicionarDocs").attr("data-id");

                form.append('id', $id);

                $.ajax({
                url: '<?php echo $root_html?>sistema/clubes_de_ciencia/buscar/adicionarDocumento.php',
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                data: form,
                xhr: function() {  // Custom XMLHttpRequest
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                        myXhr.upload.addEventListener('progress', function () {
                           /* faz alguma coisa durante o progresso do upload */
                        }, false);
                    }
                return myXhr;
                }
                })
                .done(function(form) {
                    $('.alerta').show().addClass('alert-success');
                    $('#alerta_conteudo').html(form);

                    setTimeout(function(){ $('.alerta').fadeOut(500).removeClass('alert-success', 500);}, 4000);
                })
                .fail(function() {
                    console.log("error");
                })
                .always(function() {
                    console.log("complete");
                });


            });

            $('#formFotos').submit(function(event) {

                event.preventDefault();

                var form = new FormData(this);
                
                $id = $("#adicionarFotos").attr("data-id");

                form.append('id', $id);

                $.ajax({
                url: '<?php echo $root_html?>sistema/clubes_de_ciencia/buscar/adicionarFotos.php',
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                data: form,
                xhr: function() {  // Custom XMLHttpRequest
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                        myXhr.upload.addEventListener('progress', function () {
                           /* faz alguma coisa durante o progresso do upload */
                        }, false);
                    }
                return myXhr;
                }
                })
                .done(function(form) {
                    $('.alerta').show().addClass('alert-success');
                    $('#alerta_conteudo').html(form);

                    setTimeout(function(){ $('.alerta').fadeOut(500).removeClass('alert-success', 500);}, 4000);

                    setTimeout(function(){
                        window.location.reload();
                    }, 1000)
                })
                .fail(function() {
                    console.log("error");
                })
                .always(function() {
                    console.log("complete");
                });
            });


            $('.btn-excluir-foto').click(function() {
                $nome = $(this).attr("data-nome");
                $id = $(this).attr("data-id");

                var data = {
                    nome: $nome,
                    id: $id
                }

                $.ajax({
                    url: '<?php echo $root_html?>sistema/clubes_de_ciencia/buscar/excluir_foto.php',
                    type: 'POST',
                    data: data,
                })
                .done(function(data) {
                    $("#galeria_fotos").html(data);
                })
                .fail(function() {
                    $("#galeria_fotos").html(data);
                });
                
            });
            
            $('#busca_titulo_projeto, #busca_nome_clube, #supervisor').keyup(function () {
                
                var data = $(".alunoCadastro").serialize();

                $.ajax({
                    url: '<?php echo $root_html ?>sistema/clubes_de_ciencia/buscar/buscar.php',
                    type: 'POST',
                    data: data,
                    success: function (data) {
                        $('#resultado').html(data);
                    },
                    error: function (e) {
                        $('#resultado').html("<option>Nenhum resultado encontrado.</option>");

                    }
                });

            });
            
            $('#busca_integrantes, #notass, #ano, #cidade, #escola, #qtd_resultados').change(function () {
                
                var data = $(".alunoCadastro").serialize();

                $.ajax({
                    url: '<?php echo $root_html ?>sistema/clubes_de_ciencia/buscar/buscar.php',
                    type: 'POST',
                    data: data,
                    success: function (data) {
                        $('#resultado').html(data);
                    },
                    error: function (e) {
                        $('#resultado').html("<option>Nenhum resultado encontrado.</option>");

                    }
                });

            });
            
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

            $("#integrante1, #integrante2, #integrante3, #integrante4, #integrante5, #integrante6, #busca_integrantes").tagit({
                availableTags: [<?php echo $alunos ?>],
                autocomplete: {
                    delay: 0,
                    minLenght: 2
                },
                showAutocompleteOnFocus: false,
                allowSpaces: true
            });
</script>

</body>
</html>