<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Castrao Concluido</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
      

        <div class="d-flex justify-content-center align-items-center">
           
            <div>
                <div class="mb-4 text-center">
                    <img style="width:200px; padding-top: 30px" src="{{url('')}}/images/jlalogo.png" /><br><br><br>

                    <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="75" height="75"
                        fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                    </svg>
                    
                </div>
                <div class="text-center">
                    <h1>Cadatro Concluido</h1>
                    <h5>Fique atento ao telefone, entraremos em contato com você em horário comercial </h5>
                    <br>
                    <p>Ou caso, queira deixar uma mensagem em nosso whatsapp clique no botão abaixo</p>
                    
                  

                      <img onclick="myFunction()" src="{{url('')}}/images/clique-para-falar-pelo-whatsapp.png" style="width:300px"/>

                </div>
            </div>
    </body>
<script>

function myFunction() {

 
    location.href = "https://api.whatsapp.com/send/?phone=55{{$consultor}}&text&type=phone_number&app_absent=0";
}

</script>
   
</html>