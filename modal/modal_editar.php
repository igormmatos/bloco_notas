<!-- Modal -->
<div class="modal fade" id="edit_nota" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Editar Nota</h4>
      </div>
      <div class="modal-body">
        <form action="index.php" method="post" id="form">
          <div class="form-group">
            <label for="titulo">Título :</label>
            <input type="text" class="form-control" id="titulo_editar" name="notas[titulo]" maxlength="150" required>
          </div>
          <div class="form-group">
            <label for="descricao">Descrição  :</label><br><br>
            <textarea class="form-control editor" id="descricao_edit" name="notas[descricao]" style="resize: none" required></textarea>
          </div>
          <div class="form-group">
            <label for="data_entrega">Data Entrega :</label>
            <input type="date" class="form-control" id="data_entrega_edit" name="notas[data_entrega]" value="" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <input type="button" class="btn btn-default" value="Editar" id="btnEditar" required>
      </div>
    </div>

  </div>
</div>
