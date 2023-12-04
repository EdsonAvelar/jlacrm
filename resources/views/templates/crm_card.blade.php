<style>
    .nolink {

        text-decoration: none;
        color: black;
    }

    .card-body {
        -webkit-box-flex: 1;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        padding: 0.6rem 0.6rem !important;
    }

    .border1 {
        border: 0px solid #d0d0d0;
    }

    .border1:hover {
        border: 3px solid rgb(78, 0, 146);
    }
</style>
<?php
$styles = '';
$compact = false;
$mb = 'mt-2 mb-2';
if (app('request')->view_card == 'compact') {
    $styles = 'height: 7rem;';
    $compact = true;
    $mb = 'mt-1 mb-1';
}

?>

<div class="card mb-1 mt-1 border1" id={{ $negocio_id }} style="{{ $styles }}">
    <div class="card-body p-3" <?php
    
    if (config('card_colorido') == 'true') {
        if ($negocio->status == 'ATIVO') {
            if ($last_update < 1) {
                echo "style='background-color: #ebfaedcc;'";
            } elseif ($last_update < 3) {
                echo "style='background-color: #ffffff;'";
            } elseif ($last_update < 5) {
                echo "style='background-color: #f5f9cc69;'";
            } else {
                echo "style='background-color: #f8c9c96e;'";
            }
        }
    
        $styles = 'height: 6rem;margin-bottom: 2rem !important;';
    }
    
    ?>>

        <div class="dropdown float-end">
            <a href="#" class="dropdown-toggle text-muted arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-dots-vertical font-18"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                <!-- item-->
                <a href="{{ route('negocio_edit', ['id' => $negocio_id]) }}" class="dropdown-item"><i
                        class="mdi mdi-pencil me-1"></i>Editar</a>
                <!-- item-->

                <?php
                $tel_clean = preg_replace('/[^0-9]/', '', $telefone);
                
                if ($whatsapp) {
                    $whatsapp = preg_replace('/[^0-9]/', '', $whatsapp);
                } else {
                    $whatsapp = preg_replace('/[^0-9]/', '', $telefone);
                }
                
                ?>

                <a href="http://wa.me/55{{ $whatsapp }}" class="dropdown-item"><i
                        class="mdi mdi-whatsapp me-1"></i>WhatsApp</a>

                <a href="tel:{{ $tel_clean }}" class="dropdown-item"><i class="mdi mdi-phone me-1"></i>Telefone</a>

                @if ($negocio->status == 'ATIVO')
                    <a href="{{ route('negocios.simulacao', ['negocio_id' => $negocio->id]) }}" class="dropdown-item"><i
                            class="mdi mdi-file-document-multiple me-1"></i>Gerar Proposta</a>
                @endif

                <hr>
                @if ($negocio->status == 'ATIVO')
                    <a href="{{ route('negocio_fechamento', ['id' => $negocio_id]) }}"
                        class="dropdown-item ganhou_button"><i class="dripicons-thumbs-up"></i><span
                            class="text-success"> Fechamento</span></a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item perdeu_button" data-id="{{ $negocio_id }}"><i
                            class="dripicons-thumbs-down"></i><span class="text-danger"> Perdeu</span></a>
                @endif


                @if ($negocio->status == 'PERDIDO')
                    <form id="negocio_reativar" action="{{ url('negocios/reativar') }}" method="POST">
                        @csrf
                        <input type="text" name="negocio_id" hidden value="{{ $negocio->id }}">
                        <a href="#" onClick="document.getElementById('negocio_reativar').submit();"
                            class="dropdown-item"><i class="dripicons-thumbs-up"></i>
                            <span class="text-success"> Reativar</span></a>
                    </form>
                @endif

            </div>
        </div>

        <a class="float-end text-muted" href="tel:{{ $telefone }}">{{ $telefone }}</a>

        <?php
        
        if ($negocio->status == 'ATIVO') {
            if ($last_update < 1) {
                echo "<span class=\"badge bg-success float-begin\">RECENTE</span>";
            } elseif ($last_update < 3) {
                echo "<span class=\"badge bg-info float-begin\">NOVO</span>";
            } elseif ($last_update < 5) {
                echo "<span class=\"badge bg-warning float-begin\">ATENÇÃO</span>";
            } else {
                echo "<span class=\"badge bg-danger float-begin\">URGENTE</span>";
            }
        } elseif ($negocio->status == 'PERDIDO') {
            echo "<span class=\"badge bg-danger float-begin\" style='color: black;'> PERDIDO</span>";
        } elseif ($negocio->status == 'VENDIDO') {
            echo "<span class=\"badge bg-success float-begin\">VENDIDO</span>";
        } else {
            echo "<span class=\"badge bg-primary float-begin\">" . $negocio->status . '</span>';
        }
        
        ?>


        <h5 class="{{ $mb }}">
            <a href="{{ route('negocio_edit', ['id' => $negocio_id]) }}" class="nolink">
                <?php
                if ($compact == true) {
                    echo mb_strimwidth($titulo, 0, 30);
                } else {
                    echo $titulo;
                }
                ?></a>
        </h5>

        <p class="{{ $mb }}" style="padding: 2 px">
            <span class="pe-2 text-nowrap mb-1 d-inline-block">
                <i class="mdi mdi-briefcase-outline text-muted"></i>
                {{ $tipo }}
            </span>
            <span class="text-nowrap mb-1 d-inline-block">
                <i class="mdi mdi-cash text-muted"></i>
                <b>R$ {{ number_format((float) $valor, 2, ',', '.') }}</b>
            </span>
        </p>

        @if ($compact != true)

            <p class="{{ $mb }}" style="padding: 2 px">
                <span class="align-middle float-end"><i class="mdi mdi-face text-muted"></i>{{ $leadname }}</span>
            </p>



            <p class="{{ $mb }}">

                @if (!is_null($negocio->user))
                    <img src="{{ url('') }}/images/users/user_{{ $negocio->user->id }}/{{ $negocio->user->avatar }}"
                        alt="user-img" class="avatar-xs rounded-circle me-1">
                    <span class="align-middle text-muted">{{ $negocio->user->name }}</span>
                @else
                    <img src="{{ url('') }}/images/users/avatars/user-padrao.png" alt="user-img"
                        class="avatar-xs rounded-circle me-1">
                @endif


            </p>
        @endif

    </div> <!-- end card-body -->
</div>
<!-- Task Item End -->
