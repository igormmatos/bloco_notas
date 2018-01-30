<?php
session_start();

if(!isset($_SESSION['logado']))
{
  header("Location: index2.php");
}

require_once ("classes/Nota.php");

$notas = new Notas();

$notas->add();

$notas->informar();


if(isset($_GET['id']))
{
  $notas->delete();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Note+</title>
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="images/favicon-edit.ico" rel="shortcut icon" type="image/x-icon" />

  <!-- Bootstrap -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <!--CKEDITOR-->
  <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
  <!-- Stylesheet
  ================================================== -->
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <!-- <link rel="stylesheet" type="text/css" href="css/prettyPhoto.css"-->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,300' rel='stylesheet' type='text/css'>
  <!-- <script type="text/javascript" src="js/modernizr.custom.js"></script>

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <style>
  #ajuda:hover{
    cursor: pointer;
  }
  .linha{
    border-width: 0 0 0 1px;
    border-color: #E75926;
    border-style: solid;
    height: 100%;
    border-left-width: 4px;
  }
  .pop{
    margin-top: 15px;
    position:absolute;
    width: 220px;
  }
  #user_logout{
    color: #E75926;
  }
  #user_logout:hover{
    color: #fff;
  }
  #footer_url{
    color: #E75926;
  }
  #footer_url:hover{
    color: #333;
  }
  .paginacao{
    color:#E75926 !important;
  }
  li > a.active{
    background-color:#E75926 !important;
    color:#fff !important;
  }
  </style>
</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
  <div id="preloader">
    <div id="status">
      <img src="img/preloader.gif" height="64" width="64" alt="">
    </div>
  </div>
  <!-- Navigation -->
  <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
          <i class="fa fa-bars"></i>
        </button>
        <a class="navbar-brand page-scroll">
          <i class="fa fa-pencil-square-o"></i> Note<b class="small" style="color: #E75926;">+</b><strong style="font-size: 12px">V2.6</strong>
        </a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
        <ul class="nav navbar-nav">
          <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
          <li class="hidden">
            <a href="#page-top"></a>
          </li>
          <li>
            <a class="page-scroll" href="#" data-toggle="modal" data-target="#add_nota">ADICIONAR NOVA NOTA</a>
          </li>
          <li class="pull-right">
            <a class="page-scroll" title= "SAIR" href="logout.php" id="user_logout">@<?php echo $_SESSION['user'];?> <i class="fa fa-sign-out"></i></a>
          </li>
        </ul>
      </div>
      <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
  </nav>

  <!--
  Header
  <div id="intro">
  <div class="intro-body">
  <div class="container">
  <div class="row">
  <div class="col-md-10 col-md-offset-1">
  <h1>NOTE
  <span class="brand-heading">+</span>
</h1>
<p class="intro-text">Adicione notas e lembretes de forma fácil</p>
<button type="button" class="btn btn-default page-scroll" data-toggle="modal" data-target="#add_nota">Nova Nota</button>
<a href="#notas" class="btn btn-default page-scroll">Notas</a>
</div>
</div>
</div>
</div>
</div>

