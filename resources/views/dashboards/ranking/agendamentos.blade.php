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
    $tema = 'tema02';
}


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking de Agendamentos</title>
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

    {{-- <div class="menu-bar">
        <div class="logo">
            <a href="{{url('')}}/crm"> <img style="width:150px"
                    src="{{url('')}}/images/empresa/logos/empresa_logo_horizontal.png" />
            </a>
            <div class="title">Ranking de Agendamentos</div>
        </div>
        <div class="actions">


            {{-- <button class="support">Suporte</button>
            <button class="manage manage-collaborators">Gerenciar Colaborador</button>
            <button class="settings-vendas"><i class="fas fa-trophy"></i></button>
            <button class="settings-agendamentos"><i class="fas fa-medal"></i></button>
            <button class="settings-times"><i class="fas fa-futbol"></i></button>
            <button class="settings-sync"><i class="fas fa-sync-alt"></i></button>
            <button class="fullscreen-toggle"><i class="fas fa-expand"></i></button>
            <button class="settings"><i class="fas fa-cog"></i></button>
        </div>
    </div> --}}

    @include('dashboards.ranking.templates.menu_bar',
    ['title'=>'Ranking de Agendamentos'])

    <div class="container2">
        <!-- Ranking Board Section -->
        <div class="ranking">
            <div class="ranking-header">
                <div class="ranking-info">
                    <i class="fas fa-arrow-left"></i>
                    <span>Rankings</span>

                </div>
                <div class="ranking-totals">

                    <span style="color:white">Total de Agendamentos: </span> <span class="total-time"></span>
                    {{-- <span style="color:gray">Total do top 3: </span> <span class="total-top3">R$106.508,00</span>
                    --}}
                </div>
            </div>
            <div class="ranking-board">
                <div class="item">

                    <div class="award segundo" id="premiacao_2" <?php if (config('ranking_visivel_premiacao_2')=="false"
                        ){ echo 'style="display:none"' ; } ?>>
                        <img src="{{asset('images/ranking/user/premiacao_2.png')}}" alt="Premiação">
                        <div id="txt_ranking_premiacao_2">{{ strtoupper( config('ranking_premiacao_2')) }} </div>
                    </div>


                    <div class="position-wrapper2">
                        <div class="collaborator-photo" id="collaborator-photo-2"
                            style="background-image: url('https://via.placeholder.com/80');"></div>
                    </div>

                    <div class="nome segundo">
                        <div id="nome2">Adriano</div>
                        <div id="valor2">1</div>
                    </div>
                </div>
                <div class="item">
                    <div class="award primeiro" id="premiacao_1" <?php if
                        (config('ranking_visivel_premiacao_1')=="false" ){ echo 'style="display:none"' ; } ?>>
                        <img src="{{asset('images/ranking/user/premiacao_1.png')}}" alt="Premiação">
                        <div id="txt_ranking_premiacao_1">{{ strtoupper( config('ranking_premiacao_1')) }}</div>
                    </div>
                    <div class="position-wrapper1">
                        <div class="collaborator-photo" id="collaborator-photo-1"
                            style="background-image: url('https://via.placeholder.com/80');"></div>
                    </div>
                    <div class="nome primeiro">
                        <div id="nome1">Adriano</div>
                        <div id="valor1">1</div>
                    </div>

                </div>
                <div class="item">
                    <div class="award terceiro" id="premiacao_3" <?php if
                        (config('ranking_visivel_premiacao_3')=="false" ){ echo 'style="display:none"' ; } ?>
                        >
                        <img src="{{asset('images/ranking/user/premiacao_3.png')}}" alt="Premiação">
                        <div id="txt_ranking_premiacao_3">{{ strtoupper( config('ranking_premiacao_3')) }}</div>
                    </div>
                    <div class="position-wrapper3">
                        <div class="collaborator-photo" id="collaborator-photo-3"
                            style="background-image: url('https://via.placeholder.com/80');">
                        </div>
                    </div>
                    <div class="nome terceiro">
                        <div id="nome3">Adriano</div>
                        <div id="valor3">1</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Panel Section -->
        <div class="info-panel">
            <div class="header-panel">
                <select name="update-interval" id="update-interval">
                    <option value="10000">10s</option>
                    <option value="30000">30s</option>
                    <option value="60000">1m</option>
                    <option value="1800000">30m</option>
                    <option value="3600000">60m</option>
                </select>
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
            <div class="logo-empresa">
                <h1 class="titulo-logo" style="display: none">Ranking de Agendamentos</h1>
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
                            Meta:
                            <?= $colaborador['meta'] ?> | Total:
                            <?= $colaborador['total'] ?>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" style="width: <?= $colaborador['percentual'] ?>%;"></div>
                        </div>
                        <div class="missing-value">Faltam:
                            <?= ($colaborador['meta'] - $colaborador['total']) ?>
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


                <div class="mb-3">
                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                        <label for="inputEmail3" class="col-form-label">Mostrar Equipes
                            <span class="mdi mdi-information"></span>
                        </label> </span>

                    <input class="toggle-event" type="checkbox" <?php $monstrar=config("ranking_mostrar_equipe"); if
                        ($monstrar!=null & $monstrar=='true' ){ echo 'checked' ;} ?>
                    data-config_info="ranking_mostrar_equipe" data-toggle="toggle"
                    data-on="com equipe" data-off="sem equipe"
                    data-onstyle="success"
                    data-offstyle="danger">
                </div>



                {{--
                <div class="col-md-8">
                    <h1>Monstrar Equipe</h1>
                    </h1>
                </div>
                <div class="col-md-4"></div> --}}



            </div>
            <div id="premiacao" class="content-section hidden">
                <h4>Premiações</h4>
                <p>Defina as premiação de cada posição.</p>

                <div class="premiacao-item">
                    <div class="premiacao-icon">

                        <img src="{{asset('images/ranking/tema02/icon-primeiro.png')}}" alt="Gold Trophy">
                    </div>
                    <div class="premiacao-1-img">
                        <a href="#" onclick="image_save('','/premiacao_1.png')" class="text-muted font-14">
                            <img src="{{ url('') }}/images/ranking/user/premiacao_1.png" class="avatar-lx img-thumbnail"
                                alt="profile-image">
                        </a>
                    </div>

                    <div class="premiacao-info">
                        <input type="text" value="{{config('ranking_premiacao_1')}}" id="ranking_premiacao_1" />
                    </div>
                    <div class="premiacao-visualizar" data-id="premiacao_1">
                        <?php 
                                            if (config('ranking_visivel_premiacao_1') == "false"){
                                                echo '<i class="fas fa-eye-slash"></i>';
                                            }else {
                                                echo '<i class="fas fa-eye"></i>';
                                            }
                                            
                                            ?>
                    </div>
                </div>
                <div class="premiacao-item">

                    <div class="premiacao-icon">
                        <img src="{{asset('images/ranking/tema02/icon-segundo.png')}}" alt="Silver Trophy">
                    </div>

                    <div class="premiacao-1-img">
                        <a href="#" onclick="image_save('','/premiacao_2.png')" class="text-muted font-14">
                            <img src="{{ url('') }}/images/ranking/user/premiacao_2.png" class="avatar-lx img-thumbnail"
                                alt="profile-image">
                        </a>
                    </div>

                    <div class="premiacao-info">
                        <input type="text" value="{{config('ranking_premiacao_2')}}" id="ranking_premiacao_2" />
                    </div>
                    <div class="premiacao-visualizar" data-id="premiacao_2">
                        <?php 
                            if (config('ranking_visivel_premiacao_2') == "false"){
                                echo '<i class="fas fa-eye-slash"></i>';
                            }else {
                                echo '<i class="fas fa-eye"></i>';
                            }
                            
                            ?>
                    </div>
                </div>
                <div class="premiacao-item">
                    <div class="premiacao-icon">
                        <img src="{{asset('images/ranking/tema02/icon-terceiro.png')}}" alt="Bronze Trophy">
                    </div>

                    <div class="premiacao-1-img">
                        <a href="#" onclick="image_save('','/premiacao_3.png')" class="text-muted font-14">
                            <img src="{{ url('') }}/images/ranking/user/premiacao_3.png" class="avatar-lx img-thumbnail"
                                alt="profile-image">
                        </a>
                    </div>
                    <div class="premiacao-info">
                        <input type="text" value="{{config('ranking_premiacao_3')}}" id="ranking_premiacao_3" />
                    </div>
                    <div class="premiacao-visualizar" data-id="premiacao_3">

                        <?php 
                   if (config('ranking_visivel_premiacao_3') == "false"){
                        echo '<i class="fas fa-eye-slash"></i>';
                    }else {
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


    <script>
        $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    var intervalId;

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
                    var value = e.target.value.toUpperCase();

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

            let equipe= "none";
            if (mostra_equipe){
                equipe= "flex";
            }
            $.ajax({
                url: "{{url('/ranking/colaboradores/agendamentos')}}" ,
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
                                <div class="meta">Meta: ${colaborador.meta.toLocaleString()} | Total: ${colaborador.total.toLocaleString()}</div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: ${colaborador.percentual}%;"></div>
                                </div>
                                <div class="missing-value">Faltam: ${(colaborador.meta - colaborador.total).toLocaleString()}</div>
                            </div>
                            <div class="percentage">${Math.round(colaborador.percentual) }%</div>
                            ${html_colaborador}
                        </div>`;
                    });
    
                    $('.body-panel').html(html);

                    for (let index = 0; index < 3; index++) {                     

                        $('#nome'+(index+1)).html(colaboradores[index].name);
                        $('#valor'+(index+1)).html(colaboradores[index].total);

                        $('#collaborator-photo-'+(index+1)).css('background-image', 'url('+colaboradores[index].avatar+')');

                        if (colaboradores[index].total >= colaboradores[index].meta){
                            $('#collaborator-photo-'+(index+1)).addClass('brilho')
                        }
                        
                       

                    }

                    $('.total-time').html(data.total_vendas)
                  
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
      


        // Função para atualizar o intervalo
        function updateInterval() {
            clearInterval(intervalId); // Limpar o intervalo anterior
            var intervalTime = $('#update-interval').val(); // Obter o novo valor do select
            
            console.log("Atualização mudou para cada "+intervalId/1000+"s")


            intervalId = setInterval(atualizarColaboradores, intervalTime); // Definir novo intervalo
            
        }

        // Definindo o intervalo padrão ao carregar a página
        $(document).ready(function() {
            updateInterval(); // Chamar a função para iniciar o intervalo padrão


            // Event listener para detectar mudanças no select
            $('#update-interval').on('change', function() {
                updateInterval(); // Atualizar o intervalo quando o select mudar
            });
        });
    </script>



    <script>
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

            console.log( config_info, config_value )
            if (config_info == "ranking_mostrar_equipe"){
          
                mostra_equipe = config_value

                atualizarColaboradores();
            }
            
            save_config(config_info, config_value);
        
        });


      function ajustarContainer() {
            const container = document.querySelector('.container2');
            let scaleFactor = Math.min(
                document.documentElement.clientWidth / 1800, // Largura original da div container2
                document.documentElement.clientHeight / 1000 // Altura original da div container2
            );
        
            if (scaleFactor > 1){
                scaleFactor = scaleFactor - scaleFactor*0.1;
            }
            container.style.transform = `scale(${scaleFactor})`; // Ajusta a escala
            container.style.transformOrigin = 'top center'; // Mantém a escala a partir do canto superior esquerdo
            // container.style.width = '1800px'; // Mantém a largura original
            // container.style.height = '1000px'; // Mantém a altura original

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
            
            ajustarContainer();
        }
        document.querySelector('.fullscreen-toggle').addEventListener('click', function () {
            
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


    // const params = new URLSearchParams(window.location.search);
    //     // Verifica se o parâmetro 'atributo' existe
    //     if (params.has('carrossel')) {
        
    //     set_tofullscreen()
        
    //     setTimeout(() => {
    //     window.location.href = "{{url('')}}/ranking/vendas?carrossel=true" ; // Substitua pela URL desejada
    //     }, 10000);
    //     }


    </script>

    @include('dashboards.ranking.templates.carrossel', ['proximaUrl' => 'vendas'])
</body>

</html>