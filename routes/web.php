<?php

use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\SimulacaoController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarChartRacingController;
use App\Http\Controllers\CrmController;
use App\Http\Controllers\NegocioController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\FechamentoController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductionController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/index2', function () {
    return view('index2');
})->name('leaderboard');

Route::get('/', [AdminController::class, 'index'])->name('landingpage');


Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::post('/login', [AdminController::class, 'login']);

Route::get('/landingpages', [PageController::class, 'landingpages'])->name('landingpages');
Route::post('/cadastrar', [PageController::class, 'cadastrar'])->name('cadastrar');
Route::get('/obrigado', [PageController::class, 'obrigado'])->name('obrigado');

Route::get('/consultor/{slug}', [AdminController::class, 'consultor'])->name('consultor');

Route::group(
    ['prefix' => 'simulacao'],
    function () {
        Route::get('/', [SimulacaoController::class, 'simulacao'])->name('simulacao.index');
        Route::get('/calculadora', [SimulacaoController::class, 'calculadora'])->name('simulacao.calculadora');
        Route::post('/criar_proposta', [SimulacaoController::class, 'criar_proposta'])->name('simulacao.criar_proposta');
        Route::get('/proposta', [SimulacaoController::class, 'ver_proposta'])->name('simulacao.ver_proposta');
    }
);