<!-- Notas Section -->
<div id="notas">
  <div class="container">
    <div class="pop">
      <?php if(isset($_SESSION['msg'])) :?>
        <div class="alert <?php echo $_SESSION['alert'];?> fade in " style="margin-top: 15px; position: relative;">
          <a href="#" id="limpar_session" class="close" data-dismiss="alert" aria-label="close"><b>&times;</b></a>
          <?php echo $_SESSION['msg'];?>
        </div>
      <?php endif?>
    </div>
    <div class="section-title text-center center">
      <h2>Todas as notas</h2>
      <hr>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-condensed">
            <thead class="text-right ajuda">
              <tr>
                <th>Legenda Status:</th>
                <th></th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody class="ajuda">
              <tr class="text-center">
                <td class="success">Concluído</td>
                <td class="info">Em andamento</td>
                <td class="danger">Cancelada</td>
                <td class="active">Não Iniciada</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="table-responsive">
          <i id="feedback" class="fa fa-bug pull-left" title="Feedback" style="font-size:24px; margin-bottom: 5px; cursor:pointer;"></i>
          <i id="ajuda" class="fa fa-question-circle-o pull-right" title="Legenda" style="font-size:24px; margin-bottom: 5px;"></i>
          <table class="table table-hover" id="tabela" >
            <?php
            $notas->listar();
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <input type="text" id="input_id" name="input_id" hidden>
  <div id="notas_detalhes">
    <div class="container" id="topo_notas_detalhes">

      <div class="pop">
        <div class="alert alert-success fade in" id="container_msg" style="margin-top: 15px; position: relative;">
          <a href="#" id="fechar" class="close" data-dismiss="alert" aria-label="close"><b>&times;</b></a>
          <b id="msg_alterar"></b>
        </div>
      </div>

      <div class="section-title text-center center">
        <a id="fechar_detalhes" class="close" aria-label="close" style="margin-top: -30px"><h1><b>&times;</b></h1></a>
        <h2 hidden><small>Nota Nº- <b id="id_nota"></b></small></h2>
        <hr hidden>
      </div>
      <div class="row" style="margin-top: 50px">
        <div class="col-md-8" id="area_descricao">
          <div class="row text-center pull-center" style="margin-bottom: 25px;" id="tit_nota">
            <input type="text" class="form-control text-center hidden" id="edit_titulo" style="width:95%"/>
            <h2><strong id="titulo_nota" style="line-height: 115%; margin-right: 6px;"></strong></h2>
          </div>
          <hr style="width:50%"/>
          <div class="row">
            <h5><strong>Descrição:</strong></h5>
          </div>
          <div class="row" id="descricao_nota" style="cursor: context-menu; margin-right: 6px;" title="DUPLO CLIQUE PARA EDITAR">
          </div>
        </div>
        <div class="col-md-4 linha">
          <div class="row" style="margin-left:4px;">
            <h5><strong>Data de Entrega:</strong></h5>
            <input type="date" class="form-control" id="dt_entrega_nota" value="" style="width: 45%" />
          </div>
          <div class="row" id="entrega_nota"  style="margin-left:6px;">
          </div>
          <div class="row" style="margin-left:4px;" >
            <h5><strong>Data de Adição:</strong></h5>
          </div>
          <div class="row" id="adicao_nota" style="margin-left:6px;">
          </div>
          <div class="row" style="margin-left:4px;">
            <h5><strong>Prioridade:</strong></h5>
          </div>
          <div class="row" id="prioridade_nota" style="margin-left:6px;">
            <div class="form-group">
              <select class="form-control" id="prioridade_select" style="width: 100px" name="prioridade_select">
                <option value="0">BAIXA</option>
                <option value="1">MÉDIA</option>
                <option value="2">ALTA</option>
              </select>
            </div>
          </div>
          <div class="row" style="margin-left:4px;">
            <h5><strong>Status:</strong></h5>
          </div>
          <div class="row" id="status_nota" style="margin-left:6px;">
            <div class="form-group">
              <select class="form-control" id="status_select" style="width: 160px" name="status_select">
                <option value="success">CONCLUÍDO</option>
                <option value="info">EM ANDAMENTO</option>
                <option value="danger">CANCELADA</option>
                <option value="active">NÃO INCIADA</option>
              </select>
            </div>
          </div>
          <!--div class="row" style="margin-left:6px;">
          <h5><strong>Ações:</strong></h5>
        </div-->
        <div class="row" id="btnExcluir" style="margin-left:6px;">
          <!--button type="button" class="btn btn-warning small" id="EditarNota">Editar Nota</button-->
          <button type="button" class="btn btn-danger small" id="ExcluirNota">Excluir Nota</button>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
