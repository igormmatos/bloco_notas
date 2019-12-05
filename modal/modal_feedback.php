<!-- Modal -->
<div class="modal fade" id="feedback_modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Informar Bugs, Sugestões, Críticas</h4>
      </div>
      <div class="modal-body">
        <form action="index.php" method="post" id="form_feed">
          <div class="form-group">
            <label for="titulo">Bugs, Sugestões, Críticas:</label>
            <input type="text" class="form-control" id="titulo_feed" name="feed[titulo_feed]" maxlength="150" required>
          </div>
          <div class="form-group">
            <label for="descricao">Descrição:</label><br><br>
            <textarea class="form-control" id="descricao_feed" name="feed[descricao_feed]" style="resize: none" required></textarea>
          </div>
          <div class="form-group" hidden>
            <label for="data_entrega">Data Entrega :</label>
            <input type="date" class="form-control" id="data_adicao_feed" name="feed[data_entrega_feed]" value="" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <input type="button" class="btn btn-default" value="Informar" id="btnInformar" required>
      </div>
    </div>

  </div>
</div>
