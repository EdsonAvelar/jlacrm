<?php 



$colaboradores = [
  
];

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 6;
$total = count($colaboradores);
$pages = ceil($total / $perPage);

$start = ($page - 1) * $perPage;
$colaboradoresPaginados = array_slice($colaboradores, $start, $perPage);

$tema = app('request')->tema;

#$tema = config('ranking_tema_vendas')
if ($tema == ''){
    $tema = 'tema01';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking de Vendas</title>
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
    ['title'=>'Ranking de vendas'])

    @include('dashboards.ranking.templates.config_menu',
    ['title'=>'Ranking de vendas'])

    <div class="container2">

        <!-- Ranking Board Section -->
        <div class="ranking">
            <div class="ranking-header">
                <div class="ranking-info">
                    <i class="fas fa-arrow-left"></i>
                    <span>Rankings</span>
                </div>

                <div class="ranking-totals" id="header-total"
                    style="display: {{ config('ranking_mostrar_vendas') == 'true'? 'flex' : 'none' }}">

                    <span style="color:gray">Total em Vendas: </span> <span class="total-time">R$ 0</span>
                    {{-- <span style="color:gray">Total do top 3: </span> <span class="total-top3">R$106.508,00</span>
                    --}}
                </div>
            </div>
            <div class="ranking-board">
                <div class="item">

                    <div class="award segundo" id="premiacao_2" <?php if (config('ranking_visivel_premiacao_2')=="false"
                        ){ echo 'style="display:none"' ; } ?>>
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
                    <div class="award primeiro" id="premiacao_1" <?php if
                        (config('ranking_visivel_premiacao_1')=="false" ){ echo 'style="display:none"' ; } ?>>
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
                    <div class="award terceiro" id="premiacao_3" <?php if
                        (config('ranking_visivel_premiacao_3')=="false" ){ echo 'style="display:none"' ; } ?>
                        >
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
            {{-- <div class="header-panel">
                <select name="update-interval" id="update-interval">
                    <option value="5000">5s</option>
                    <option value="15000">15s</option>
                    <option value="30000">30s</option>
                    <option value="60000">1m</option>
                    <option value="180000">3m</option>
                    <option value="300000">5m</option>
                </select>
                <div class="pagination-controls">
                    <i class="fas fa-arrow-left"></i>
                    <i class="fas fa-play"></i>
                    <i class="fas fa-arrow-right"></i>
                    <span>
                        <?= $page ?> /
                        <?= $pages ?>
                    </span>
                </div>
            </div>
            --}}

            <h4 style="
                color: white;
                font-size: xx-large;
                font-weight: bold;
                font-family: sans-serif;
            ">Ranking de Vendas</h4>

            <div class="logo-empresa">
                <h1 class="titulo-logo" style="display: none">Ranking de Vendas</h1>
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
            
            ids_toggle.forEach(function(id) {
                var element = document.getElementById(id);
                if (element) {
                    element.addEventListener('blur', function(e) {
                    var value = e.target.value.toUpperCase();;

                    console.log(id,value)

                    save_config(id, value);
                    $("#txt_"+id).html(value);
              
                    });
                }
            });



    function save_config(config_info, config_value, alert=true) {

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
                success: function(res) {

                if (alert){
                console.log(res)
    
                }
                   
                },
                error: function(res) {

                if (alert){
                    console.log(res)
                }
                   
                },
            });
        }

      

        function atualizarColaboradores() {

            console.log("Atualização de Colaboradores");
            let equipe= "none";
            if (mostra_equipe){
                equipe= "flex";
            }
            $.ajax({
                url: "{{ url('ranking/colaboradores/vendas') }}" ,
                method: 'GET',
                success: function(data) {
                    let colaboradores = data.colaboradores;
                    
                    let html = '';
                    colaboradores.forEach(function(colaborador, index) {
                        let html_colaborador = "";
                        
                        
                        if (colaborador.equipe_logo != null ){

                            html_colaborador = `
                            <div class="team-section" style='display:${equipe}'">
                                <div class="team-photo" style="background-image: url('${colaborador.equipe_logo}');">
                                    <!-- Imagem da equipe -->
                                </div>
                                <div class="team-name">
                                    <!-- Nome da equipe -->
                                    <p>${colaborador.equipe_name}</p>
                                </div>
                            </div>`
                        }
                        html += `
                        <div class="collaborator-card ${colaborador.total >= colaborador.meta ? 'vendas-meta-batida' : ''}">
                            <div class="position">${index + 1}</div>
                            <div class="photo ${colaborador.total >= colaborador.meta ? 'brilho ' : ''}" style="background-image: url('${colaborador.avatar}');"></div>
                            <div class="collaborator-info">
                                <div class="name">${colaborador.name}</div>
                                <div class="meta">Meta: R$ ${colaborador.meta.toLocaleString()} | Total: R$
                                    ${colaborador.total.toLocaleString()}</div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: ${colaborador.percentual}%;"></div>
                                </div>
                                <div class="missing-value">` +
                                    (colaborador.total <= colaborador.meta ? `Faltam: R$ ${(colaborador.meta -
                                        colaborador.total).toLocaleString()}` : `Estraçalhou a meta em: R$ ${(colaborador.total -
                                        colaborador.meta).toLocaleString()}` ) + `</div>
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

                        $('#nome'+(index+1)).html(colaboradores[index].name);
                        $('#valor'+(index+1)).html(valorFormatado);

                        $('#collaborator-photo-'+(index+1)).css('background-image', 'url('+colaboradores[index].avatar+')');

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

        

        $(document).ready(function() {

            let has_equipe = "{{config('ranking_mostrar_equipe')}}";
            if (has_equipe == "false"){        
                mostra_equipe=false;
            }else {
                mostra_equipe=true;
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
            var item = lookup.slice().reverse().find(function(item) {
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
    
        var channel = pusher.subscribe( "{{ config('broadcast_canal') }}" );
        console.log('pusher'+channel);
        channel.bind('nova-venda', function(data) {

            

           

            var nome_cliente = data.data.cliente.split(' ');
            var sobrenome = ''
            
            if (nome_cliente.length > 1){
            sobrenome = nome_cliente[ nome_cliente.length - 1]
            }
            
        
            document.getElementById('venda_valor').innerText = "Crédito: " +nFormatter( data.data.credito, 2);
            document.getElementById('nome_cliente').innerText = "Cliente: " + nome_cliente[0] +' '+sobrenome;
            document.getElementById('nome_vendedor').innerText = data.data.vendedor;
            document.getElementById('nome_equipe').innerText = data.data.equipe_nome ? "Equipe: "+data.data.equipe_nome : '';
            
            document.getElementById('imagem_vendedor').src = data.data.avatar;


            if (data.data.equipe_logo){
                $("#imagem_equipe").show()
                document.getElementById('imagem_equipe').src = data.data.equipe_logo ;
            }else {
                $("#imagem_equipe").hide()
            }
           
            document.getElementById('imagem_empresa').src = data.data.empresa ;
        
            
            setTimeout(function() {
                showNotification();
    
                
                atualizarColaboradores();

                var aplausos = "{{ config('broadcast_audio') }}"
                

                if (aplausos == "true"){
                
                    var musicPlayer = document.getElementById('musicPlayer');
                    musicPlayer.play();

                    setTimeout(function() {
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

        document.addEventListener('DOMContentLoaded', function() {
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
        document.querySelectorAll('.premiacao-visualizar').forEach(function(button) {


            button.addEventListener('click', function() {
                const icon = this.querySelector('i');
                const premiacaoId = this.getAttribute('data-id');  // Captura o data-id

                if (icon.classList.contains('fa-eye')) {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                    console.log(`Premiação ${premiacaoId} foi escondida.`);


                    $("#"+premiacaoId).hide();

                    save_config("ranking_visivel_"+premiacaoId, "false");
                    // Aqui você pode salvar a informação usando AJAX, Fetch API ou outra solução.
                } else {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                    console.log(`Premiação ${premiacaoId} foi mostrada.`);
                    $("#"+premiacaoId).show()
                    save_config("ranking_visivel_"+premiacaoId, "true");


                    // Aqui você pode salvar a informação usando AJAX, Fetch API ou outra solução.
                }
            });
        });

 
        $('.toggle-event').change(function($this) {
        
            var config_info = $(this).data('config_info');
            var config_value = $(this).prop('checked');

       
            if (config_info == "ranking_mostrar_equipe"){
          
                mostra_equipe = config_value

                atualizarColaboradores();
            }

            if(config_info == "ranking_mostrar_vendas"){

                if ($('#header-total').css('display') == 'none'){
                    $('#header-total').css('display','flex')
                }else{
                    $('#header-total').css('display','none')
                }
            }

            
            save_config(config_info, config_value);    

            if(config_info == "ranking_carrossel"){
            
                window.location.href = "{{url('')}}/ranking/vendas"
            }  
        });
        var ids_toggle = [

            'racing_vendas_max',
      
        ];
        
        ids_toggle.forEach(function(id) {
            var element = document.getElementById(id);
                if (element) {
                element.addEventListener('blur', function(e) {
                var value = e.target.value;
                
                save_config(id, value);
                
                });
            }
        });

        function ajustarContainer() {
            const container = document.querySelector('.container2');
            const menu_bar = document.querySelector('.menu-bar');
            let scaleFactor = Math.min(
                document.documentElement.clientWidth / 1800, // Largura original da div container2
                document.documentElement.clientHeight / 1000 // Altura original da div container2
            );

           
            if (scaleFactor > 1){
                scaleFactor = scaleFactor - scaleFactor*0.1;
            }


            container.style.transform = `scale(${scaleFactor})`; // Ajusta a escala
            container.style.transformOrigin = 'top center'; // Mantém a escala a partir do canto superior esquerdo


             var height__ = parseInt(document.documentElement.clientHeight) - 210;
           
        }

        let fullscreen = false;
        window.addEventListener('resize', ajustarContainer);
        window.addEventListener('load', ajustarContainer);

    function set_tofullscreen(){
        fullscreen = true;
        $(".menu-bar").css('display','none');
        $('.ranking-header').css('display','none');
        $('.header-panel').css('display','none');
        $('.footer-panel').css('display','none');
        $('.container2').css('padding','0px');
        
        ajustarContainer()
    }
        document.querySelector('.fullscreen-toggle').addEventListener('click', function () {
            set_tofullscreen()
        });

    const container = document.querySelector('.container2');
    
    // Adiciona um ouvinte de evento de clique ao documento
    document.addEventListener('click', function(event) {
    // Verifica se o clique ocorreu fora do container2
        if (container.contains(event.target) ) {

            if ( fullscreen == true){
            
            $(".menu-bar").css('display','flex');
            $('.ranking-header').css('display','flex');
            $('.header-panel').css('display','flex');
            $('.footer-panel').css('display','flex');
            $('.container2').css('padding','20px');
            ajustarContainer()
            
            }

            fullscreen = false;

        }
    });

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

    

    </script>

    @if (config('ranking_filiais'))

    @include('dashboards.ranking.templates.carrossel', ['proximaUrl' => 'filiais/vendas/equipes'])
    @else
    @include('dashboards.ranking.templates.carrossel', ['proximaUrl' => 'vendas/equipes'])
    @endif



</body>

</html>