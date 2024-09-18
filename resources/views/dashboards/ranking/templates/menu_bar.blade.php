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
        <button class="settings-agendamentos"><i class="fas fa-medal"></i></button>
        <button class="settings-times"><i class="fas fa-futbol"></i></button>
        <button class="settings-sync"><i class="fas fa-sync-alt"></i></button>
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
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Detecta o clique no botão com a classe settings-sync
            document.querySelector('.settings-sync').addEventListener('click', function() {
            
            
            atualizarColaboradores();
            
            
            });
        });
</script>