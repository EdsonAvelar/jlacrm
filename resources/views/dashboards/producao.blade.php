@extends('main')


@section('headers')
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Include Date Range Picker -->

<link href="{{ url('') }}/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
@endsection

@section('main_content')
<!-- Start Content-->
<div class="container-fluid" id="dashboard">
    @include('layouts.alert-msg')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <form class="d-flex">
                        <div class="input-group">
                            {{-- <input class="form-control btn btn-primary" type="text" name="daterange"
                                id="datapicker_dash"
                                value="{{ app('request')->input('data_inicio') }} - {{ app('request')->input('data_fim') }}" />
                            --}}

                            <div class="dropdown">
                                <li class="dropdown notification-list d-none d-sm-inline-block">
                                    <button type="button" class="btn btn-light dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Individual
                                    </button>

                                 
                                    <div class="dropdown-menu dropdown-menu-end">
                                        @foreach (\Auth::user()->vendedores() as $user)
                                        <a class="dropdown-item" target="_self"
                                            href="{{ route('dashboard_producao', ['user_id' => $user->id]) }}">{{
                                            $user->name }}</a>
                                        @endforeach

                                    </div>



                                </li>

                            </div>


                        </div>
                    </form>
                </div>

                <h4 class="page-title">Dashboard - Produções</h4>
            </div>
        </div>

    </div>

    <!-- end page title -->
    <div class="row">

        @include('dashboards.views.bar_plot', [
        'title' => array_sum($output['oportunidades'])." Oportunidades",
        'name' => 'Oportunidades',
        'plots' => [$output['producao'], $output['oportunidades']],
        ])


        @include('dashboards.views.bar_plot', [
        'title' => array_sum($output['agendamentos'])." Agendamentos",
        'name' => 'Agendamentos',
        'plots' => [$output['producao'], $output['agendamentos']],
        ])

        @include('dashboards.views.bar_plot', [
        'title' => array_sum($output['reunioes'])." Reuniões",
        'name' => 'Reuniões',
        'plots' => [$output['producao'], $output['reunioes']],
        ])

        @include('dashboards.views.bar_plot', [
        'title' => array_sum($output['propostas'])." Propostas",
        'name' => 'Propostas',
        'plots' => [$output['producao'], $output['propostas']],
        ])

        @include('dashboards.views.bar_plot', [
        'title' => array_sum($output['aprovacoes'])." Aprovações",
        'name' => 'Aprovações',
        'plots' => [$output['producao'], $output['aprovacoes']],
        ])

        @include('dashboards.views.bar_plot', [
        'title' => "Vendas ("."R$ " . number_format(array_sum($output['vendas']), 2, ',', '.').")",
        'name' => 'Vendas',
        'plots' => [$output['producao'], $output['vendas']],
        ])


    </div>

</div> <!-- container -->
@endsection

@section('specific_scripts')
<script>

</script>
@endsection