Route::group(['middleware' => 'auth'], function () {

    Route::group(
        ['prefix' => 'productions'],
        function () {
            Route::get('/index', [ProductionController::class, 'index'])->name('productions.index');

            Route::post('/save-rules', [ProductionController::class, 'saveRules'])->name('productions.saveRules');
            Route::delete('/rules/{id}', [ProductionController::class, 'deleteRule'])->name('rules.delete');


            Route::get('/edit', [ProductionController::class, 'index'])->name('productions.edit');
            Route::delete('/delete/{id}', [ProductionController::class, 'destroy'])->name('productions.destroy');
            Route::post('/store', [ProductionController::class, 'store'])->name('productions.store');

        }
    );




    Route::get('/corrida/vendas', [BarChartRacingController::class, 'vendas'])->name('dashboard_bar_race_vendas');
    Route::get('/corrida/vendas/get', [BarChartRacingController::class, 'vendas_get']);


    Route::get('/corrida/agendamentos', [BarChartRacingController::class, 'agendamentos'])->name('dashboard_bar_race_agendamentos');
    Route::get('/corrida/agendamentos/get', [BarChartRacingController::class, 'agendamentos_get']);

    Route::get('/crm', [DashboardController::class, 'dashboard'])->name('home');
    Route::get('/equipes', [DashboardController::class, 'dashboard_equipes'])->name('dashboard_equipes');
    Route::get('/semanas', [DashboardController::class, 'dashboard_semanas'])->name('dashboard_semanas');
    Route::get('/producao', [DashboardController::class, 'dashboard_producao'])->name('dashboard_producao');

    Route::get('/logout', [AdminController::class, 'logout']);

    Route::get('/change-password', [AdminController::class, 'changePassword'])->name('change-password');
    Route::post('/change-password', [AdminController::class, 'updatePassword'])->name('update-password');


    Route::group(
        ['prefix' => 'leads'],
        function () {
            Route::get('/add-lead', [CrmController::class, 'add_lead']);
            Route::post('/add-lead', [CrmController::class, 'add_lead']);
        }
    );

    Route::group(
        ['prefix' => 'agendamento'],
        function () {
            Route::get('/index', [AgendamentoController::class, 'index'])->name('agendamento.index');
            Route::get('/calendario', [AgendamentoController::class, 'calendario'])->name('agendamento.calendario');
            Route::post('/add', [AgendamentoController::class, 'add'])->name('agendamento.add');
            Route::get('/lista', [AgendamentoController::class, 'lista'])->name('agendamento.lista');

        }
    );


    Route::group(
        ['prefix' => 'vendas'],
        function () {
            Route::post('/nova', [FechamentoController::class, 'nova_venda'])->name('nova_venda');
            Route::post('/fechamento', [FechamentoController::class, 'nova_venda'])->name('vendas.fechamento');

            Route::post('/delete', [FechamentoController::class, 'delete_fechamento'])->name('delete_fechamento');

            Route::post('/notificacao', [FechamentoController::class, 'notificacao'])->name('vendas.notificacao');
            Route::get('/index', [FechamentoController::class, 'index'])->name('vendas.lista');

            Route::post('/perdida', [FechamentoController::class, 'venda_perdida'])->name('vendas.perdida');

        }
    );



    Route::group(
        ['prefix' => 'negocios'],
        function () {
            Route::post('/drag_update', [CrmController::class, 'drag_update']);
            Route::post('/add', [CrmController::class, 'add_negocio']);
            Route::post('/massive/add', [CrmController::class, 'add_negocio_massiva']);


            Route::post('/comentario', [CrmController::class, 'inserir_comentario'])->name('inserir_comentario');
            Route::post('/changemassive', [CrmController::class, 'massive_change'])->name('massive_change');
            Route::post('/reativar', [CrmController::class, 'reativar'])->name('reativar');
            Route::get('/atribuir/one', [CrmController::class, 'atribui_one'])->name('atribui_one');
            Route::get('/pipeline', [CrmController::class, 'pipeline_index'])->name('pipeline_index');
            Route::get('/pipeline/list', [CrmController::class, 'pipeline_list'])->name('pipeline_list');

            Route::get('/list', [CrmController::class, 'list_index'])->name('list_index');
            Route::get('/get', [NegocioController::class, 'negocio_get'])->name('negocio_get');

            Route::get('/edit', [NegocioController::class, 'negocio_edit'])->name('negocio_edit');
            Route::post('/levantamento', [NegocioController::class, 'negocio_levantamento'])->name('negocio_levantamento');

            Route::get('/fechamento', [NegocioController::class, 'negocio_fechamento'])->name('negocio_fechamento');

            Route::post('/importar/atribuir', [NegocioController::class, 'import_atribuir']);
            Route::post('/importar/massivo', [NegocioController::class, 'import_massivo']);
            Route::post('/negocio_update', [NegocioController::class, 'negocio_update'])->name('negocio_update');
            Route::get('/importar', [NegocioController::class, 'importar_index'])->name('importar.negocios.index');
            Route::post('/importar', [NegocioController::class, 'importar_upload'])->name('importar.negocios.upload');
            Route::post('/importar/salvar', [NegocioController::class, 'importar_store'])->name('importar.negocios.store');

            Route::get('/simulacao', [NegocioController::class, 'simulacao'])->name('negocios.simulacao');

            Route::post('/criar_proposta', [NegocioController::class, 'criar_proposta'])->name('negocios.criar_proposta');
            Route::get('/proposta/{id}', [NegocioController::class, 'view_proposta'])->name('negocios.view_proposta');
            Route::post('/add_reuniao', [NegocioController::class, 'add_reuniao']);
            Route::post('/add_aprovacao', [NegocioController::class, 'add_aprovacao']);
            Route::get('/get_agendamento', [NegocioController::class, 'get_agendamento']);

            Route::get('/aprovacoes', [NegocioController::class, 'aprovacoes'])->name('negocios.aprovacoes');
            Route::post('/aprovacoes/update', [NegocioController::class, 'aprovacoes_update']);
        }
    );



    Route::group(
        ['prefix' => 'ranking'],
        function () {
            Route::get('/vendas/ajuda', [RankingController::class, 'vendas_ajuda'])->name('ranking.vendas.ajuda');
            Route::get('/vendas/telemarketing', [RankingController::class, 'telemarketing_vendas'])->name('ranking.vendas.telemarketing');
            Route::get('/colaboradores/vendas/telemarketing', [RankingController::class, 'colaboradores_vendas_telemarketing'])->name('ranking.colaboradores.vendas.telemarketing');

            Route::get('/vendas', [RankingController::class, 'vendas'])->name('ranking.vendas');

            Route::get('/vendas/equipes', [RankingController::class, 'ranking_vendas_equipe'])->name('ranking.vendas.equipe');
            Route::get('/equipes/vendas', [RankingController::class, 'equipes_vendas'])->name('ranking.equipes.vendas');

            Route::get('/agendamentos', [RankingController::class, 'agendamentos'])->name('ranking.agendamentos');
            Route::get('/colaboradores/vendas/ajuda', [RankingController::class, 'colaboradores_vendas_ajuda'])->name('ranking.colaboradores.vendas.ajuda');
            Route::get('/colaboradores/vendas', [RankingController::class, 'colaboradores_vendas'])->name('ranking.colaboradores.vendas');


            Route::get('/colaboradores/agendamentos', [RankingController::class, 'colaboradores_agendamentos'])->name('ranking.colaboradores.agendamentos');
            Route::post('/image/save', [RankingController::class, 'ranking_premiacoes'])->name('ranking_premiacoes');



            //Filiais
            Route::get('/filiais/vendas/equipes/get', [RankingController::class, 'filiais_vendas_equipe']);
            Route::get('/filiais/vendas/equipes/', [RankingController::class, 'filiais_vendas_equipe_index'])->name('ranking.filiais.vendas.equipe.index');

        }
    );


    Route::group(
        ['prefix' => 'users'],
        function () {
            Route::get('/profile', [AdminController::class, 'profile'])->name('users_profile');

            Route::post('/edit/avatar', [AdminController::class, 'avatar_edit']);
            Route::post('/add/permissao', [AdminController::class, 'add_permissao'])->name('add_permissao');
            Route::post('/del/permissao', [AdminController::class, 'del_permissao'])->name('del_permissao');
        }
    );

    Route::group(
        ['prefix' => 'empresa'],
        function () {
            Route::get('/profile', [EmpresaController::class, 'empresa_profile'])->name('empresa_profile');
            Route::post('/save', [EmpresaController::class, 'save'])->name('empresa_save');
            Route::post('/config', [EmpresaController::class, 'empresa_config'])->name('empresa_config');
            Route::post('/image/save', [EmpresaController::class, 'empresa_images'])->name('empresa_images');

        }
    );
});


