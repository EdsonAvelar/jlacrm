<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landing Page</title>
  <!-- Bootstrap CSS -->


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <!-- jQuery UI CSS -->
  <link href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" rel="stylesheet">

  <!-- AOS CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .logo {
      width: 150px;
      margin: 10px;
    }

    .hero {
      background: url('https://via.placeholder.com/1920x1080') no-repeat center center/cover;
      color: white;
      padding: 300px 0;
      text-align: left;
      position: relative;
    }

    .hero h1 {
      font-size: 3rem;
    }

    .hero h2 {
      font-size: 1.5rem;
    }

    .info-section,
    .images-section,
    .carousel-section,
    .contact-section,
    .footer-section {
      padding: 50px 0;
    }

    .info-section img,
    .images-section img {
      max-width: 100%;
    }

    .images-section .card {
      text-align: center;
    }

    .carousel-item img {
      max-width: 100%;
      height: auto;
    }

    .simulation-box {
      background-color: white;
      border-radius: 15px;
      padding: 12px;
      box-shadow: 10px 13px 10px rgb(0 0 0 / 22%);
      position: absolute;
      top: 20%;
      right: 15%;
      max-width: 400px;
      color: black;
      opacity: 90%;
    }

    .btn-group-justified {
      width: 100%;
    }

    .simulation-box h3 {
      color: #ffffff;
      background: black;
      padding: 10px;
      border-radius: 20px 0px;
      text-align: center;
    }

    .simulation-box .btn-primary {
      background-color: #007bff;
      border: none;
    }

    .min {
      float: left;
    }

    .max {
      float: right;
    }

    .value-number {

      font-size: xx-large;
      font-weight: 600;
      color: green;
    }

    .btn-group,
    {

    padding-right: 10px;
    }

    .great {
      font-family: system-ui;
      padding: 0px 100px 0px 0px;
    }

    /* Media Query para dispositivos móveis */
    @media (max-width: 768px) {
      .simulation-box {
        position: relative;
        width: 100%;
        top: 0;
        right: 0;
        max-width: 100%;
        padding: 20px;
        box-sizing: border-box;
      }

      .simulation-box h3 {
        font-size: 1.5rem;
        padding: 15px;
      }

      .simulation-box .btn-group-lg .btn {
        font-size: 1rem;
        padding: 10px;
      }

      .value-number {
        font-size: 1.5rem;
      }

      .min,
      .max {
        font-size: 0.9rem;
      }

      .simulation-box .price-slider h4 {
        font-size: 1.2rem;
      }

      .simulation-box span {
        font-size: 0.9rem;
      }

      .hero {
        padding: 0;
      }
    }
  </style>


</head>

