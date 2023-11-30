<div class="modal fade task-modal-content" id="agendamento-protocolo" aria-labelledby="NewTaskModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" class="center" id="venda_titulo">Protocolo de Agendamento</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-12" class="divtext">
                            <p id="txt_protocolo" rows="22" cols="50">-=_*REUNIÃO AGENDADA*_=-<br>
                                *Protocolo:
                                {{ random_int(999, 999999) }}/{{ Carbon\Carbon::now('America/Sao_Paulo')->format('Y') }}*
                                <br>
                                📅<span> </span>*Data: <span id="ptcl_dia"></span>*<br>
                                ⏰<span> </span>*Hora: <span id="ptcl_hora"></span>* <br>
                                <br>
                                _*Documentos necessários:*_<br>
                                ➡RG<br>
                                ➡CPF<br>
                                ➡Comprovante de Residência Atual<br>
                                <br>
                                _*Endereço:*_<br>
                                📍{{ config('endereco') }}<br>

                                <br>
                                _*Na Recepção procurar por:*_ <br>
                                @if (app('request')->proprietario > 0)
                                    {{ App\Models\User::find(app('request')->proprietario)->name }}<br>
                                @endif
                                🏡🚗🏍✅<br>
                                <br>
                                Estacionamento Gratuito<br>
                                {{ config('nome') }}<br>
                                <!--SITE: {{ config('site') }}<br> -->
                                <!-- CNPJ: {{ config('cnpj') }}<br> -->
                                <br>
                                Confirme com OK✅<br>
                            </p>
                        </div>
                    </div>
                </div>
                <br>
                <div class="text-end">
                    <button onclick="copyProtocolo()" class="btn btn-success">Copiar</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    function copyProtocolo() {

        var text = document.getElementById('txt_protocolo').innerText;
        var elem = document.createElement("textarea");
        document.body.appendChild(elem);
        elem.value = text;
        elem.select();
        document.execCommand("copy");
        document.body.removeChild(elem);

        showAlert({
            message: "protocolo copiado",
            class: "success"
        });
        $('#agendamento-protocolo').modal('hide');
    }
</script>