Route::group(['middleware' => ['auth', 'role:gerenciar_bordero']], function () {
    Route::group(
        ['prefix' => 'bordero'],
        function () {
            Route::get('/', [ProductionController::class, 'bordero'])->name('productions.bordero');
            Route::post('/update-porcentagem', [ProductionController::class, 'updatePercentagem'])->name('productions.bordero.update');

        }
    );
});



Route::group(['middleware' => ['auth', 'role:gerenciar_funcionarios']], function () {
    Route::group(
        ['prefix' => 'funcionarios'],
        function () {
            Route::get('/lista', [FuncionarioController::class, 'index'])->name('users.funcionarios');
            Route::post('/edit', [FuncionarioController::class, 'user_edit'])->name('user_edit');
            Route::post('/add', [FuncionarioController::class, 'store'])->name('funcionarios.store');
            Route::post('/ativar_desativar', [FuncionarioController::class, 'ativar_desativar'])->name('funcionarios.ativar_desativar');

        }
    );
});

Route::group(['middleware' => ['auth', 'role:gerenciar_equipe']], function () {
    Route::group(
        ['prefix' => 'equipes'],
        function () {
            Route::get('/index', [EquipeController::class, 'index'])->name('equipes.index');
            Route::get('/organograma', [EquipeController::class, 'organograma'])->name('equipes.organograma');

            Route::post('/drag_update', [EquipeController::class, 'drag_update']);
            Route::post('/excluir', [EquipeController::class, 'excluir']);
            Route::post('/create', [EquipeController::class, 'create']);
            Route::post('/change_equipe', [EquipeController::class, 'change_equipe'])->name('change_equipe');
            Route::post('/change/image', [EquipeController::class, 'change_image'])->name('equipe.change.image');


            Route::get('/get', [EquipeController::class, 'equipe_get'])->name('equipe_get');

        }
    );
});

Route::get('/pusher', function () {
    return view('pusher');
});

Route::get('/pull', function () {
    return view('pull');
});


