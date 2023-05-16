<?php include '../../../web/seguranca.php';

if($_SESSION['h'] == 1 AND $_GET['r'] != $_SESSION['usuarioID']){
    echo '<script>alert("Ops... Você não pode editar o perfil do amiguinho...")</script>';
    expulsaVisitante();
}
elseif($_SESSION['h'] != 1){
    protectPage("3;901;902");
}

$title = "AdminPFC - Clubes de Ciência";

$query = "SELECT * FROM alunos AS a JOIN escola AS e ON e.id_escola = a.id_escola JOIN usuario AS u ON u.id_usuario = a.id_usuario WHERE (u.h = 0 OR u.h = 1 OR u.h = 4) AND a.id_usuario = " . $r . " ";
$result2 = mysqli_query($_SG['link'], $query);


include '../../head.php';
?>
<body class="hold-transition skin-black sidebar-mini fixed">

	<div class="wrapper">

	<?php include '../../menu.php'; ?>
		<div class="content-wrapper">

            <section class="content-header">
                <a href="<?php echo $root_html ?>sistema/" class="btn btn-default"><i class="fa fa-arrow-left"></i>&ensp;Voltar</a>                
              <ol class="breadcrumb">
                <li><a href="<?php echo $root_html ?>sistema/"><i class="fa fa-dashboard"></i> Home</a></li>
                <li>Clubes de Ciência</li>
                <li class="active">Cadastrar</li>
              </ol> 
            </section>
