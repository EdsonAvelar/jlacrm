@extends('template_landingpages')

@section('headers')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <meta property="og:title" content="{{ config('nome') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="{{ url('') }}/feane/images/hero-bg.jpg" />
    <meta property="og:url" content="{{ url('') }}" />

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
            width: -webkit-fill-available;
        }
    </style>
@endsection

@section('main_content')
    <div id="booking" class="section">
        <div class="section-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-7 col-md-push-5">
                        <span>
                            <img class="logo-img"
                                src="{{ url('') }}/images/empresa/logos/empresa_logo_transparente.png" />
                        </span>
                        <div class="booking-cta center">

                            @if (app('request')->headline == '')
                                <h1>Cadastre-se Agora mesmo!</h1>
                            @else
                                <h1>{{ app('request')->headline }}</h1>
                            @endif

                            @if (app('request')->subheadline == '')
                                <p>e Conheça a forma de compra que mais cresce no brasil
                                </p>
                            @else
                                <p>{{ app('request')->subheadline }}
                                </p>
                            @endif
                        </div>

                        <div>
                            @if (app('request')->banner != 'false')
                                <span>
                                    <img class="banner-img" src="{{ url('') }}/feane/images/about-img.png" />
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4 col-md-pull-7">
                        <div class="booking-form">
                            <form method="POST" action="{{ route('cadastrar') }}">
                                @csrf
                                <div class="form-group">
                                    <span class="form-label">*Qual o seu nome?</span>
                                    <input class="form-control" type="text" placeholder="Como quer que chamemos você"
                                        name="nome" required>
                                </div>
                                <div class="form-group">
                                    <span class="form-label">*Qual o seu melhor telefone? </span>
                                    <input class="form-control" type="text" placeholder="(xx) xxxx-xxxx" name="telefone"
                                        required>
                                </div>
                                <div class="form-group">
                                    <span class="form-label">*Você vai usar o valor para comprar?</span>
                                    <select class="form-control" id="tipo_credito" name="tipo_credito" required>
                                        <option selected>Selecione</option>
                                        <?php
                                        use App\Enums\NegocioTipo;
                                        
                                        $tipos = NegocioTipo::all();
                                        foreach ($tipos as $tipo) {
                                            echo "<option>$tipo</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <span class="form-label">Qual o valor do bem que você busca?</span>
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

                                <input name="funil_id" value="{{ \App\Models\Funil::where('nome', 'VENDAS')->first()->id }}"
                                    hidden>
                                <input name="etapa_funil_id"
                                    value="{{ \App\Models\EtapaFunil::where('nome', 'OPORTUNIDADE')->first()->id }}" hidden>
                                <input name="campanha" value="{{ app('request')->campanha }}" hidden>
                                <input name="fonte" value="{{ app('request')->fonte }}" hidden>
                                <input name="proprietario" value="{{ app('request')->proprietario }}" hidden>

                                <div class="form-btn">
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
