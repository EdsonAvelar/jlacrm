<!-- Barra de progresso no topo -->
<div id="barra-progresso"
    style="position: fixed; top: 0; left: 0; width: 0%; height: 5px; background-color: #28a745; z-index: 9999;"></div>

<div class="menu-bar">
    <div class="logo">
        <a href="{{url('')}}/crm"> <img style="width: 50px; height: 50px;"
                src="{{url('')}}/images/empresa/logos/empresa_logo_circular.png" />
        </a>
        <div class="title">
            <h1 style="font-size: 2vw">{{ $title }}</h1>
        </div>
    </div>
    <div class="actions">

        <button class="settings-vendas"><i class="fas fa-trophy"></i></button>
        <button class="settings-ajuda"><i class="fas fa-hands-helping"></i></button>
        <button class="settings-telemarketing"><i class="fas fa-phone"></i></button>

        <button class="settings-agendamentos"><i class="fas fa-calendar"></i></button>
        <button class="settings-times"><i class="fas fa-futbol"></i></button>


        @if (app('request')->has('carrossel') )
        <button class="carrossel-stop"><i class="fas fa-stop"></i></button>
        @else
        <button class="carrossel-play"><i class="fas fa-play"></i></button>
        @endif

        <button class="fullscreen-toggle"><i class="fas fa-expand"></i></button>

        <button class="settings"><i class="fas fa-cog"></i></button>
    </div>
</div>

<script>
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

            document.querySelector('.settings-ajuda').addEventListener('click', function () {
            window.location.href = "{{ route('ranking.vendas.ajuda') }}";
            });

            document.querySelector('.settings-telemarketing').addEventListener('click', function () {
            window.location.href = "{{ route('ranking.vendas.telemarketing') }}";
            });
        });

     function atualizarURL(parametro, valor) {
        const url = new URL(window.location.href); // Obtém a URL atual
        if (valor === null) {
            url.searchParams.delete(parametro); // Remove o parâmetro
        } else {
            url.searchParams.set(parametro, valor); // Define ou atualiza o parâmetro
        }
        window.location.href = url; // Redireciona para a nova URL
    }

    // Verifica se o botão "play" existe e adiciona o event listener
    const playButton = document.querySelector('.carrossel-play');
    if (playButton) {
        playButton.addEventListener('click', function() {
            atualizarURL('carrossel', 'true'); // Adiciona o parâmetro 'carrossel=true'
        });
    }

    // Verifica se o botão "stop" existe e adiciona o event listener
    const stopButton = document.querySelector('.carrossel-stop');
    if (stopButton) {
        stopButton.addEventListener('click', function() {
            atualizarURL('carrossel', null); // Remove o parâmetro 'carrossel'
        });
    }


</script>