<br><br>

        	<div class="container-fluid" style="width: 80%;">

				
				<form id="forms-cadastro" enctype="multipart/form-data" method="POST" action="cadastrar.php" class="alunoCadastro forms-cadastrar">
					<h1 class="text-center">Ficha de Cadastro <br><small>Clube de Ciência</small></h1>
					<hr><br>

					<div class="form-group">
						<label for="titulo_projeto">Título do Projeto</label>
						<input type="text" id="titulo_projeto" name="titulo_projeto" class="form-control" placeholder="Digite o título do projeto de pesquisa">
					</div>

					<div class="form-group">
						<label for="nome_clube">Nome do Clube</label>
						<input type="text" id="nome_clube" name="nome_clube" class="form-control" placeholder="Digite o nome do clube de ciências">
					</div>

                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="ano">Ano</label>
                            <!-- <input type="text" id="ano" name="ano" class="form-control" value="<?php echo $row['ano'] ?>"> -->
                            <select name="ano" id="ano" class="form-control">
                            	<option value="" hidden>Selecione um ano</option>
                            	<?php for($ano = date('Y'); $ano >= '2010'; $ano--){
                            		echo '<option value="'.$ano.'">'.$ano.'</option>';
                            	} ?>
                            </select>
                            <!-- <input type="hidden" name="id" value="<?php echo $row['id'] ?>"> -->
                        </div>

                        <div class="form-group col-md-6">
                            <label for="cidade">Cidade</label>
                            <select name="cidade" id="cidade" class="form-control">
                            <option value="" hidden>Selecine uma cidade</option>
                                <?php 
                                    $sql = "SELECT DISTINCT cidade FROM escola WHERE ativo = 1 ORDER BY cidade";
                                    $result = mysqli_query($_SG['link'], $sql);

                                    while($res = mysqli_fetch_assoc($result)):
                                 ?>
                                    <option value="<?php echo $res['cidade'] ?>"><?php echo $res['cidade'] ?></option>

        
                                <?php endwhile; ?>                                
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
						<label for="escola">Escola</label>
						<select name="escola" id="escola" class="form-control">
						<option value="" selected>Selecione uma cidade antes</option>
										
					</select>
					</div>
                        
		
             
                        <div class="form-group col-md-6">
                            <label for="nomesupervisor">Supervisor</label>
                            <input type="text" id="nomesup" name="nomesup" class="form-control" placeholder="Digite o nome do supervisor responsável">
                        </div>


                    </div>

                    <hr>
                  
					<div class="col-md-6 form-group">
                    <br>
						<label for="integrante1">Integrante 1</label>
						<input type="text" id="integrante1" name="integrante1" class="form-control">
                        <p class="help-block">
	                    	Começe a digitar o nome do aluno e em seguida selecione-o na lista.
                            <br>
                            <b><span style="color: red">*</span> O ALUNO DEVE ESTAR CADASTRADO NO SISTEMA PARA APARECER NA LISTA!!!!!</b>
                    	</p>						
					</div>
                    <!------------------------------------------------------------------------------------------------------------------------------------>
                    <div class="col-md-6 form-group">
                    <br>
						<label for="integrante2">Integrante 2</label>
						<input type="text" id="integrante2" name="integrante2" class="form-control">
                        <p class="help-block">
	                    	Começe a digitar o nome do aluno e em seguida selecione-o na lista.
                            <br>
                            <b><span style="color: red">*</span> O ALUNO DEVE ESTAR CADASTRADO NO SISTEMA PARA APARECER NA LISTA!!!!!</b>
                    	</p>						
					</div>
                    <!------------------------------------------------------------------------------------------------------------------------------------>
                    <div class="col-md-6 form-group">
						<label for="integrante3">Integrante 3</label>
						<input type="text" id="integrante3" name="integrante3" class="form-control">
                        <p class="help-block">
	                    	Começe a digitar o nome do aluno e em seguida selecione-o na lista.
                            <br>
                            <b><span style="color: red">*</span> O ALUNO DEVE ESTAR CADASTRADO NO SISTEMA PARA APARECER NA LISTA!!!!!</b>
                    	</p>						
					</div>
                    <!------------------------------------------------------------------------------------------------------------------------------------>
                       <div class="col-md-6 form-group">
						<label for="integrante4">Integrante 4</label>
						<input type="text" id="integrante4" name="integrante4" class="form-control">
                        <p class="help-block">
	                    	Começe a digitar o nome do aluno e em seguida selecione-o na lista.
                            <br>
                            <b><span style="color: red">*</span> O ALUNO DEVE ESTAR CADASTRADO NO SISTEMA PARA APARECER NA LISTA!!!!!</b>
                    	</p>						
					</div>
                    <!------------------------------------------------------------------------------------------------------------------------------------>
                      <div class="col-md-6 form-group">
						<label for="integrante5">Integrante 5</label>
						<input type="text" id="integrante5" name="integrante5" class="form-control">
                        <p class="help-block">
	                    	Começe a digitar o nome do aluno e em seguida selecione-o na lista.
                            <br>
                            <b><span style="color: red">*</span> O ALUNO DEVE ESTAR CADASTRADO NO SISTEMA PARA APARECER NA LISTA!!!!!</b>
                    	</p>						
					</div>
                    <!------------------------------------------------------------------------------------------------------------------------------------>
                     <div class="col-md-6 form-group">
						<label for="integrante6">Integrante 6</label>
						<input type="text" id="integrante6" name="integrante6" class="form-control">
                        <p class="help-block">
	                    	Começe a digitar o nome do aluno e em seguida selecione-o na lista.
                            <br>
                            <b><span style="color: red">*</span> O ALUNO DEVE ESTAR CADASTRADO NO SISTEMA PARA APARECER NA LISTA!!!!!</b>
                    	</p>						
					</div>
                    <!------------------------------------------------------------------------------------------------------------------------------------>
              

					<div class="row">     
                         <hr>
                         <br>
                        <div class="form-group col-md-6">
                            <label for="nota_fase1">Nota da 1° fase</label>
                            <input type="text" id="nota_fase1" name="nota_fase1" class="form-control" value="<?= $row['nota_fase1'] ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nota_fase2">Nota da 2° fase</label>
                            <input type="text" id="nota_fase2" name="nota_fase2" class="form-control" value="<?= $row['nota_fase2'] ?>">
                        </div>
                    </div>
					<br>
                    <div class="form-group">
                        <label for="link_video">Link do video</label>
                        <input type="text" id="link_video" name="link_video" class="form-control" value="<?php echo $row['link_video'] ?>">
                    </div>
					<br>
					<div class="text-center">
						<button id="salvarCadastro" type="submit" value="Cadastrar" class="btn btn-primary btn-lg">
							Cadastrar
						</button>	
						<input type="reset" class="btn btn-default pull-right">		
					</div>
				</form>
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
		$query = "SELECT DISTINCT * FROM usuario WHERE (h = 1 OR h = 3 OR h = 4) ORDER BY nome";
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
	tinymce.init({
	  selector: 'textarea',
	  height: 250,
	  menubar: false,
	  placeholder: true,
	  relative_urls : false,
   	  remove_script_host : true,	
	  plugins: [
	    'advlist autolink lists link image imagetools jbimages charmap print preview anchor',
	    'searchreplace visualblocks code fullscreen',
	    'insertdatetime media table contextmenu paste code'
	  ],
	  toolbar: 'undo redo | insert | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link jbimages',
	  content_css: [
	    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
	    '//www.tinymce.com/css/codepen.min.css']
	});

	
	$('#telefone').mask('(00) 0000-0000');
	$('#celular').mask('(00) 00000-0000');
	$('#data-inscricao-inicio').mask('00/00/0000');
	$('#data-inscricao-final').mask('00/00/0000');
   
   
	$('#cidade').change(function() {


    var values = {
    'cidade': $('#cidade').val()
     };
   $.ajax({
    url: '<?php echo $root_html ?>sistema/clubes_de_ciencia/cadastrar/busca_escola.php',
    type: 'POST',
    data: values,
    success: function(data) {
        $('#escola').html(data);

    },
    error: function(e) {
        $('#escola').html("<option>Nenhum resultado encontrado.</option>");

    }
   });


    });

    
	$('').click(function(event){
		
		tinyMCE.triggerSave();

		var data = $('#forms-cadastro').serialize();

        $.ajax({
            url: '<?php echo $root_html?>sistema/clubes_de_ciencia/cadastrar/cadastrar.php',
            type: 'POST',
            data: data,
            complete: function() {
                //setTimeout(function(){ location.href = '../';}, 500);
            },
            success: function (data) {
                $('.alerta').show().addClass('alert-success');
                $('#alerta_conteudo').html(data);

                setTimeout(function(){ $('.alerta').fadeOut(500).removeClass('alert-success', 500);}, 4000);
            },
            error: function (e) {
                $('.alerta').show().addClass('alert-danger');
                $('#alerta_conteudo').html("<span class='glyphicon glyphicon-remove'></span>&ensp;Nenhum resultado encontrado");

                setTimeout(function(){ $('.alerta').fadeOut(500).removeClass('alert-danger', 500);}, 4000);
            }
        });
    })

       
    $('#imagem_upload').click(function () {

        var form = $('#forms-cadastro')[0]; // You need to use standart javascript object here
        var data = new FormData(form);

        data.append('tax_file', $('input[type=file]')[0].files[0]);

        $.ajax({
            url: '<?php echo $root_html;?>sistema/maratona-do-conhecimento/cadastrar/upload_image.php',
            type: 'POST',
            data: data,
            contentType: false,
            processData: false,
            success: function (data) {
                $('.alerta').show();
                $('.alerta_conteudo').html(data);

                setTimeout(function(){ $('.alerta').fadeOut(500).removeClass('alert-success alert-danger', 500);}, 4000);
            },
            error: function (e) {
                $('.alerta').show().addClass('alert-danger');
                $('.alerta_conteudo').html("<span class='glyphicon glyphicon-remove'></span>&ensp;Nenhum resultado encontrado");

                setTimeout(function(){ $('.alerta').fadeOut(500).removeClass('alert-danger', 500);}, 4000);
            }
        });
    });

	$("#integrante1, #integrante2, #integrante3, #integrante4, #integrante5, #integrante6").tagit({
		availableTags: [<?php echo $alunos ?>],
		autocomplete: {
			delay: 0,
			minLenght: 2
		}
	});
    
</script>

</body>
</html>