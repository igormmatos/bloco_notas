window.onload = function()  {
  CKEDITOR.replace( 'descricao' );
  $(".ajuda").hide();
  $("#notas_detalhes").hide();
  //$("#notas").hide();
};
$(document).ready(function(){
  $("#container_msg").hide();
  $("#btnAdicionar").click(function(){
    $("#form").submit();
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
        $("#entrega_nota").html(formatarData(dados.data_entrega));
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
