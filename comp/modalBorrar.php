<div class="modal fade" id="modal_borrar" tabindex="-1" aria-labelledby="modal_borrar" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <p class="modal-title" id="exampleModalLabel">¿Está seguro que desea eliminar este registro?</p>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="db_borrar.php" method="post">
          <div class="modal-footer">
            <input type="hidden" name="borrar_id" id="borrar_id">
            
            <button type="submit" name="submit_borrar" class="btn btn-dark">Si</button>
            <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">No</button>
          </div>
      </form>
    </div>
  </div>
</div>