<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #1f2045;
        /* color: white; */
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .missing-value {
        color: white;
    }

    .name {
        color: white;
    }

    .nome {
        color: white;
    }

    .meta {
        color: white;
    }

    .menu-bar {
        width: 90%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #181942;
        padding: 10px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .menu-bar .logo {
        display: flex;
        align-items: center;
    }

    .menu-bar .logo img {
        width: 200px;
        margin-right: 10px;
    }

    .menu-bar .title {
        font-size: 1.5em;
        font-weight: bold;
        color: #ffffff;
    }

    .menu-bar .actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .menu-bar .actions button {
        background-color: transparent;
        color: white;
        border: none;
        padding: 5px 15px;
        border-radius: 5px;
        cursor: pointer;
    }

    .menu-bar .actions .manage {
        background-color: #1565c0;
    }

    .menu-bar .actions .settings {
        background-color: transparent;
        border: none;
        color: white;
        font-size: 1.2em;
    }

    .container2 {
        width: 1800px;
        height: 100%;
        display: flex;
        justify-content: space-between;
        padding: 20px;
        background-color: #1c1d40;
        border-radius: 10px;
        flex-direction: row;
    }

    .ranking {
        flex: 2;
        padding-right: 10px;
    }

    .ranking-board {
        display: flex;
        justify-content: space-around;
        align-items: center;
        margin-top: 20px;
        background: #21224f;
        border-radius: 10px;
        padding: 20px;
        background: url("{{ url('/images/ranking/'.$tema.'/background_ranking.png') }}");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 1000px;
    }

    .item {
        position: relative;
        text-align: center;
    }

    .award {
        position: absolute;
        top: -150px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        flex-direction: column;
        align-items: center;
        animation: flipCoin 5s ease-in-out infinite;
    }

    .award.primeiro {
        top: -320px;
        left: 142px;
    }

    .award.segundo {
        top: -134px;
        left: 171px;
    }

    .award.terceiro {
        top: -116px;
        left: 121px;
    }

    .award img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: 2px solid #ffffff;
    }

    .award div {
        margin-top: 5px;
        font-size: 0.9em;
        color: white;
        font-weight: bold;
        font-family: sans-serif;
    }

    .ranking-board .item {
        text-align: center;
    }

    .ranking-board .item img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin-bottom: 10px;
        border: 3px solid #fff;
    }

    .ranking-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .ranking-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .ranking-info i {
        font-size: 1.5em;
        cursor: pointer;
    }

    .ranking-totals {
        display: flex;
        gap: 20px;
        font-weight: bold;
        color: greenyellow;
        font-size: large;
        padding: 10px;
        border-radius: 10px;
        background: #2e2e72;
    }



    .info-panel {
        flex: 1;
        background-color: #21224f;
        border-radius: 10px;
        padding: 20px;
        /* margin-top: 20px; */

        /* Define o limite de altura */

    }

    .body-panel {
        max-height: 800px;
        overflow-y: auto;
        /* Adiciona o scroll vertical */
        overflow-x: hidden;
        /* Remove o scroll horizontal */
    }

    /* Estilizando o scroll para combinar com as cores da página */
    .body-panel::-webkit-scrollbar {
        width: 10px;
    }

    .body-panel::-webkit-scrollbar-track {
        background: #1f2045;
        /* Cor do fundo do track */
        border-radius: 10px;
    }

    .body-panel::-webkit-scrollbar-thumb {
        background-color: #3f4195;
        /* Cor do "polegar" do scroll */
        border-radius: 10px;
        border: 2px solid #1f2045;
        /* Espaço entre o "polegar" e o track */
    }

    .body-panel::-webkit-scrollbar-thumb:hover {
        background-color: #5a5cc2;
        /* Cor ao passar o mouse */
    }


    .header-panel {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .header-panel select {
        background-color: #2f2f6b;
        color: white;
        border: none;
        padding: 5px;
        border-radius: 5px;
    }

    .header-panel .pagination-controls {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .header-panel .pagination-controls i {
        font-size: 1.2em;
        cursor: pointer;
    }

    .logo-empresa>img {
        display: flex;
        align-items: center;
        background-color: #2f2f6b;
        padding: 10px 20px;
        border-radius: 10px;
        margin-bottom: 10px;
        position: relative;
        width: 100%;
        padding: 30px 10px 30px 10px;
    }


    .collaborator-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #2f2f6b;
        padding: 10px 20px;
        border-radius: 10px;
        margin-bottom: 10px;
        position: relative;
    }

    .collaborator-card .position {
        font-size: 1.5em;
        font-weight: bold;
        color: white;
        background-color: #3f4195;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 20px;
        border: 2px solid white;
    }

    .collaborator-card .photo {
        width: 100px;
        height: 80px;
        border-radius: 50%;
        background-size: cover;
        background-position: center;
        margin-right: 10px;
        border: 2px solid white;
    }

    .collaborator-info {
        flex-grow: 1;
        width: 75%;
        /* Ajuste a largura da seção de informações */
    }

    .team-section {

        flex-direction: column;
        align-items: center;
        width: 20%;
        /* Definindo cerca de 20% da largura */
        padding-left: 10px;
    }

    .team-section .team-photo {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-size: cover;
        background-position: center;
        margin-bottom: 5px;
        border: 2px solid #fff;
    }

    .team-section .team-name {
        font-size: 0.9em;
        color: #ffffff;
        text-align: center;
    }

    .collaborator-info .name {
        font-size: 1.2em;
        font-weight: bold;
    }

    .collaborator-info .meta {
        font-size: 0.9em;
    }

    .collaborator-info .progress-bar {
        height: 10px;
        background: linear-gradient(90deg, #12c2e9, #c471ed, #f64f59);
        border-radius: 5px;
        margin: 5px 0;
    }

    .collaborator-info .missing-value {
        font-size: 0.9em;
        margin-top: 5px;
    }

    .percentage {
        margin-left: 10px;
        font-weight: bold;
        color: #a5a5a5;
    }

    .controls {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .controls input,
    .controls button {
        background-color: #3f4195;
        border: none;
        padding: 5px 10px;
        color: white;
        border-radius: 5px;
        cursor: pointer;
    }

    .controls input {
        width: 120px;
    }

    .footer-panel {
        width: 90%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        background-color: #181942;
        border-radius: 10px;
        margin-top: 20px;
        color: white;
        font-size: 0.9em;
    }

    .active-rankings {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .active-rankings i {
        font-size: 1.2em;
        color: #737cbd;
    }

    .update-timer {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .update-timer i {
        font-size: 1.2em;
        cursor: pointer;
    }

    .position-wrapper1 {
        width: 320px;
        height: 320px;
        background-image: url("{{ url('images/ranking/'.$tema.'/primeiro_lugar.png')}}");
        background-size: cover;
        background-position: center;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        margin: 0 auto;
        transform: translate(20px, -160px);
        left: 20px;
        animation: subtleMovement1 6s infinite ease-in-out
    }

    .position-wrapper2 {
        width: 320px;
        height: 320px;
        background-image: url("{{ url('images/ranking/'.$tema.'/segundo_lugar.png')}}");
        background-size: cover;
        background-position: center;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        margin: 0 auto;
        left: 50px;
        transform: translate(40px, -50px);
        animation: subtleMovement2 5s infinite ease-in-out
    }

    .position-wrapper3 {
        width: 320px;
        height: 320px;
        background-image: url("{{ url('images/ranking/'.$tema.'/terceiro_lugar.png')}}");
        background-size: cover;
        background-position: center;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        margin: 0 auto;
        transform: translate(0, 0);
        animation: subtleMovement3 5s infinite ease-in-out
    }

    .collaborator-photo {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        background-size: cover;
        background-position: center;
        border: 3px solid #ffffff;

    }

    .nome {
        background-color: #36befaf5;
        width: 200px;
        left: 70px;
        top: 420px;
        padding: 10px;
        font-family: sans-serif;
        font-weight: bold;
        font-size: large;
        border-radius: 20px;
        position: absolute;
    }

    .nome.primeiro {
        left: 82px;
    }

    .nome.segundo {
        background-color: #1c3414f5;
        top: 552px;
        left: 98px;
    }

    .nome.terceiro {
        background-color: #4c0b05f5;
        top: 569px;
    }


    @keyframes flipCoin {
        0% {
            transform: rotateY(0deg);
        }

        50% {
            transform: rotateY(180deg);
        }

        100% {
            transform: rotateY(360deg);
        }
    }

    @keyframes subtleMovement1 {

        0%,
        100% {
            transform: translateY(-200px) scale(1.05);
        }

        50% {
            transform: translateY(-180px) scale(1.15);
        }
    }

    @keyframes subtleMovement2 {

        0%,
        100% {
            transform: translateY(0px) scale(1);
        }

        50% {
            transform: translateY(-10px) scale(1.05);
        }
    }

    @keyframes subtleMovement3 {

        0%,
        100% {
            transform: translateY(0px) scale(1);
        }

        50% {
            transform: translateY(30px) scale(1.05);
        }
    }



    .notificacao_venda {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        font-size: 2em;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        background: url('{{ asset("images/gifs/confetti.gif") }}') no-repeat center center;
        background-size: cover;
        border: 2px solid white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    }

    .card-vendedor {
        position: relative;
        width: 600px;
        border: 10px solid #464665;
        border-radius: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-around;
        text-align: center;
        padding: 20px;
        color: #d51414;
        background-color: #2f2f6b;
        font-family: sans-serif;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    }

    .card-vendedor img {
        width: 300px;
        height: 300px;
        border-radius: 50%;
        border: 9px solid #d8eff3;
        ;
        object-fit: cover;
    }

    .card-vendedor .texto-cima {
        font-weight: bold;
        font-size: 1.5em;
        color: aquamarine;
    }

    .card-vendedor .texto-cima2 {
        font-weight: bold;
        font-size: 0.8em;
        color: #ffffff;
    }

    .card-vendedor .texto-baixo {
        font-weight: bold;
        font-size: 1.2em;
        color: antiquewhite;
    }

    .loggo {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        border: 2px solid white;
        object-fit: cover;
        position: absolute;
    }

    .loggo.empresa {
        top: -130px;
        left: 50%;
        transform: translateX(-50%);
        width: 150px;
        height: 150px;
        z-index: -100;
        border: 9px solid #c4ecff;
    }

    .loggo.equipe {
        bottom: 10px;
        right: 10px;
        width: 90px;
        height: 90px;
        border: 1px solid #d8eff3;
    }

    .premiacao-item {
        margin-bottom: 20px;
    }

    .premiacao-label {
        display: block;
        font-size: 14px;
        color: #ffffff;
        margin-bottom: 8px;
    }

    .premiacao-info {
        padding: 10px;
        background-color: #2f2f6b;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .premiacao-visualizar {
        cursor: pointer;
    }

    /* Estilo para a janela de contexto */
    #settings-window {
        display: flex;
        flex-direction: row;
        /* Alinhar as abas e o conteúdo lado a lado */
        position: fixed;
        top: 0;
        left: 0;
        width: 800px;
        height: 100%;
        background-color: #1f2045;
        color: white;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        z-index: 1000;
    }

    /* Estilo para o botão de fechar */
    #settings-window .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 1.5em;
        cursor: pointer;
    }

    /* Estilo das abas verticais */
    /* Ajustar o tamanho das abas */
    .settings-tabs {
        width: 200px;
        /* Definir largura fixa para as abas */
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding-top: 30px
    }

    .settings-tab {
        padding: 10px;
        background-color: #181942;
        border-radius: 10px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .settings-tab:hover {
        background-color: #2f2f6b;
    }

    /* Conteúdo da aba selecionada */
    .settings-content {
        flex-grow: 1;
        margin-left: 20px;
        padding-top: 30px
    }

    .hidden {
        display: none;
    }

    /* Estilo para a aba ativa */
    .active-tab {
        background-color: #2f2f6b;
    }

    /* JANELA ESCURA */

    .settings-btn {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1001;
    }

    .context-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
        display: none;
    }

    .context-window {
        position: fixed;
        top: 0;
        left: 0;
        width: 400px;
        height: 100%;
        background-color: #2c2e48;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        z-index: 1000;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .context-window.open {
        transform: translateX(0);
    }

    .context-overlay.show {
        display: block;
    }

    .context-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background-color: #181942;
        border-bottom: 1px solid #444;
    }

    .context-header h5 {
        margin: 0;
        font-size: 1.2em;
        color: #ffffff;
    }

    .close-btn {
        background: none;
        border: none;
        color: white;
        font-size: 1.2em;
        cursor: pointer;
    }

    .context-tabs {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .context-tab {
        padding: 15px;
        font-size: 1em;
        background-color: #181942;
        color: white;
        border-bottom: 1px solid #444;
        cursor: pointer;
        text-align: left;
    }

    .context-tab:hover {
        background-color: #3f4195;
    }

    .context-content {
        flex-grow: 1;
        padding: 20px;
        background-color: #1f2045;
    }

    .context-content input,
    .context-content select,
    .context-content button {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #444;
        background-color: #2c2e48;
        color: white;
    }

    .context-content button {
        background-color: #2e7d32;
        cursor: pointer;
    }

    .context-content button:hover {
        background-color: #1f5d23;
    }

    /* Overlay */
    #overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
        display: none;
    }

    .content-section {
        padding: 20px;
        background-color: #2f2f6b;
        border-radius: 10px;
    }



    /* PREMIAÇÕESSSSSSSS */

    /* Estilo geral da aba de premiações */
    #premiacoes {
        padding: 20px;
        background-color: #1f2045;
        border-radius: 10px;
    }

    .premiacao-item {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        background-color: #181942;
        padding: 10px;
        border-radius: 10px;
        height: 100px;
    }

    .premiacao-icon img {
        width: 50px;
        height: 50px;
    }

    .premiacao-1-img img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 1px;
    }

    .premiacao-info {
        flex-grow: 1;
        margin-left: 15px;
    }

    .premiacao-info input {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: none;
        background-color: #2c2e48;
        color: white;
        font-size: 1em;
    }

    .premiacao-visualizar {
        margin-left: 15px;
        cursor: pointer;
    }

    .premiacao-visualizar i {
        color: white;
        font-size: 1.5em;
    }

    .premiacao-salvar {
        text-align: right;
        margin-top: 20px;
    }

    .premiacao-salvar button {
        padding: 10px 20px;
        background-color: #2e7d32;
        border: none;
        border-radius: 5px;
        color: white;
        cursor: pointer;
        font-size: 1em;
    }

    .premiacao-salvar button:hover {
        background-color: #1f5d23;
    }

    .toggle-event {
        /* Double-sized Checkboxes */
        -ms-transform: scale(1.3);
        /* IE */
        -moz-transform: scale(1.3);
        /* FF */
        -webkit-transform: scale(1.3);
        /* Safari and Chrome */
        -o-transform: scale(1.3);
        /* Opera */
        padding: 10px;
    }


    .brilho {
        animation: glowing 2s infinite;
    }

    @keyframes glowing {
        0% {
            box-shadow: 0 0 5px rgb(255 255 255 / 50%), 0 0 15px rgb(255 255 255 / 94%), 0 0 30px rgba(255, 215, 0, 0.3), 0 0 45px rgba(255, 215, 0, 0.2);
        }

        30% {
            box-shadow: 0 0 10px rgb(246 248 226 / 70%), 0 0 25px rgba(255, 215, 0, 0.6), 0 0 50px rgba(255, 215, 0, 0.5), 0 0 75px rgba(255, 215, 0, 0.4);
        }

        60% {
            box-shadow: 0 0 10px rgb(255 255 255 / 70%), 0 0 25px rgba(255, 215, 0, 0.6), 0 0 50px rgba(255, 215, 0, 0.5), 0 0 75px rgba(255, 215, 0, 0.4);
        }

        100% {
            box-shadow: 0 0 5px rgb(255 215 0), 0 0 15px rgba(255, 215, 0, 0.4), 0 0 30px rgba(255, 215, 0, 0.3), 0 0 45px rgba(255,
                    215, 0, 0.2);
        }
    }


    .vendas-meta-batida {
        background-color: #2f6b34;
        background-image: url("{{url('')}}/images/sistema/fera.png");
        background-size: cover;
    }

    .equipe-meta-batida {
        background-color: #973838;
    }





    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }
</style>