<html>

<head>
    <meta charset=utf-8 />
    <title>Simulador de Fresco.</title>
    <style>
        body {
            margin-top: 30px;
        }
    </style>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container center">


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
        </script>
        <h1>Seja Bem Vindo ao Simulador de Fresco 4.0</h1>
        <h5>Clique no Botão Abaixo para Simular um fresco</h5>
        <div>
            <button id="jsstyle" type="button" class="btn btn-danger btn-lg" onclick="display_random_image();">SIMULAR
                FRESCO</button>

        </div>
    </div>
</body>
<script>
    function display_random_image() {
        var theImages = [{
                src: "{{ url('') }}/fresco/1.jfif",
                width: "600",
                height: "800"
            },
            {
                src: "{{ url('') }}/fresco/2.jfif",
                width: "600",
                height: "800"
            },
            {
                src: "{{ url('') }}/fresco/3.jfif",
                width: "600",
                height: "800"
            },
            {
                src: "{{ url('') }}/fresco/4.jfif",
                width: "600",
                height: "800"
            },
            {
                src: "{{ url('') }}/fresco/5.jfif",
                width: "600",
                height: "800"
            }

        ];

        var preBuffer = [];
        for (var i = 0, j = theImages.length; i < j; i++) {
            preBuffer[i] = new Image();
            preBuffer[i].src = theImages[i].src;
            preBuffer[i].width = theImages[i].width;
            preBuffer[i].height = theImages[i].height;
        }

        // create random image number
        function getRandomInt(min, max) {
            //  return Math.floor(Math.random() * (max - min + 1)) + min;

            imn = Math.floor(Math.random() * (max - min + 1)) + min;
            return preBuffer[imn];
        }

        // 0 is first image,   preBuffer.length - 1) is  last image

        var newImage = getRandomInt(0, preBuffer.length - 1);

        // remove the previous images
        var images = document.getElementsByTagName('img');
        var l = images.length;
        for (var p = 0; p < l; p++) {
            images[0].parentNode.removeChild(images[0]);
        }
        // display the image  
        document.body.appendChild(newImage);
    }
</script>

</html>
