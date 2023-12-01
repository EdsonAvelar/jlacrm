<div class="modal fade task-modal-content" id="agendamento-add" aria-labelledby="NewTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" class="center" id="venda_titulo">Novo Agendamento</h5>
            </div>
            <div class="modal-body">
                <form class="p-2" action="{{ route('agendamento.add') }}" method="POST" id="agendamento_para">
                    @csrf
                    <div class="row">
                        <!-- Painel Esquedo -->
                        <div class="col-md-12">
                            <div class="mb-12">
                                <label for="task-priority" class="form-label">Agendado para:</label>
                                <input type="text" class="form-control form-control-light agendamento"
                                    data-single-date-picker="true" name="data_agendado" value="{{ date('d/m/Y') }}">
                            </div>
                            <div class="mb-12">
                                <label for="task-priority" class="form-label">Hora:</label>
                                <input type="text" name="hora_agendado"
                                    class="form-control form-control-light timedatapicker">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="text-start">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="check_protocolo" checked>
                            <label class="form-label form-check-label" for="flexSwitchCheckDefault">Gerar
                                Protocolo</label>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" id="confirmar_agendamento" class="btn btn-success">Confirmar</button>
                    </div>
                    <input name="proprietario_id" id="proprietario_id" hidden
                        value="{{ app('request')->proprietario }}">
                    <input name="negocio_id" id="negocio_id_agen" hidden value="">
                    <input id="agend_confirm" hidden value="false">
                    <div id="database" data-el="" data-source="" data-target=""></div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
