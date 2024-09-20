<?php



$colaboradores = [

];

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$perPage = 6;
$total = count($colaboradores);
$pages = ceil($total / $perPage);

$start = ($page - 1) * $perPage;
$colaboradoresPaginados = array_slice($colaboradores, $start, $perPage);

$tema = app('request')->tema;

#$tema = config('ranking_tema_vendas')
if ($tema == ''){
    $tema = 'tema03';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking de Vendas - Equipe</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Outros scripts -->

    @include('dashboards/ranking/templates/default_css', [
    'tema' => $tema
    ])

    <link rel="stylesheet" href="{{url('')}}/images/ranking/{{$tema}}/temaconfig.css">


    </style>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
</head>

<body>
    <audio id="musicPlayer">
        <source src="{{ asset('music/aplausos.mp3') }}" type="audio/mpeg">
    </audio>
    <div id="notification" class="notificacao_venda shadow-box" style="display: none;">
        <div class="card-vendedor">
            <img id="imagem_empresa" class="loggo empresa rounded-circle" src="https://via.placeholder.com/40"
                alt="Logo da Empresa">
            <div class="texto-cima">📣 É VENDA 📣</div>
            <div class="texto-cima2"><span id="nome_cliente">Fulano</span></div>
            <div class="texto-cima2"><span id="venda_valor">200k</span></div>

            <img id="imagem_vendedor" class="rounded-circle" src="https://via.placeholder.com/40"
                alt="Foto do Vendedor">
            <div class="texto-baixo">
                <div>🎉 PARABÉNS 🎉</div>
                <div><span id="nome_vendedor">Adriano</span></div>
                <div><span id="nome_equipe">Equipe Adricon</span></div>
            </div>
            <img id="imagem_equipe" class="loggo equipe rounded-circle" src="https://via.placeholder.com/40"
                alt="Logo da Equipe">
        </div>
    </div>

    @include('dashboards.ranking.templates.menu_bar',
    ['title'=>'Ranking de vendas - Por Equipe'])

    <div class="container2">


        <div class="ranking">

            <div class="ranking-header">

                <div class="ranking-totals" id="header-total"
                    style="display: {{ config('ranking_mostrar_vendas') == 'true'? 'flex' : 'none' }}">

                    <span style="color:gray">Total em Vendas: </span> <span class="total-time">R$ 0</span>
                    {{-- <span style="color:gray">Total do top 3: </span> <span class="total-top3">R$106.508,00</span>
                    --}}
                </div>
            </div>
            <div class="ranking-board">


                <div class="item">
                    <div class="time2" id="time-photo-2">
                    </div>
                    <div class="award segundo" id="premiacao_2" <?php if (
                        config('ranking_visivel_premiacao_2')=="false" ) { echo 'style="display:none"' ; } ?>>
                        <img src="{{asset('images/ranking/user/premiacao_2.png')}}?{{ \Carbon\Carbon::now()->timestamp }}"
                            alt="Premiação">
                        <div id="txt_ranking_premiacao_2">{{ strtoupper( config('ranking_premiacao_2')) }} </div>
                    </div>
                    <div class="position-wrapper2">
                        <div class="collaborator-photo" id="collaborator-photo-2"
                            style="background-image: url('https://via.placeholder.com/80');"></div>
                    </div>


                    <div class="nome segundo">
                        <div id="nome2"></div>
                        <div id="valor2"></div>
                    </div>


                </div>


                <div class="item">
                    <div class="time1" id="time-photo-1">
                    </div>
                    <div class="award primeiro" id="premiacao_1" <?php if
                        (config('ranking_visivel_premiacao_1')=="false" ) { echo 'style="display:none"' ; } ?>>
                        <img src="{{asset('images/ranking/user/premiacao_1.png')}}?{{ \Carbon\Carbon::now()->timestamp }}"
                            alt="Premiação">
                        <div id="txt_ranking_premiacao_1">{{ strtoupper( config('ranking_premiacao_1')) }}</div>
                    </div>
                    <div class="position-wrapper1">
                        <div class="collaborator-photo" id="collaborator-photo-1"
                            style="background-image: url('https://via.placeholder.com/80');"></div>
                    </div>
                    <div class="nome primeiro">
                        <div id="nome1"></div>
                        <div id="valor1"></div>
                    </div>



                </div>

                <div class="item">
                    <div class="time3" id="time-photo-3">
                    </div>
                    <div class="award terceiro" id="premiacao_3" <?php if
                        (config('ranking_visivel_premiacao_3')=="false" ) { echo 'style="display:none"' ; } ?>>
                        <img src="{{asset('images/ranking/user/premiacao_3.png')}}?{{ \Carbon\Carbon::now()->timestamp }}"
                            alt="Premiação">
                        <div id="txt_ranking_premiacao_3">{{ strtoupper( config('ranking_premiacao_3')) }}</div>
                    </div>
                    <div class="position-wrapper3">
                        <div class="collaborator-photo" id="collaborator-photo-3"
                            style="background-image: url('https://via.placeholder.com/80');">
                        </div>
                    </div>
                    <div class="nome terceiro">
                        <div id="nome3"></div>
                        <div id="valor3"></div>
                    </div>


                </div>



            </div>
        </div>

        <!-- Info Panel Section -->
        <div class="info-panel">

            <div class="logo-empresa">
                <h1 class="titulo-logo" style="display: none">Ranking Vendas por Equipe</h1>

                <img src="{{ url('') }}/images/empresa/logos/empresa_ranking.png" alt="Logo">
            </div>

            <div class="body-panel">
                <?php foreach ($colaboradoresPaginados as $index => $colaborador): ?>
                <div class="collaborator-card">
                    <div class="position">
                        <?= $start + $index + 1 ?>
                    </div>
                    <div class="photo" style="background-image: url('https://via.placeholder.com/50');"></div>
                    <div class="collaborator-info">
                        <div class="name">
                            <?= $colaborador['name'] ?>
                        </div>
                        <div class="meta">
                            Meta: R$
                            <?= number_format($colaborador['meta'], 2, ',', '.') ?> | Total: R$
                            <?= number_format($colaborador['total'], 2, ',', '.') ?>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" style="width: <?= $colaborador['percentual'] ?>%;"></div>
                        </div>
                        <div class="missing-value">Faltam: R$
                            <?= number_format($colaborador['meta'] - $colaborador['total'], 2, ',', '.') ?>
                        </div>
                    </div>
                    <div class="percentage">
                        <?= 100 - $colaborador['percentual'] ?>%
                    </div>
                    <div class="team-section">
                        <div class="team-photo" style="background-image: url('https://via.placeholder.com/60');">
                            <!-- Imagem da equipe -->
                        </div>
                        <div class="team-name">
                            <!-- Nome da equipe -->
                            <?= $colaborador['equipe'] ?>
                        </div>
                    </div>
                </div>

                <?php endforeach; ?>
            </div>


        </div>

    </div>

    {{-- <div class="footer-panel">
        <div class="active-rankings">
            <span>Times Ativos:</span>
            <i class="fas fa-chart-line"></i>
            <i class="fas fa-calendar-alt"></i>
            <i class="fas fa-trophy"></i>
        </div>
        <div class="update-timer">
            <span>9m:59s | Restantes...</span>
            <i class="fas fa-play" id="play-pause-icon"></i>
        </div>
    </div> --}}

    {{-- JANELA DE CONFIGURAÇÕESSSSS --}}

    <div class="context-overlay"></div> <!-- Overlay para bloquear a tela ao abrir a janela de configurações -->

    <div id="settings-window">

        <div class="close-btn">X</div>


        <div class="settings-tabs">
            <div class="settings-tab active-tab" data-content="info-gerais">Informações Gerais</div>
            <div class="settings-tab" data-content="premiacao">Premiações</div>
            <div class="settings-tab" data-content="producao">Produção</div>
            <div class="settings-tab" data-content="sons">Sons</div>
            <div class="settings-tab" data-content="aparencia">Aparência</div>
        </div>
        <div class="settings-content">
            <div id="info-gerais" class="content-section">
                <h4>Informações Gerais</h4>
                <p>Configurações principais sobre o time.</p>

                <div class="mb-6">
                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                        <label for="inputEmail3" class="col-form-label">Mostrar Equipes
                            <span class="mdi mdi-information"></span>
                        </label> </span>

                    <input class="toggle-event" type="checkbox" <?php $exibir=config("ranking_mostrar_equipe"); if
                        ($exibir !=null & $exibir=='true' ) { echo 'checked' ; } ?>
                    data-config_info="ranking_mostrar_equipe" data-toggle="toggle" data-on="com equipe"
                    data-off="sem equipe" data-onstyle="success" data-offstyle="danger">
                </div>

                <div class="mb-6">
                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                        <label for="inputEmail3" class="col-form-label">Mostrar Vendas
                            <span class="mdi mdi-information"></span>
                        </label> </span>

                    <input class="toggle-event" type="checkbox" <?php $exibir_vendas=config("ranking_mostrar_vendas");
                        if ($exibir_vendas !=null & $exibir_vendas=='true' ) { echo 'checked' ; } ?>
                    data-config_info="ranking_mostrar_vendas" data-toggle="toggle" data-on="Com Vendas Totais"
                    data-off="Sem Venda Totais" data-onstyle="success" data-offstyle="danger">
                </div>




            </div>
            <div id="premiacao" class="content-section hidden">
                <h4>Premiações</h4>
                <p>Defina as premiação de cada posição.</p>

                <div class="premiacao-item">
                    <div class="premiacao-icon">

                        <img src="{{asset('images/ranking/'.$tema.'/icon-primeiro.png')}}" alt="Gold Trophy">
                    </div>
                    <div class="premiacao-1-img">
                        <a href="#" onclick="image_save('','/premiacao_1.png')" class="text-muted font-14">
                            <img src="{{ url('') }}/images/ranking/user/premiacao_1.png?{{ \Carbon\Carbon::now()->timestamp }}"
                                class="avatar-lx img-thumbnail" alt="profile-image">
                        </a>
                    </div>

                    <div class="premiacao-info">
                        <input type="text" value="{{config('ranking_premiacao_1')}}" id="ranking_premiacao_1" />
                    </div>
                    <div class="premiacao-visualizar" data-id="premiacao_1">
                        <?php
                        if (config('ranking_visivel_premiacao_1') == "false") {
                            echo '<i class="fas fa-eye-slash"></i>';
                        } else {
                            echo '<i class="fas fa-eye"></i>';
                        }

                        ?>
                    </div>
                </div>
                <div class="premiacao-item">

                    <div class="premiacao-icon">
                        <img src="{{asset('images/ranking/'.$tema.'/icon-segundo.png')}}" alt="Silver Trophy">
                    </div>

                    <div class="premiacao-1-img">
                        <a href="#" onclick="image_save('','/premiacao_2.png')" class="text-muted font-14">
                            <img src="{{ url('') }}/images/ranking/user/premiacao_2.png?{{ \Carbon\Carbon::now()->timestamp }}"
                                class="avatar-lx img-thumbnail" alt="profile-image">
                        </a>
                    </div>

                    <div class="premiacao-info">
                        <input type="text" value="{{config('ranking_premiacao_2')}}" id="ranking_premiacao_2" />
                    </div>
                    <div class="premiacao-visualizar" data-id="premiacao_2">
                        <?php
                        if (config('ranking_visivel_premiacao_2') == "false") {
                            echo '<i class="fas fa-eye-slash"></i>';
                        } else {
                            echo '<i class="fas fa-eye"></i>';
                        }

                        ?>
                    </div>
                </div>
                <div class="premiacao-item">
                    <div class="premiacao-icon">
                        <img src="{{asset('images/ranking/'.$tema.'/icon-terceiro.png')}}" alt="Bronze Trophy">
                    </div>

                    <div class="premiacao-1-img">
                        <a href="#" onclick="image_save('','/premiacao_3.png')" class="text-muted font-14">
                            <img src="{{ url('') }}/images/ranking/user/premiacao_3.png?{{ \Carbon\Carbon::now()->timestamp }}"
                                class="avatar-lx img-thumbnail" alt="profile-image">
                        </a>
                    </div>
                    <div class="premiacao-info">
                        <input type="text" value="{{config('ranking_premiacao_3')}}" id="ranking_premiacao_3" />
                    </div>
                    <div class="premiacao-visualizar" data-id="premiacao_3">

                        <?php
                        if (config('ranking_visivel_premiacao_3') == "false") {
                            echo '<i class="fas fa-eye-slash"></i>';
                        } else {
                            echo '<i class="fas fa-eye"></i>';
                        }

                        ?>

                    </div>
                </div>
                {{-- <div class="premiacao-salvar">
                    <button>Salvar</button>
                </div> --}}
            </div>
            <div id="producao" class="content-section hidden">
                <h4>Produção</h4>
                <p>Configurações de produção.</p>
                <h3>Em Breve</h3>
            </div>
            <div id="sons" class="content-section hidden">
                <h4>Sons</h4>
                <p>Configurações de sons.</p>
                <h3>Em Breve</h3>
            </div>
            <div id="aparencia" class="content-section hidden">
                <h4>Aparência</h4>
                <p>Configurações de aparência.</p>
                <h3>Em Breve</h3>

            </div>
        </div>
    </div>



    @include('templates.escolher_img', [
    'action' => route('ranking_premiacoes'),
    'titulo' => "Editar Arte da Premiação",
    'user_id' => app('request')->id
    ])

    <!-- jQuery and Bootstrap Bundle (includes Popper) -->

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });



        var mostra_equipe = true;


        function image_save($folder, $imgname) {
            $('#pasta_imagem').val($folder);
            $('#imagem_name').val($imgname);

            $('#change_logo').modal('show');
        }

        var ids_toggle = [
            'ranking_premiacao_1',
            'ranking_premiacao_2',
            'ranking_premiacao_3',
        ];

        ids_toggle.forEach(function (id) {
            var element = document.getElementById(id);
            if (element) {
                element.addEventListener('blur', function (e) {
                    var value = e.target.value.toUpperCase();;

                    console.log(id, value)

                    save_config(id, value);
                    $("#txt_" + id).html(value);

                });
            }
        });



        function save_config(config_info, config_value, alert = true) {

            info = [];
            info[0] = config_info;
            info[1] = config_value;

            $.ajax({
                url: "{{ url('empresa/config') }}",
                type: 'post',
                data: {
                    info: info
                },
                Type: 'json',
                success: function (res) {

                    if (alert) {
                        console.log(res)

                    }

                },
                error: function (res) {

                    if (alert) {
                        console.log(res)
                    }

                },
            });
        }



        function atualizarColaboradores() {

            console.log("Atualização de Colaboradores");
            let equipe = "none";
            if (mostra_equipe) {
                equipe = "flex";
            }
            $.ajax({
                url: "{{ url('ranking/equipes/vendas') }}",
                method: 'GET',
                success: function (data) {
                    let colaboradores = data.equipes;

                    console.log( colaboradores )

                    let html = '';
                    colaboradores.forEach(function (colaborador, index) {
                        let html_colaborador = "";

                        


                        if (colaborador.equipe_logo != null) {

                            html_colaborador = `
                            <div class="team-section" style='display:${equipe}'">
                                <div class="team-photo" style="background-image: url('${colaborador.lider_avatar}');">
                                    <!-- Imagem da equipe -->
                                </div>
                                <div class="team-name">
                                    <!-- Nome da equipe -->
                                    <p>${colaborador.lider_name}</p>
                                </div>
                            </div>`
                        }
                        html += `
                        <div class="collaborator-card ${colaborador.total >= colaborador.meta ? 'equipe-meta-batida' : ''}">
                            <div class="position">${index + 1}</div>
                            <div class="photo ${colaborador.total >= colaborador.meta ? 'brilho ' : ''}" style="background-image: url('${colaborador.equipe_logo}');"></div>
                            <div class="collaborator-info">
                                <div class="name">${colaborador.equipe_name}</div>
                                <div class="meta">Meta: R$ ${colaborador.meta.toLocaleString()} | Total: R$ ${colaborador.total.toLocaleString()}</div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: ${colaborador.percentual}%;"></div>
                                </div>
                                <div class="missing-value">Faltam: R$ ${(colaborador.meta - colaborador.total).toLocaleString()}</div>
                            </div>
                            <div class="percentage">${Math.round(colaborador.percentual)}%</div>
                            ${html_colaborador}
                        </div>`;
                    });

                    $('.body-panel').html(html);




                    let num_coladores = Math.min(colaboradores.length, 3)

                    for (let index = 0; index < num_coladores; index++) {

                        var valorFormatado = new Intl.NumberFormat('pt-BR', {
                            style: 'currency',
                            currency: 'BRL'
                        }).format(colaboradores[index].total);

                        $('#nome' + (index + 1)).html(colaboradores[index].equipe_name);
                        $('#valor' + (index + 1)).html(valorFormatado);
                        $('#collaborator-photo-' + (index + 1)).css('background-image', 'url(' + colaboradores[index].lider_avatar + ')');
                        $('#time-photo-' + (index + 1)).css('background-image', 'url(' + colaboradores[index].equipe_logo + ')');


                        if (colaboradores[index].total >= colaboradores[index].meta){
                                        $('#collaborator-photo-'+(index+1)).addClass('brilho')
                                    }
                    }

                    var valorFormatado = new Intl.NumberFormat('pt-BR', {
                        style: 'currency',
                        currency: 'BRL'
                    }).format(data.total_vendas);

                    $('.total-time').html(valorFormatado)

                    // $('#collaborator-photo-2').css('background-image', 'url('+colaboradores[1].avatar+')');
                    // $('#collaborator-photo-3').css('background-image', 'url('+colaboradores[2].avatar +')');
                }
            });
        }



        $(document).ready(function () {

            let has_equipe = "{{config('ranking_mostrar_equipe')}}";
            if (has_equipe == "false") {
                mostra_equipe = false;
            } else {
                mostra_equipe = true;
            }

            atualizarColaboradores();
        });

        // Chama a função a cada x segundos (por exemplo, 30 segundos)

        //setInterval(atualizarColaboradores, 5000);



        //###---------- Notificação de Venda ------------#
        function nFormatter(num, digits) {
            const lookup = [{
                value: 1,
                symbol: ""
            },
            {
                value: 1e3,
                symbol: "K"
            },
            {
                value: 1e6,
                symbol: "M"
            },
            {
                value: 1e9,
                symbol: "G"
            },
            {
                value: 1e12,
                symbol: "T"
            },
            {
                value: 1e15,
                symbol: "P"
            },
            {
                value: 1e18,
                symbol: "E"
            }
            ];
            num = num.split(',')[0]
            num = num.replaceAll('.', '')

            const rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
            var item = lookup.slice().reverse().find(function (item) {
                return num >= item.value;
            });
            return item ? (num / item.value).toFixed(digits).replace(rx, "$1") + item.symbol : "0";
        }

        function showNotification() {
            const notification = document.getElementById('notification');
            notification.style.display = 'flex'; // Mostrar a notificação
            setTimeout(() => {
                notification.style.display = 'none'; // Ocultar a notificação após 5 segundos
            }, 20000);
        }

        Pusher.logToConsole = true;

        var pusher = new Pusher('ae35a6a0e6cd96def27f', {
            cluster: 'sa1'
        });

        var channel = pusher.subscribe("{{ config('broadcast_canal') }}");
        console.log('pusher' + channel);
        channel.bind('nova-venda', function (data) {



            console.log(JSON.stringify(data));

            var nome_cliente = data.data.cliente.split(' ');
            var sobrenome = ''

            if (nome_cliente.length > 1){
                sobrenome = nome_cliente[ nome_cliente.length - 1]
            }



            document.getElementById('venda_valor').innerText = "Crédito: " + nFormatter(data.data.credito, 2);
            document.getElementById('nome_cliente').innerText = "Cliente: " + nome_cliente[0] +' '+sobrenome;
            document.getElementById('nome_vendedor').innerText = data.data.vendedor;
            document.getElementById('nome_equipe').innerText = data.data.equipe_nome ? "Equipe: " + data.data.equipe_nome : '';

            document.getElementById('imagem_vendedor').src = data.data.avatar;


            if (data.data.equipe_logo) {
                $("#imagem_equipe").show()
                document.getElementById('imagem_equipe').src = data.data.equipe_logo;
            } else {
                $("#imagem_equipe").hide()
            }

            document.getElementById('imagem_empresa').src = data.data.empresa;


            setTimeout(function () {
                showNotification();


                atualizarColaboradores();

                var aplausos = "{{ config('broadcast_audio') }}"


                if (aplausos == "true") {

                    var musicPlayer = document.getElementById('musicPlayer');
                    musicPlayer.play();

                    setTimeout(function () {
                        musicPlayer.pause();
                        musicPlayer.currentTime = 0; // Retorna a música ao início
                    }, 20000);
                }

            }, 10000);




        });


    </script>



    <script>
        //************************** Abrir a janela de configurações
        // Abrir a janela de configurações com o overlay
        // Abrir a janela de configurações




        document.querySelector('.settings').addEventListener('click', function () {
            document.getElementById('settings-window').style.transform = 'translateX(0)';
            document.querySelector('.context-overlay').style.display = 'block'; // Mostrar o overlay
        });

        // Fechar a janela de configurações
        document.querySelector('.close-btn').addEventListener('click', function () {
            document.getElementById('settings-window').style.transform = 'translateX(-100%)';
            document.querySelector('.context-overlay').style.display = 'none'; // Ocultar o overlay
        });

        // Fechar a janela de configurações ao clicar fora dela
        document.querySelector('.context-overlay').addEventListener('click', function () {
            document.getElementById('settings-window').style.transform = 'translateX(-100%)';
            document.querySelector('.context-overlay').style.display = 'none'; // Ocultar o overlay
        });

        // Alternar entre as abas
        document.querySelectorAll('.settings-tab').forEach(tab => {
            tab.addEventListener('click', function () {
                document.querySelectorAll('.settings-tab').forEach(t => t.classList.remove('active-tab'));
                this.classList.add('active-tab');

                document.querySelectorAll('.content-section').forEach(section => section.classList.add('hidden'));
                document.getElementById(this.dataset.content).classList.remove('hidden');
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Detecta o clique no botão com a classe settings-ranking
           document.querySelector('.settings-vendas').addEventListener('click', function() {
            window.location.href = "{{ route('ranking.vendas') }}";
            });
            
            // Detecta o clique no botão com a classe settings-ranking
            document.querySelector('.settings-agendamentos').addEventListener('click', function() {
            window.location.href = "{{ route('ranking.agendamentos') }}";
            });
            
            document.querySelector('.settings-times').addEventListener('click', function () {
            window.location.href = "{{ route('ranking.vendas.equipe') }}";
            });


        });

        
        


    </script>

    <script>
        document.querySelectorAll('.premiacao-visualizar').forEach(function (button) {


            button.addEventListener('click', function () {
                const icon = this.querySelector('i');
                const premiacaoId = this.getAttribute('data-id');  // Captura o data-id

                if (icon.classList.contains('fa-eye')) {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                    console.log(`Premiação ${premiacaoId} foi escondida.`);


                    $("#" + premiacaoId).hide();

                    save_config("ranking_visivel_" + premiacaoId, "false");
                    // Aqui você pode salvar a informação usando AJAX, Fetch API ou outra solução.
                } else {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                    console.log(`Premiação ${premiacaoId} foi mostrada.`);
                    $("#" + premiacaoId).show()
                    save_config("ranking_visivel_" + premiacaoId, "true");


                    // Aqui você pode salvar a informação usando AJAX, Fetch API ou outra solução.
                }
            });
        });



        document.addEventListener('DOMContentLoaded', function () {
            // Detecta o clique no botão com a classe settings-sync
            document.querySelector('.settings-sync').addEventListener('click', function () {


                atualizarColaboradores();


            });
        });


        $('.toggle-event').change(function ($this) {

            var config_info = $(this).data('config_info');
            var config_value = $(this).prop('checked');


            if (config_info == "ranking_mostrar_equipe") {

                mostra_equipe = config_value

                atualizarColaboradores();
            }

            if (config_info == "ranking_mostrar_vendas") {

                if ($('#header-total').css('display') == 'none') {
                    $('#header-total').css('display', 'flex')
                } else {
                    $('#header-total').css('display', 'none')
                }

            }

            save_config(config_info, config_value);

        });



        var ids_toggle = [

            'racing_vendas_max',

        ];

        ids_toggle.forEach(function (id) {
            var element = document.getElementById(id);
            if (element) {
                element.addEventListener('blur', function (e) {
                    var value = e.target.value;

                    save_config(id, value);

                });
            }
        });




        function ajustarContainer() {
            const container = document.querySelector('.container2');
            let scaleFactor = Math.min(
                document.documentElement.clientWidth / 1800, // Largura original da div container2
                document.documentElement.clientHeight / 1000 // Altura original da div container2
            );


            if (scaleFactor > 1) {
                scaleFactor = scaleFactor - scaleFactor * 0.1;
            }
            container.style.transform = `scale(${scaleFactor})`; // Ajusta a escala
            container.style.transformOrigin = 'top center'; // Mantém a escala a partir do canto superior esquerdo


            var height__ = parseInt(document.documentElement.clientHeight) - 210;


        }

        let fullscreen = false;
        window.addEventListener('resize', ajustarContainer);
        window.addEventListener('load', ajustarContainer);

        document.querySelector('.fullscreen-toggle').addEventListener('click', function () {


            fullscreen = true;
            $(".menu-bar").css('display', 'none');
            $('.header-total').css('display', 'none');
            $('.header-panel').css('display', 'none');
            $('.footer-panel').css('display', 'none');
       

            $('.container2').css('padding', '0px');
            ajustarContainer()

        });

        const container = document.querySelector('.container2');

        // Adiciona um ouvinte de evento de clique ao documento
        document.addEventListener('click', function (event) {
            // Verifica se o clique ocorreu fora do container2
            if (container.contains(event.target)) {

                if (fullscreen == true) {

                    $(".menu-bar").css('display', 'flex');
                    $('.header-total').css('display', 'flex');
                    $('.header-panel').css('display', 'flex');
                    $('.footer-panel').css('display', 'flex');
                    $('.container2').css('padding', '20px');
                   
                    ajustarContainer()

                }

                fullscreen = false;

            }
        });


    </script>
</body>

</html>