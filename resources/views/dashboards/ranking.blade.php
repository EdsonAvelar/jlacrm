<?php 
$colaboradores = [
  
];

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 6;
$total = count($colaboradores);
$pages = ceil($total / $perPage);

$start = ($page - 1) * $perPage;
$colaboradoresPaginados = array_slice($colaboradores, $start, $perPage);
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




    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #1f2045;
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
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
            width: 40px;
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
            background-color: #2e7d32;
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
            background: url("/images/ranking/system/background_ranking.png");
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
            left: 104px;
        }

        .award.segundo {
            top: -134px;
            left: 131px;
        }

        .award.terceiro {
            top: -116px;
            left: 83px;
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
            margin-top: 20px;
            max-height: 1050px;
            /* Define o limite de altura */
            overflow-y: auto;
            /* Adiciona o scroll vertical */
            overflow-x: hidden;
            /* Remove o scroll horizontal */
        }

        /* Estilizando o scroll para combinar com as cores da página */
        .info-panel::-webkit-scrollbar {
            width: 10px;
        }

        .info-panel::-webkit-scrollbar-track {
            background: #1f2045;
            /* Cor do fundo do track */
            border-radius: 10px;
        }

        .info-panel::-webkit-scrollbar-thumb {
            background-color: #3f4195;
            /* Cor do "polegar" do scroll */
            border-radius: 10px;
            border: 2px solid #1f2045;
            /* Espaço entre o "polegar" e o track */
        }

        .info-panel::-webkit-scrollbar-thumb:hover {
            background-color: #5a5cc2;
            /* Cor ao passar o mouse */
        }

        .header-panel {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
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
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            margin-right: 20px;
            border: 2px solid white;
        }

        .collaborator-info {
            flex-grow: 1;
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
            background-image: url("/images/ranking/system/primeiro_lugar.png");
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
            background-image: url("/images/ranking/system/segundo_lugar.png");
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
            background-image: url("/images/ranking/system/terceiro_lugar.png");
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
    </style>



    <style>
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

    <div class="menu-bar">
        <div class="logo">
            <a href="{{url('')}}/crm"> <img style="width:200px"
                    src="{{url('')}}/images/empresa/logos/empresa_logo_horizontal.png" />
            </a>
            <div class="title">Ranking de vendas</div>
        </div>
        <div class="actions">


            {{-- <button class="support">Suporte</button>
            <button class="manage manage-collaborators">Gerenciar Colaborador</button> --}}
            <button class="settings"><i class="fas fa-cog"></i></button>
            <button class="settings"><i class="fas fa-sync-alt"></i></button>
        </div>
    </div>

    <div class="container2">
        <!-- Ranking Board Section -->
        <div class="ranking">
            <div class="ranking-header">
                <div class="ranking-info">
                    <i class="fas fa-arrow-left"></i>
                    <span>Rankings</span>

                </div>
                <div class="ranking-totals">

                    <span style="color:gray">Total em Vendas: </span> <span class="total-time">R$268.979,00</span>
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
                        <div id="nome2">Marcelo</div>
                        <div id="valor2">R$53.920,00</div>
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
                        <div id="nome1">Marcelo</div>
                        <div id="valor1">R$53.920,00</div>
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
                        <div id="nome3">Marcelo</div>
                        <div id="valor3">R$53.920,00</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Panel Section -->
        <div class="info-panel">
            <div class="header-panel">
                <select name="update-interval" id="update-interval">
                    <option value="15">15s</option>
                    <option value="30">30s</option>
                    <option value="60">1m</option>
                    <option value="180">3m</option>
                    <option value="300">5m</option>
                    <option value="600">10m</option>
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
                </div>

                <?php endforeach; ?>
            </div>


        </div>

    </div>

    <div class="footer-panel">
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
    </div>

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


            </div>
            <div id="premiacao" class="content-section hidden">
                <h4>Premiações</h4>
                <p>Defina as premiação de cada posição.</p>

                <div class="premiacao-item">
                    <div class="premiacao-icon">

                        <img src="{{asset('images/ranking/system/icon-primeiro.png')}}" alt="Gold Trophy">
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
                        <img src="{{asset('images/ranking/system/icon-segundo.png')}}" alt="Silver Trophy">
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
                        <img src="{{asset('images/ranking/system/icon-terceiro.png')}}" alt="Bronze Trophy">
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
            </div>
            <div id="sons" class="content-section hidden">
                <h4>Sons</h4>
                <p>Configurações de sons.</p>
            </div>
            <div id="aparencia" class="content-section hidden">
                <h4>Aparência</h4>
                <p>Configurações de aparência.</p>
            </div>
        </div>
    </div>


    @include('templates.escolher_img', [
    'action' => route('ranking_premiacoes'),
    'titulo' => "Editar Arte da Premiação"
    ])


    <!-- jQuery and Bootstrap Bundle (includes Popper) -->

    <script>
        $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

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
            $.ajax({
                url: '/ranking/colaboradores/atualizar',
                method: 'GET',
                success: function(data) {
                    let colaboradores = data.colaboradores;
                    
                    let html = '';
                    colaboradores.forEach(function(colaborador, index) {
                        html += `
                        <div class="collaborator-card">
                            <div class="position">${index + 1}</div>
                            <div class="photo" style="background-image: url('${colaborador.avatar}');"></div>
                            <div class="collaborator-info">
                                <div class="name">${colaborador.name}</div>
                                <div class="meta">Meta: R$ ${colaborador.meta.toLocaleString()} | Total: R$ ${colaborador.total.toLocaleString()}</div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: ${colaborador.percentual}%;"></div>
                                </div>
                                <div class="missing-value">Faltam: R$ ${(colaborador.meta - colaborador.total).toLocaleString()}</div>
                            </div>
                            <div class="percentage">${Math.round(colaborador.percentual) }%</div>
                        </div>`;
                    });
    
                    $('.body-panel').html(html);

                    for (let index = 0; index < 3; index++) {
                    
                        var valorFormatado = new Intl.NumberFormat('pt-BR', {
                            style: 'currency',
                            currency: 'BRL'
                        }).format(colaboradores[index].total);

                        $('#nome'+(index+1)).html(colaboradores[index].name);
                        $('#valor'+(index+1)).html(valorFormatado);

                        $('#collaborator-photo-'+(index+1)).css('background-image', 'url('+colaboradores[index].avatar+')');

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

        atualizarColaboradores();

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

            

            console.log( JSON.stringify(data));
            
        
            document.getElementById('venda_valor').innerText = "Crédito: " +nFormatter( data.data.credito, 2);
            document.getElementById('nome_cliente').innerText = "Cliente: "+data.data.cliente;
            document.getElementById('nome_vendedor').innerText = data.data.vendedor;
            document.getElementById('nome_equipe').innerText = data.data.equipe_nome ? "Equipe: "+data.data.equipe_nome : '';
           
            //document.getElementById('imagem_vendedor').src = "{{ url('') }}/images/users/user_"+data.data.id+"/"+data.data.avatar ;
            document.getElementById('imagem_vendedor').src = data.data.avatar ;


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
    </script>
</body>

</html>