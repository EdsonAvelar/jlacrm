<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Corrida Vendas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #dbdbdb;
        }

        .controls {
            margin-bottom: 20px;
        }

        .race-track {
            position: relative;
            width: 98%;
            background-color: green;
            /* overflow: hidden; */
            border: 2px solid black;
            margin-left: 10px;
        }

        .lane {
            /* position: absolute; */
            width: 100%;
            height: 120px;
            border-bottom: 2px solid white;
        }

        .horse {
            position: absolute;
            display: flex;
            align-items: center;
        }

        .horse img {
            border: 10px solid white;
            width: 100px;
            height: 100px;
            text-align: center;
            border-radius: 50%;
            margin-right: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .scoreboard {
            /* display: flex; */
            align-items: center;
            background: white;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid black;
            z-index: 999;
        }

        .scoreboard span {
            margin: 0 10px;
            font-size: 20px;
            font-weight: bold;
            z-index: 999;
        }

        .crown {
            border: 0px !important;
            position: absolute;
            width: 50px;
            height: 50px;
            top: -70px;
            left: 30px;
            box-shadow: 0 00px rgba(0, 0, 0, 0.5) !important;
            transform: rotate(17deg);
        }

        .top {
            height: 100px;
            width: 100px;

        }

        header {
            text-align: center;
            font-size: 16px;
            font-weight: 300;
        }

        .finish-line1 {
            position: absolute;
            right: 0;
            width: 50px;
            height: 120px;
            background: linear-gradient(to bottom, black 50%, white 50%);
            background-size: 100px 60px;
        }

        .finish-line2 {
            position: absolute;
            right: 50px;
            width: 50px;
            height: 120px;
            background: linear-gradient(to bottom, white 50%, black 50%);
            background-size: 100px 60px;
        }

        .milestone-line {
            position: absolute;
            width: 5px;
            height: 100%;
            background: black;
        }

        .milestone-label {
            position: absolute;
            background: white;
            padding: 2px 5px;
            font-size: 12px;
            transform: translateX(-50%);
        }



        @media (max-width: 1000px) {

            .h1,
            h1 {
                font-size: 170% !important;
            }

            .scoreboard {
                display: flex;
                align-items: center;
                background: #ffffff;
                padding: 5px;
                /* border-radius: 5px; */
                border: 1px solid black;
                z-index: 999;
            }

            .scoreboard span {
                margin: 0 5px;
                font-size: 10px;
                font-weight: bold;
                z-index: 999;
            }

            .horse img {
                border: 3px solid white;
                width: 50px;
                height: 50px;
                text-align: center;
                border-radius: 50%;
                margin-right: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
                z-index: 999;
            }

            .lane {
                /* position: absolute; */
                width: 100%;
                height: 60px;
                border-bottom: 2px solid white;
            }

            .finish-line1 {
                position: absolute;
                right: 0;
                width: 20px;
                height: 60px;
                background: linear-gradient(to bottom, black 50%, white 50%);
                background-size: 100px 60px;
            }

            .finish-line2 {
                position: absolute;
                right: 20px;
                width: 20px;
                height: 60px;
                background: linear-gradient(to bottom, white 50%, black 50%);
                background-size: 100px 60px;
            }

            .milestone-line {
                position: absolute;
                width: 2px;
                height: 100%;
                background: black;
            }

            .milestone-label {
                position: absolute;
                background: white;
                padding: 2px 5px;
                font-size: 6px;
                transform: translateX(-50%);
            }

            .crown {
                border: 0px !important;
                position: absolute;
                width: 50px;
                height: 50px;
                top: -35px;
                left: 10px;
                box-shadow: 0 00px rgba(0, 0, 0, 0.5) !important;
                transform: rotate(17deg);
            }
        }
    </style>
</head>

<body>

    <div class="row" style="padding: 20px;">
        <div class="col-md-4">
            <a href="{{url('')}}/crm"> <img style="width:200px"
                    src="{{url('')}}/images/empresa/logos/empresa_logo_horizontal.png" />
            </a>
        </div>
        <div class="col-md-8">
            <h1 class="header">
                RANKING VENDAS
            </h1>
            <h7>Inicio: {{config('data_inicio')}} Fim:{{config('data_fim')}}</h7>

        </div>
    </div>

    {{-- <div class="controls">
        <button id="playButton">Play</button>
        <button id="pauseButton">Pause</button>
        <button id="stopButton">Stop</button>
    </div> --}}

    <div class="race-track" id="raceTrack">
        <div class="milestone-line"></div>

    </div>

    <script>
        let interval;
    const stepDuration = 500;

    let maxSales = 4000000; // 4 million in sales
    const vendas_max = "{{ config('racing_vendas_max') }}"

    if (vendas_max){
        maxSales = vendas_max;
    }

    const queryString = window.location.search;
    
    // Criando um objeto URLSearchParams a partir da string de consulta
    const urlParams = new URLSearchParams(queryString);
    



    let participants = [];
    const moveDuration = 10000; // Duration in milliseconds for horse movement
    const crownImageUrl = 'https://centralblogs.com.br/wp-content/uploads/2018/11/coroa-png-fundo-transparente.png';

    async function fetchParticipants() {
        try {
            const response = await fetch("{{ url('corrida/vendas/get') }}"); // Replace with your API endpoint
            const data = await response.json();
            participants = data;

            var div = document.querySelector('.race-track');
            // Altera a altura da div

            const raceTrack = document.getElementById('raceTrack');


            if (raceTrack.clientWidth < 1000){
                div.style.height = 60*participants.length+'px';

            }else {
                div.style.height = 120*participants.length+'px';
            }

            



            updateRace(participants);
        } catch (error) {
            console.error('Error fetching participants:', error);
        }
    }

    function updateRace(participants) {
        // Clear previous race data
        const raceTrack = document.getElementById('raceTrack');
        raceTrack.innerHTML = '<div class="milestone-line"></div>';
        // Sort participants by sales
        //participants.sort((a, b) => b.sales - a.sales);

        // Add milestone lines
        for (let sales = 500000; sales <= maxSales; sales +=500000) { const milestoneLine=document.createElement('div');
            milestoneLine.className='milestone-line' ; milestoneLine.style.left=`${(sales / maxSales) * 100}%`;
            raceTrack.appendChild(milestoneLine); const milestoneLabel=document.createElement('div');
            milestoneLabel.className='milestone-label' ; milestoneLabel.style.left=`${(sales / maxSales) * 100}%`;
            milestoneLabel.textContent=`${sales / 1000000}M`; raceTrack.appendChild(milestoneLabel); }

            
        // Calculate positions based on sales
        const positions = [...participants]
        .sort((a, b) => b.sales - a.sales)
        .map((participant, index) => ({ ...participant, position: index + 1 }));

        participants.forEach((participant, index) => {
           
            const lane = document.createElement('div');
            lane.className = 'lane';
            lane.style.top = `${index * 50}px`;
            raceTrack.appendChild(lane);

            const horse = document.createElement('div');
            horse.className = 'horse';
            horse.style.left = '0px'; // Start position
            horse.style.transition = `left ${moveDuration}ms linear`;
            horse.dataset.sales = participant.sales;
            horse.dataset.initialSales = participant.sales; // Save initial sales value
            lane.appendChild(horse);

            const img = document.createElement('img');
            img.src = participant.image;
            horse.appendChild(img);

            const position = positions.find(p => p.name === participant.name).position;

            const scoreboard = document.createElement('div');
            scoreboard.className = 'scoreboard';
            scoreboard.innerHTML = `<span>${position }º ${participant.name}</span><br><span class="sales-value" data-target-sales="${participant.sales}">0</span>`;
            horse.appendChild(scoreboard);

            const finishLine1 = document.createElement('div');
            finishLine1.className = 'finish-line1';
            lane.appendChild(finishLine1);

            const finishLine2 = document.createElement('div');
            finishLine2.className = 'finish-line2';
            lane.appendChild(finishLine2);
        });

        moveHorses(); // Move horses initially after update
    }

    function moveHorses() {
        const raceTrack = document.getElementById('raceTrack');
        const horses = raceTrack.querySelectorAll('.horse');

        horses.forEach(horse => {
            const sales = parseInt(horse.dataset.sales, 10);
            const targetPosition = (sales / maxSales) * raceTrack.clientWidth;
            horse.style.left = `${targetPosition}px`;
            animateSales(horse);
        });

        setTimeout(() => {
            displayCrown();
        }, moveDuration);
    }

    
    function formatarParaReal(valor) {
    return valor.toLocaleString('pt-BR', {
    style: 'currency',
    currency: 'BRL'
    });
    }


    function animateSales(horse) {
        const salesValueElement = horse.querySelector('.sales-value');
        const targetSales = parseInt(salesValueElement.dataset.targetSales, 10);
        const increment = targetSales / (moveDuration / stepDuration);
        let currentSales = 0;

        const interval = setInterval(() => {
            currentSales += increment;
            if (currentSales >= targetSales) {
                currentSales = targetSales;
                clearInterval(interval);
            }

            const valorFormatado = formatarParaReal(Math.round(currentSales));

            salesValueElement.textContent = valorFormatado;
        }, stepDuration);
    }


    function displayCrown() {
        // Find the horse with the highest sales
        const raceTrack = document.getElementById('raceTrack');
        const horses = raceTrack.querySelectorAll('.horse');
        let maxSales = -1;
        let firstPlaceHorse = null;
        
        horses.forEach(horse => {
        const sales = parseInt(horse.dataset.sales, 10);
        if (sales > maxSales) {
            maxSales = sales;
            firstPlaceHorse = horse;
            }
        });
        
        // Add the crown to the first place horse
        if (firstPlaceHorse) {
            const crown = document.createElement('img');
            crown.src = crownImageUrl;
            crown.className = 'crown';
            firstPlaceHorse.appendChild(crown);
        }
    }




    // function displayCrown() {
    //     // Ensure crown is only on the first place
    //     const raceTrack = document.getElementById('raceTrack');
    //     const firstPlaceHorse = raceTrack.querySelector('.horse');
        
    //     const crown = document.createElement('img');
    //     crown.src = crownImageUrl;
    //     crown.className = 'crown';
    //     firstPlaceHorse.appendChild(crown);
    // }

    function play() {
        if (!interval) {
            interval = setInterval(() => {
                fetchParticipants().then(moveHorses);
            }, stepDuration);
        }
    }

    function pause() {
        clearInterval(interval);
        interval = null;
    }

    function stop() {
        clearInterval(interval);
        interval = null;
        const raceTrack = document.getElementById('raceTrack');
        const horses = raceTrack.querySelectorAll('.horse');
        horses.forEach(horse => {
            horse.style.left = '0px'; // Reset position
            horse.querySelector('.sales-value').textContent = '0 pts'; // Reset sales value
        });
    }

    // document.getElementById('playButton').addEventListener('click', play);
    // document.getElementById('pauseButton').addEventListener('click', pause);
    // document.getElementById('stopButton').addEventListener('click', stop);

    // Initial fetch
    fetchParticipants();
    </script>

</body>

</html>