<body>
  <!-- Logo -->
  <div class="text-center logo" data-aos="fade-down">
    <img src="https://via.placeholder.com/150x50" alt="Logo" class="logo">
  </div>

  <!-- Imagem de destaque -->
  <section class="hero d-flex align-items-center" data-aos="fade-in">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h1 data-aos="fade-up" data-aos-delay="200">DESCUBRA COMO REALIZAR SEU SONHO</h1>
          <h2 data-aos="fade-up" data-aos-delay="400">Com preço justo, segurança e confiabilidade</h2>
        </div>
      </div>
      <div class="simulation-box" data-aos="fade-up" data-aos-delay="600">
        <h3>SIMULAÇÃO RÁPIDA</h3>
        <div class="container">
          <div class="price-box">
            <div class="row">
              <div class="col-sm-12">

                <div class="price-slider">
                  <h4 class="great">Tipo</h4>
                  <span>Escola qual Sonho deseja realizar</span>
                  <div class="">
                    <div class="btn-group btn-group-lg">
                      <button type="button"
                        class="btn btn-primary btn-lg btn-block month active-month selected-month active"
                        id='imovel'>Imóvel</button>
                    </div>
                    <div class="btn-group btn-group-lg">
                      <button type="button" class="btn btn-primary btn-lg btn-block month" id='veiculo'>Veículo</button>
                    </div>
                    <div class="btn-group btn-group-lg">
                      <button type="button" class="btn btn-primary btn-lg btn-block month"
                        id='maquinario'>Maquinário</button>
                    </div>
                  </div>
                </div>
                <div class="price-slider">
                  <h4 class="great">Simular</h4>
                  <span>por Crédito ou Parcelas mensais ?</span>
                  <input name="sliderVal" type="hidden" id="sliderVal" value='0' readonly="readonly" />
                  <input name="tipo_credito" type="hidden" id="tipo_credito" value='imovel' readonly="readonly" />
                  <input name="simular_por" type="hidden" id="simular_por" value='credito' readonly="readonly" />

                </div>

                <div class="row">
                  <div class="w-50">
                    <button type="button"
                      class="w-100 btn btn-primary btn-lg btn-block flex-fill term active-term selected-term active"
                      id='credito'>Crédito</button>

                  </div>
                  <div class="w-50">
                    <button type="button" class="w-100 btn btn-primary btn-lg btn-block  flex-fill term"
                      id='parcela'>Parcela</button>
                  </div>

                </div>


                <div class="price-slider">
                  <h4 class="great" id='tipocp'>Crédito</h4>
                  <span>Escolha o valor <span id='valorcp'></span></span>
                  <div class="col-sm-12">
                    <div class="value-number">
                      R$ <span id="amount" class="big"></span>
                    </div>
                  </div>

                  <div class="col-sm-12">
                    <div id="slider_amirol"></div>
                  </div>

                  <div class="col-sm-12">
                    <div class="min-max-label">
                      <div id="credit-min" class="min">R$ 20.000</div>
                      <div id="credit-max" class="max">R$ 5.000.000</div>
                    </div>
                  </div>
                </div>

                <div style="margin-top:30px"></div>


                <div class="form-group">
                  <div class="col-sm-12">
                    <button id="botao_simular" type="submit"
                      class="btn btn-success btn-lg btn-block btn-simular w-100">SIMULAR <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                          class="bi bi-whatsapp" viewBox="0 0 16 16">
                          <path
                            d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                        </svg></span></button>
                  </div>
                  <div class="col-sm-12">
                    <span style="text-align: center;">* Receba a Simulação em seu WhatsApp</span>
                  </div>

                </div>

              </div>


            </div>

          </div>

        </div>

      </div>
    </div>
  </section>

  <!-- Informações sobre empresa -->
  <section class="info-section" data-aos="fade-up" data-aos-delay="200">
    <div class="container">
      <div class="row">
        <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
          <img src="https://via.placeholder.com/500x300" alt="Sobre Nós">
        </div>
        <div class="col-md-6" data-aos="fade-up" data-aos-delay="600">
          <h2>Sobre a Empresa</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam scelerisque aliquam odio, quis venenatis
            purus. Nulla facilisi. Proin aliquet turpis in magna scelerisque, eget cursus arcu commodo. Duis at lacus
            vitae sapien bibendum lacinia.</p>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam scelerisque aliquam odio, quis venenatis
            purus. Nulla facilisi. Proin aliquet turpis in magna scelerisque, eget cursus arcu commodo. Duis at lacus
            vitae sapien bibendum lacinia.</p>
        </div>
      </div>
    </div>
  </section>
  <!-- Imagens -->
  <section class="images-section" data-aos="fade-up" data-aos-delay="300">
    <div class="container">
      <div class="row">
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
          <div class="card">
            <img src="https://via.placeholder.com/200x150" class="card-img-top" alt="Imóvel">
            <div class="card-body">
              <h5 class="card-title">Imóvel</h5>
              <p class="card-text">Descrição do imóvel.</p>
            </div>
          </div>
        </div>
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="500">
          <div class="card">
            <img src="https://via.placeholder.com/200x150" class="card-img-top" alt="Veículo">
            <div class="card-body">
              <h5 class="card-title">Veículo</h5>
              <p class="card-text">Descrição do veículo.</p>
            </div>
          </div>
        </div>
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="600">
          <div class="card">
            <img src="https://via.placeholder.com/200x150" class="card-img-top" alt="Caminhão">
            <div class="card-body">
              <h5 class="card-title">Caminhão</h5>
              <p class="card-text">Descrição do caminhão.</p>
            </div>
          </div>
        </div>
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="700">
          <div class="card">
            <img src="https://via.placeholder.com/200x150" class="card-img-top" alt="Terreno">
            <div class="card-body">
              <h5 class="card-title">Terreno</h5>
              <p class="card-text">Descrição do terreno.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Carrossel -->
  <section class="carousel-section" data-aos="fade-up" data-aos-delay="400">
    <div class="container">
      <h2>Clientes Satisfeitos</h2>
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-target="#carouselExampleIndicators" data-slide-to="0" class="active"
            aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-target="#carouselExampleIndicators" data-slide-to="1"
            aria-label="Slide 2"></button>
          <button type="button" data-target="#carouselExampleIndicators" data-slide-to="2"
            aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active" data-aos="fade-up" data-aos-delay="500">
            <img src="https://via.placeholder.com/800x400" class="d-block w-100" alt="Cliente 1">
          </div>
          <div class="carousel-item" data-aos="fade-up" data-aos-delay="600">
            <img src="https://via.placeholder.com/800x400" class="d-block w-100" alt="Cliente 2">
          </div>
          <div class="carousel-item" data-aos="fade-up" data-aos-delay="700">
            <img src="https://via.placeholder.com/800x400" class="d-block w-100" alt="Cliente 3">
          </div>
        </div>
        <button class="carousel-control-prev" type="button">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
          data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  </section>

  <!-- Contato -->
  <section class="contact-section" data-aos="fade-up" data-aos-delay="500">
    <div class="container">
      <h2>Contato</h2>
      <form>
        <div class="mb-3">
          <label for="name" class="form-label">Nome</label>
          <input type="text" class="form-control" id="name" placeholder="Seu nome">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" placeholder="Seu email">
        </div>
        <div class="mb-3">
          <label for="message" class="form-label">Mensagem</label>
          <textarea class="form-control" id="message" rows="3" placeholder="Sua mensagem"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
      </form>
    </div>
  </section>

  <!-- Footer -->
  <section class="footer-section bg-dark text-white" data-aos="fade-up" data-aos-delay="600">
    <div class="container text-center">
      <p>&copy; 2024 Soluções Financeiras. Todos os direitos reservados.</p>
    </div>
  </section>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- jQuery UI -->
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

  <script type="text/javascript"
    src="//cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

  <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
  <script src="https://jsuites.net/v4/jsuites.js"></script>


  <!-- AOS JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    AOS.init({
          duration: 1000, // Duração da animação em milissegundos
          easing: 'ease', // Efeito de suavização
          once: true, // Anima apenas uma vez ao entrar na tela
        });
  </script>


  <script>
    $(document).ready(function() {
    // Exemplo de uso do jQuery UI
    $("#name").tooltip({
    content: "Digite seu nome completo"
    });
    });
    // JavaScript Document
          
          var_zap = 19989085014
          var url_montada = ""
          
          var obj = {
              'imovel' : {
                  'quarterly' : '1.41',
                  'monthly' : '1.28',
                  'weekly' : '1.2'
              },
              'veiculo' : {
                  'quarterly' : '1.38',
                  'monthly' : '1.25',
                  'weekly' : '1.8'
              },
              'maquinario' : {
          
                  'quarterly' : '1.35',
                  'monthly' : '1.225',
                  'weekly' : '1.15'
              }
          };
          
          $(document).ready(function() {
          
              $("#total").val("10000");
          
              $("#slider_amirol").slider({
                  range: "min",
                  animate: true,
          
                  min: 0,
                  max: 99,
                  step: 1,
                  slide: 
                      function(event, ui) 
                      {
                          update(1,ui.value); //changed
                          calcualtePrice(ui.value);
                      }
              });
          
              $('.month').on('click',function(event) {
                  var id = $(this).attr('id');
          
                  $('.month').removeClass('selected-month');
                  $(this).addClass('selected-month');
                  $(".month").removeClass("active-month");
                  
                  $(".month").removeClass("active");
                  $(this).addClass("active");
                  
                  $(this).addClass("active-month");
          
                  $('#tipo_credito').val(id);
          
                  update();
                  calcualtePrice()
              });
          
              $('.term').on('click',function(event) {
                  var id = $(this).attr('id');
          
                  $('.term').removeClass('selected-term');
                  $(this).addClass('selected-term');
                  $(".term").removeClass("active-term");
                  $(this).addClass("active-term");
          
          
                  $(".term").removeClass("active");
                  $(this).addClass("active");
                  
          
          
                  $('#simular_por').val(id);
          
                  update();
                  calcualtePrice()
                  
              });
          
              update();
              calcualtePrice();
          });
          
          function kFormatter(num) {
              
              
              if (Math.abs(num) > 999999) {
                  return Math.sign(num)*((Math.abs(num)/1000000).toFixed(2)) + 'M'
              }else if (Math.abs(num) > 999) {
              
                  return Math.sign(num)*((Math.abs(num)/1000).toFixed(1)) + 'k'
              }else{
                  return Math.sign(num)*Math.abs(num)
              }
             
          }
          
          function gerarRange(min, max,value=true){
              var amount = {};
              var famount = {}
              var inc = (max - min)/100
          
              for (var i = 0; i < 100; i++) {
                 
          
                      var tmp_amount = (min + (inc*i)).toFixed()
                      amount[i] = tmp_amount
                      famount[i] = kFormatter(tmp_amount)
               
              }
              
              amount[i-1] = max
              famount[i-1] = kFormatter(max)
          
           return {amount,famount}
          }
          
          
          
          function getCredit(tipo_credito, simular_por){
          
              var res = null;
              var min = 0;
              var max = 0;
          
              if (tipo_credito == "imovel" & simular_por == "credito") {
                  min = 30000
                  max = 1000000
                  
              }else if ( tipo_credito == "imovel" & simular_por == "parcela") {
                  min = 100
                  max = 5000
              }else if ( tipo_credito == "veiculo" & simular_por == "credito") {
                  min = 10000
                  max = 200000
          
              }else if ( tipo_credito == "veiculo" & simular_por == "parcela") {
                  min = 100
                  max = 5000
              }else if ( tipo_credito == "maquinario" & simular_por == "credito") {
                  min = 10000
                  max = 1000000
              }else if ( tipo_credito == "maquinario" & simular_por == "parcela") {
                  min = 100
                  max = 10000
              }
          
          
              
          
              res  = gerarRange(min,max);
          
              
          
              p = res['amount']
              t = res['famount']
          
              var min = jSuites.mask.run(min, '#.##0,00');
              var max = jSuites.mask.run(max, '#.##0,00');
              $('#credit-min').html('<div id="credit-min" class="min" data-mask=\'#.##0,00\'>R$ '+min+'</div>') 
              $('#credit-max').html('<div id="credit-min" class="min" data-mask=\'#.##0,00\'>R$ '+max+'</div>') 
          
              //console.log("aki",p,t)
              return {p, t}
          }
          
                 
          function update(slider, val) {
          
              $("#slider_amirol").slider('value',0);
          
              if(undefined === val) val = 0;
          
              var tipo = $('#tipo_credito').val();
              var simular = $('#simular_por').val();
          
              var p = getCredit(tipo,simular)['p']
              
              //console.log(p)
          
              var amount = p[val];
          
              $('#sliderVal').val(amount);
          
              //$('#slider_amirol a').html('<label><span class="glyphicon glyphicon-chevron-left"></span> '+amount+' <span class="glyphicon glyphicon-chevron-right"></span></label>');
          
              var amount = jSuites.mask.run(amount, '#.##0,00');
          
               $('#amount').html(amount) 
             
          }
          
          function calcualtePrice(val){
              
              if(undefined === val)
                  val = $('#sliderVal').val();
          
            
          
              var tipo = $('#tipo_credito').val();
              var simular = $('#simular_por').val();
          
              var t = getCredit(tipo,simular)['t']
          
                if (simular == "parcela"){
                  $('#valorcp').html('<span> da Parcela: </span>')
                  $('#tipocp').html('Parcela')
                  
          
              }else {
                  $('#valorcp').html('<span> do Crédito: </span>')
                  $('#tipocp').html('Crédito')
              }
          }
          
          
          function goToURL() {
              location.href = 'https://api.whatsapp.com/send?phone=5591981271209&text=ok';
          
            }
          
            $('#botao_simular').click(function(){
              // document.location = "https://api.whatsapp.com/send?phone=55"+var_zap+"&text="+url_montada;
             
              var tipo = $('#tipo_credito').val();
              var simular = $('#simular_por').val();
          
              var valor = jSuites.mask.run($('#sliderVal').val(), '#.##0,00');
          
              url_montada = "Gostaria de uma simulação de um "+tipo+" no valor de R$ "+valor+" de "+simular;
          
              var urlfinal = window.location.protocol + "//" +"api.whatsapp.com/send?phone=55"+var_zap+"&text="+url_montada;
              //console.log(urlfinal)
          
              document.location = urlfinal
          
              
            })
          
  </script>
</body>

</html>