include_once "modal/modal.php";
include_once "modal/modal_editar.php";
include_once "modal/modal_feedback.php";
?>
<script>
var desc = document.getElementById( 'descricao_nota' );
desc.setAttribute( 'contenteditable', true );
CKEDITOR.inline( 'desc', {
  // Allow some non-standard markup that we used in the introduction.
  extraAllowedContent: 'a(documentation);abbr[title];code',
  removePlugins: 'stylescombo',
  extraPlugins: 'sourcedialog',
  // Show toolbar on startup (optional).
  startupFocus: true
} );
</script>
<script type="text/javascript">
window.onload = function()  {
  CKEDITOR.replace( 'descricao' );
  CKEDITOR.replace( 'descricao_feed' );
  $(".ajuda").hide();
  $("#notas_detalhes").hide();
  //$("#notas").hide();
  $('#data_entrega').val("<?php
  $date = Date('Y-m-d');
  echo Date('Y-m-d', strtotime($date. ' + 1 days'))
  ?>");
  $('#data_adicao_feed').val("<?php
  $date = Date('Y-m-d');
  echo Date('Y-m-d', strtotime($date. ' + 1 days'))
  ?>");
};
$(document).ready(function(){
  $("#container_msg").hide();
  $("#btnAdicionar").click(function(){
    var descricao = CKEDITOR.instances['descricao'].getData();
    var titulo = $("#titulo").val();
    if(descricao != "" && titulo != "")
    $("#form").submit();
    else {
      alert("Existem campos vazios..");
      if(descricao == "")
      $("#descricao").focus();
      else if (titulo == "")
      $("#titulo").focus();
    }
  });
  $("#descricao_nota").blur(function(){
    var descricao = CKEDITOR.instances['descricao_nota'].getData();
    var id = $('#id_nota').html();
    if(descricao != "")
    {
      var vUrl = "update.php?id="+id;
      var vData = { descricao:descricao};

      $.post(
        vUrl, //Required URL of the page on server
        vData,
        function(response,status)
        {
          console.log("ok");
        }
      );
      $("#msg_alterar").html("Nota alterada!")
      $("#container_msg").show("fast", "linear");

      setInterval(function(){$("#container_msg").hide("fast", "swing");}, 5000);
    }
    else {
      alert("Existem campos vazios..");
      if(descricao == "")
      $("#descricao_edit").focus();
      else if (titulo == "")
      $("#titulo_editar").focus();
    }
  });
  $("#titulo_nota").dblclick(function(){
    var titulo = $(this).html();
    $("#edit_titulo").val(titulo);
    $(this).html("");
    $("#edit_titulo").removeClass("hidden");
  });
  $("#edit_titulo").blur(function(){
    var titulo = $(this).val();
    var id = $('#id_nota').html();
    if(titulo !="")
    {
      var script_ini = /<script>/g;
      var titulo = titulo.replace(script_ini, "<code>");

      var vUrl = "update.php?id="+id;
      var vData = {titulo:titulo};
      $.post(
        vUrl, //Required URL of the page on server
        vData,
        function(response,status)
        {
          console.log("ok");
        }
      );
      $("#titulo_nota").html(titulo);
      $("#edit_titulo").addClass("hidden");
      $("#msg_alterar").html("Nota alterada!")
      $("#container_msg").show("fast", "linear");

      setInterval(function(){$("#container_msg").hide("fast", "swing");}, 5000);
    }
    else {
      alert("Campo vazio..");
      $("#titulo_editar").focus();
    }
  });
  $("#btnInformar").click(function(){
    var descricao = CKEDITOR.instances['descricao_feed'].getData();
    var titulo = $("#titulo_feed").val();
    var data = $('#data_adicao').val();
    if(descricao != "" && titulo != "" && data != "")
    {
      $("#form_feed").submit();
    }
    else {
      alert("Existem campos vazios..");
      if(descricao == "")
      $("#descricao_edit").focus();
      else if (titulo == "")
      $("#titulo_editar").focus();
    }
  });
  $("#limpar_session").click(function(){
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.open("GET", "limpar_session.php", true);
    xhttp.send();
  });
  <?php if(isset($_SESSION['msg'])) :?>
  setInterval(function(){$("#limpar_session").click();}, 5000);
  <?php endif?>
  $("#ajuda").click(function(){
    $(".ajuda").toggle('fast', 'linear');
  });
  $("#feedback").click(function(){
    $("#feedback_modal").modal();
  });
  $("#ExcluirNota").click(function(){
    if (confirm("Deseja excluir a nota?\n O processo não poderá ser revertido..")) {
      var id = $("#id_nota").html();
      window.location.href = "index.php?id="+id;
    }
  });
  $("tbody").click(function(){
    var id = $(this).attr('id');
    if(id != null)
    {
      $('#input_id').val(id);
      $("#notas_detalhes").show('fast', 'linear');
      $("#notas").hide('fast', 'linear');
      $("#id_nota").html(id);
      $.getJSON("view.php?id=" + id, function(dados) {
        $("#titulo_nota").html(dados.titulo);
        $("#descricao_nota").html(dados.descricao);
        $("#dt_entrega_nota").val(dados.data_entrega);
        $("#adicao_nota").html(formatarDataHora(dados.data_adicao));
        $("#status_select").val(dados.status);
        $("#prioridade_select").val(dados.prioridade);
      });
    }
  });
  $("#fechar_detalhes").click(function(){
    $('#input_id').val('');
    $("#notas_detalhes").hide('fast', 'linear');
    $("#notas").show('fast', 'linear');
    $("#id_nota").html('');
    $("#container_msg").addClass("hidden");
    setInterval(function(){   window.location.reload(); }, 250);
  });
  $("#dt_entrega_nota").change(function(){
    var id = $("#id_nota").html();
    var data = $(this).val();

    var vUrl = "update.php?id="+id;
    var vData = {data:data};

    $.post(
      vUrl, //Required URL of the page on server
      vData,
      function(response,status)
      {
        console.log("ok");
      }
    );
    $("#msg_alterar").html("Nota alterada!")
    $("#container_msg").show("fast", "linear");

    setInterval(function(){$("#container_msg").hide("fast", "swing");}, 5000);
  });
  $("#status_select").change(function(){
    var id = $("#id_nota").html();
    var status = $(this).val();

    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.open("GET", "update.php?id="+id+"&&status="+status, true);
    xhttp.send();

    $("#msg_alterar").html("Status alterado!")
    $("#container_msg").show("fast", "linear");

    setInterval(function(){$("#container_msg").hide("fast", "swing");}, 2500);
  });
  $("#prioridade_select").change(function(){
    var id = $("#id_nota").html();
    var prioridade = $(this).val();

    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.open("GET", "update.php?id="+id+"&&prioridade="+prioridade, true);
    xhttp.send();

    $("#msg_alterar").html("Prioridade alterada!")
    $("#container_msg").show("fast", "linear");
    setInterval(function(){$("#container_msg").hide("fast", "swing");}, 2500);
  });
});

function formatarData(data)
{
  var data_formatar = data.split("-");

  var y = data_formatar[0];
  var m = data_formatar[1];
  var d = data_formatar[2];

  var dataFormatada = d+"/"+m+"/"+y;
  return dataFormatada;
}
function formatarDataAoContrario(data)
{
  var data_formatar = data.split("/");

  var d = data_formatar[0];
  var m = data_formatar[1];
  var y = data_formatar[2];

  var dataFormatada = y+"-"+m+"-"+d;
  return dataFormatada;
}
function formatarDataHora(dataHora)
{

  var separar = dataHora.split(" ");
  var data_formatar = separar[0].split("-");

  var y = data_formatar[0];
  var m = data_formatar[1];
  var d = data_formatar[2];

  var dataHoraFormatada = d+"/"+m+"/"+y+ " " + separar[1];
  return dataHoraFormatada;
}
</script>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script type="text/javascript" src="js/jquery.1.11.1.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/SmoothScroll.js"></script>
<script type="text/javascript" src="js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="js/jquery.isotope.js"></script>
<script type="text/javascript" src="js/jquery.parallax.js"></script>
<script type="text/javascript" src="js/jqBootstrapValidation.js"></script>
<script type="text/javascript" src="js/contact_me.js"></script>

<!-- Javascripts
================================================== -->
<script type="text/javascript" src="js/main.js"></script>
</body>

</html>
