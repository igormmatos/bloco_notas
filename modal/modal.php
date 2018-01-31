<!-- Modal -->
<div class="modal fade" id="add_nota" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Nova Nota</h4>
      </div>
      <div class="modal-body">
        <form action="index.php" method="post" id="form">
          <div class="form-group">
            <label for="titulo">Título :</label>
            <input type="text" class="form-control" id="titulo" name="notas[titulo]" maxlength="150" required>
          </div>
          <div class="form-group">
            <label for="descricao">Descrição  :</label><br><br>
            <textarea class="form-control" id="descricao" name="notas[descricao]" style="resize: none" required></textarea>
          </div>
          <div class="form-group">
            <div class="col-md-3">
              <label for="prioridade_select">Prioridade</label>
              <select class="form-control" id="prioridade_select" name="notas[prioridade_select]">
                <option value="0">BAIXA</option>
                <option value="1">MÉDIA</option>
                <option value="2">ALTA</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for="status_select">Status</label>
              <select class="form-control" id="status_select" name="notas[status_select]">
                <option value="active">NÃO INICIADA</option>
                <option value="success">CONCLUÍDO</option>
                <option value="info">EM ANDAMENTO</option>
                <option value="danger">CANCELADA</option>
              </select>
            </div>
            <div class="col-md-5">
              <label for="data_entrega">Data Entrega :</label>
              <input type="date" class="form-control" id="data_entrega" name="notas[data_entrega]" value="" required>
            </div>
          </div>
        </form>
        <div class="form-group text-right" style="margin-top: 90px;">
            <input type="button" class="btn btn-default" value="Adicionar" id="btnAdicionar" required>
        </div>
      </div>
    </div>

  </div>
</div>
