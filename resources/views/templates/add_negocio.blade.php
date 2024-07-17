<div class="modal fade task-modal-content" id="add-negocio-model" tabindex="-1" role="dialog"
    aria-labelledby="NewTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="NewTaskModalLabel">Adicionar Negócio</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="p-2" action="{{ url('negocios/add') }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Painel Esquedo -->
                        <div class="col-md-6">

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">Nome Contato<span
                                                class="text-danger"> *</label>
                                        <input type="text" class="form-control form-control-light" id="add_nome_contato"
                                            placeholder="Digite nome" required value="" name="nome_lead">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">Telefone<span class="text-danger">
                                                *</span></label>
                                        <input type="text" class="form-control form-control-light telefone"
                                            id="task-title" placeholder="Digite Telefone" required name="tel_lead">
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">Tipo de Crédito</label>
                                        <select class="form-select form-control-light" id="add_credito_tipo"
                                            name="tipo_credito">
                                            <?php
                                            use App\Enums\NegocioTipo;
                                            
                                            $tipos = NegocioTipo::all();
                                            $i = 0;
                                            foreach ($tipos as $tipo) {
                                                if ($i == 0) {
                                                    $i = 1;
                                                    echo "<option selected>$tipo</option>";
                                                } else {
                                                    echo "<option>$tipo</option>";
                                                }
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">Valor Crédito</label>
                                        <input type="text" class="form-control form-control-light money"
                                            id="add_nome_valor" placeholder="Valor do Crédito" name="valor">
                                    </div>
                                </div>



                                <!--div class="col-md-12">
                                        <div class="mb-12">
                                            <label for="task-title" class="form-label">Etapa Funil</label>
                                            <select class="form-select form-control-light" id="task-priority"
                                                name="etapa_funil_id" onchange="this.value = 'OPORTUNIDADE'">
                                                @foreach ($etapa_funils as $key => $value)
@if ($key == 1)
<option value="{{ $key }}" selected="true">{{ $value }}</option>
@else
<option value="{{ $key }}">{{ $value }}</option>
@endif
@endforeach
                                            </select>
                                        </div>
                                    </div-->
                                <input name="etapa_funil_id" value="1" hidden>
                                <input name="proprietario_id" id="negocio_id_perdido" hidden
                                    value="{{ app('request')->proprietario }}">

                                <!--div class="col-md-12">
                                        <div class="mb-12">
                                            <label for="task-priority" class="form-label">Previsão de Fechamento</label>
                                            <input type="text" class="form-control form-control-light pfechamento"
                                                data-single-date-picker="true" name="fechamento" value="<?php echo date('d/m/Y'); ?>">
                                        </div>
                                    </div-->
                            </div>
                        </div>
                        <!-- Painel Esquedo -->
                        <div class="col-md-6" style="border-left: 1px solid rgb(228 230 233);">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">Titulo<span class="text-danger">
                                        </label>
                                        <input type="text" class="form-control form-control-light" id="add_titulo"
                                            name="titulo" placeholder="Digite o titulo do negocio" required value=""
                                            maxlength="30">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">WhatsApp</label>
                                        <input type="text" class="form-control form-control-light telefone"
                                            id="task-title" placeholder="Digite Telefone" name="whats_lead">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">E-mail</label>
                                        <input type="text" class="form-control form-control-light" id="task-title"
                                            placeholder="Digite e-mail">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-12" hidden>
                                        <label for="task-title" class="form-label">Funil</label>
                                        <select class="form-select form-control-light" id="task-priority"
                                            name="funil_id" onchange="this.value = 'VENDAS'">
                                            @foreach ($funils as $key => $value)
                                            @if ($key == 1)
                                            <option value="{{ $key }}" selected="true">
                                                {{ $value }}</option>
                                            @else
                                            <option value="{{ $key }}">{{ $value }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <br><br>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Criar</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $('#valor_credito_md').mask('000.000.000.000.000,00', {
            reverse: true
        });
        $('#add_nome_valor').mask('000.000.000.000.000,00', {
            reverse: true
        });
        $('.telefone').mask('(00) 00000-0000');

        $(document).ready(function() {
            $('input.timepicker').timepicker({});
        });

        $('.timedatapicker').timepicker({
            'timeFormat': 'H:i'
        });
        $('.timedatapicker').timepicker('setTime', new Date());


        function change_titulo(item) {
            var tipo = $("#add_credito_tipo").val();
            var nome = $("#add_nome_contato").val().split(' ')[0];
            var valor = $("#add_nome_valor").val();

            console.log(valor, nFormatter(valor, 1))
            
            $("#add_titulo").val(tipo + "-" + nFormatter(valor, 0) + "-" + nome);

        }

        $("#add_nome_contato").change(function() {
            change_titulo(this);
        });

        $("#add_credito_tipo").change(function() {
            change_titulo(this);
        });


        $("#add_nome_valor").change(function() {
            change_titulo(this);
        });

    });
</script>