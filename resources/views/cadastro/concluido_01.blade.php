<!DOCTYPE html>
<html lang="en">

    <head>

    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-T8M2RFC');</script>
<!-- End Google Tag Manager -->

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cadastro Concluído</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">

    </head>

    <body>
      
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T8M2RFC"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
        <div class="d-flex justify-content-center align-items-center">
           
            <div>
                <div class="mb-4 text-center">
                 
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
                    <a href = "https://api.whatsapp.com/send/?phone=55{{$consultor}}&text=Ol%C3%A1,%20fiz%20o%20cadastro%20no%20site,%20gostaria%20de%20Mais%20informa%C3%A7%C3%B5es&type=phone_number&app_absent=0">
                        <img src="{{url('')}}/images/sistema/clique-para-falar-pelo-whatsapp.png" style="width:300px"/>
                    </a>
            
                    @if(app('request')->consultor and App::isLocal())
                        <p>Consultora: {{app('request')->consultor}}</p>
                    @endif
                </div>
            </div>
    </body>
<script>


</script>
   
</html>