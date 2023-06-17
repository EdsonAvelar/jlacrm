@extends('template_landingpages')

@section('headers')

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
  integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <meta property="og:title" content="{{config('nome')}}" />
  <meta property="og:type" content="website" />
  <meta property="og:image" content="{{url('')}}/feane/images/hero-bg.jpg" />
  <meta property="og:url" content="{{url('')}}" />

  <style>
    h2 {
      color: white; 
      text-align: center;
      font-size: xx-large;
    }  
    .logo-img {
      margin: 0px;
      padding: 10px;
   
      align: center;
      display: block;
      margin-left: auto;
      margin-right: auto;
      width: 50%;
    }

    .banner-img {
      
      width: 20%;
      width:-webkit-fill-available;
    }

</style>

@endsection

@section('main_content')

<div id="booking" class="section">
  <div class="section-center">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-md-push-5">
          <div class="booking-cta center">
        
          <h1>Saia do Aluguel</h1>
            <p>Cadastre-se para um consultor falar com você</p>
            </div>
        </div>

        <div class="col-md-12 col-md-pull-7">
          <div class="booking-form">
            <form method="POST" action="{{route('cadastrar')}}">
              @csrf
              <div class="form-group">
                <span class="form-label">*Qual o seu nome?</span>
                <input class="form-control" type="text" placeholder="Como quer que chamemos você" name="nome" required>
              </div>
              <div class="form-group">
                <span class="form-label">*Qual o telefone para contato? </span>
                <input class="form-control" type="text" placeholder="(xx) xxxx-xxxx" name="telefone" required>
              </div>
              <input text="text" name="tipo_credito" value="IMOVEL" hidden>
              <div class="form-group">
                <span class="form-label">Qual o valor do Imóvel que você procura?</span>
                <select class="form-control" id="tipo_credito" name="valor_credito" required>

                  <option selected>Selecione um</option>
                  <option>até 100 mil</option>
                  <option>100 a 200 mil</option>
                  <option>200 a 500 mil</option>
                  <option>500 a 1 milhão</option>
                  <option>Acima de 1 milhão</option>
                </select>
              </div>

              <div class="form-group">
                <span class="form-label">Quanto poderia dar de entrada?</span>
                <select class="form-control" id="tipo_credito" name="entrada" required>

                  <option selected>Selecione um</option>
                  <option>5 a 10 mil</option>
                  <option>10 a 20 mil</option>
                  <option>20 a 50 mil</option>
                  <option>50 a 100 mil</option>
                  <option>100 mil em diante</option>
                </select>
              </div>

              <input name="funil_id" value="{{\App\Models\Funil::where('nome','VENDAS')->first()->id}}" hidden>
              <input name="etapa_funil_id" value="{{\App\Models\EtapaFunil::where('nome','OPORTUNIDADE')->first()->id}}" hidden>
              <input name="campanha" value="{{app('request')->campanha}}" hidden>
              <input name="fonte" value="{{app('request')->fonte}}" hidden>
              <input name="proprietario" value="{{app('request')->proprietario}}" hidden>

              <div class="form-btn text-center">
                <button class="submit-btn">Solicitar Simulação</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('specific_scripts')

@endsection