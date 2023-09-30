<div class="modal fade" id="add_user_note" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form action="" method="POST" id="form_shared">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Compartilhar card</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="user_email" class="col-form-label">Email do usuário:</label>
                        <input type="email" class="form-control" name="user_email" id="user_email" required>
                        <span class="msg-popup">* Caso ainda não seja cadastrado, será enviado email solicitando o
                            cadastro.</span>
                        <input type="hidden" name="note_id" id="note_id" value="">
                        <input type="hidden" name="page" id="page" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="input" class="btn btn-primary">Incluir</button>
                </div>
            </div>
        </div>
    </form>
</div>
