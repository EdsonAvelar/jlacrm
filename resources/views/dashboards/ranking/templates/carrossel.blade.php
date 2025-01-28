<!-- Barra de progresso no topo -->
<div id="barra-progresso"
    style="position: fixed; top: 0; left: 0; width: 0%; height: 5px; background-color: #28a745; z-index: 9999;"></div>


@if (app('request')->has('carrossel') )
<div id="overlay2"></div>
<div id="overlay1"></div>
@endif

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const params = new URLSearchParams(window.location.search);

    if (params.has('carrossel')) {
        const overlay1 = document.getElementById('overlay2');
        const overlay2 = document.getElementById('overlay2');
        // Adiciona a classe 'hidden' para iniciar o clareamento
        setTimeout(() => {
            overlay2.classList.add('overlay-fade-in');
           
        }, 500); // Meio segundo de atraso antes de começar o fade-out

        // Só executar o carrossel se o parâmetro 'carrossel' estiver presente na URL
        
            document.body.classList.add('fade-in'); // Inicia esmaecida

            // Clareia a página (fade-in) após a carga
            setTimeout(() => {
                document.body.classList.add('loaded'); // Clareia a página
            }, 500); // Meio segundo para clarear após carregar

            // Configurações da barra de progresso
            const barraProgresso = document.getElementById('barra-progresso');
            const tempoTotal = "{{config('ranking_carrossel_timer') ?? 120000}}" ; // 10 segundos (10000 ms)
            console.log("Iniciando carrossel após "+(tempoTotal/1000)+" segundos")
            const interval = 500; // Atualiza a barra a cada 500ms
            const fadeOutStart = 2000; // Inicia o fade-out nos últimos 2 segundos

            let tempoRestante = tempoTotal;
            let larguraAtual = 0;

            // Função para atualizar a barra de progresso
            function atualizarBarraProgresso() {
                larguraAtual = ((tempoTotal - tempoRestante) / tempoTotal) * 100;
                barraProgresso.style.width = `${larguraAtual}%`;

                if (tempoRestante <= fadeOutStart) {
                    // Inicia o fade-out quando chegar nos últimos 2 segundos
                    //document.body.classList.add('fade-out');
                    overlay1.classList.add('overlay-fade-out');
                }

                if (tempoRestante <= 0) {
                    clearInterval(intervalId);

                    // Redireciona para a próxima URL após o fade-out
                    setTimeout(() => {
                        const proximaUrl = "{{url('')}}/ranking/{{$proximaUrl}}";
                        window.location.href = proximaUrl + "?carrossel=true";
                    }, 1000); // Tempo de espera do fade-out (1s)
                } else {
                    tempoRestante -= interval;
                }
            }

            // Atualiza a barra a cada intervalo definido
            const intervalId = setInterval(atualizarBarraProgresso, interval);

            // Ativa o modo fullscreen se o carrossel estiver ativado na URL
            set_tofullscreen(); // Função que você já definiu para fullscreen
        }
    });
</script>