<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking System</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .leaderboard {
            max-width: 600px;
            margin: auto;
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
        }

        .leaderboard-item {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid #ccc;
            background-color: #f9f9f9;
        }

        .leaderboard-item:nth-child(odd) {
            background-color: #e9e9e9;
        }

        .leaderboard-item span {
            flex: 1;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <h1 class="text-center">Ranking System</h1>
        <div class="leaderboard mt-4">
            <!-- Ranking items will be appended here -->
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Sample data for the leaderboard
            const rankingData = [
                { name: 'Marcelo', value: 100000 },
                { name: 'William', value: 90000 },
                { name: 'Rubens', value: 80000 },
                { name: 'João', value: 70000 },
                { name: 'Kaike', value: 60000 },
                { name: 'Keila', value: 50000 }
            ];

            function renderLeaderboard(data) {
                const leaderboard = $('.leaderboard');
                leaderboard.empty();

                data.forEach((item, index) => {
                    const leaderboardItem = `
                        <div class="leaderboard-item">
                            <span>${index + 1}</span>
                            <span>${item.name}</span>
                            <span>${item.value}</span>
                        </div>
                    `;
                    leaderboard.append(leaderboardItem);
                });
            }

            renderLeaderboard(rankingData);
        });
    </script>
</body>

</html>