<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CrmController;
use App\Http\Controllers\NegocioController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\PageController;
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

Route::get('/', [AdminController::class, 'index'])->name('landingpage');

Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::post('/login', [AdminController::class, 'login']);

Route::get('/cadastro', [PageController::class, 'cadastro']);
Route::post('/cadastrar', [PageController::class, 'cadastrar'])->name('cadastrar');


Route::group(['middleware' => 'auth'], function () {
    Route::get('/crm', [DashboardController::class, 'dashboard'])->name('home');
    Route::get('/logout', [AdminController::class, 'logout']);

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
            Route::post('/add', [AgendamentoController::class, 'add'])->name('agendamento.add');         

        }
    );


    Route::group(
        ['prefix' => 'vendas'],
        function () {
            Route::post('/nova', [VendaController::class, 'nova_venda'])->name('nova_venda');
            Route::get('/index', [VendaController::class, 'index'])->name('vendas.lista');
            Route::post('/perdida', [VendaController::class, 'venda_perdida'])->name('vendas.perdida');

        }
    );

    Route::group(
        ['prefix' => 'negocios'],
        function () {
            #Route::get('/pipeline', [CrmController::class, 'pipeline']);
            Route::post('/drag_update', [CrmController::class, 'drag_update']);
            Route::post('/add', [CrmController::class, 'add_negocio']);
            Route::get('/get', [NegocioController::class, 'negocio_get'])->name('negocio_get');

            Route::post('/comentario', [CrmController::class, 'inserir_comentario'])->name('inserir_comentario');
            Route::post('/changemassive', [CrmController::class, 'massive_change'])->name('massive_change');

            Route::get('/pipeline', [CrmController::class, 'pipeline_index'])->name('pipeline_index');
           
            Route::get('/list', [CrmController::class, 'list_index'])->name('list_index');

            Route::get('/edit', [NegocioController::class, 'negocio_edit'])->name('negocio_edit');
            Route::post('/importar/atribuir', [NegocioController::class, 'import_atribuir']);
            Route::post('/negocio_update', [NegocioController::class, 'negocio_update'])->name('negocio_update');
 
            Route::get('/importar', [NegocioController::class, 'importar_index'])->name('importar.negocios.index');
            Route::post('/importar', [NegocioController::class, 'importar_upload'])->name('importar.negocios.upload');
            Route::post('/importar/salvar', [NegocioController::class, 'importar_store'])->name('importar.negocios.store');

            Route::get('/simulacao', [NegocioController::class, 'simulacao'])->name('negocios.simulacao');
            Route::post('/criar_proposta', [NegocioController::class, 'criar_proposta'])->name('negocios.criar_proposta');

            Route::post('/add_reuniao', [NegocioController::class, 'add_reuniao']);
            Route::post('/add_aprovacao', [NegocioController::class, 'add_aprovacao']);
            Route::get('/get_agendamento', [NegocioController::class, 'get_agendamento']);

            
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
});


Route::group(['middleware' => ['auth', 'role:gerenciar_funcionarios']], function () {
    Route::group(
        ['prefix' => 'funcionarios'],
        function () {
            Route::get('/lista', [FuncionarioController::class, 'index'])->name('users.funcionarios');
            Route::post('/add', [FuncionarioController::class, 'store'])->name('funcionarios.store');
        }

    );
});


Route::group(['middleware' => ['auth', 'role:gerenciar_equipe']], function () {
    Route::group(
        ['prefix' => 'equipes'],
        function () {
            Route::get('/index', [EquipeController::class, 'index'])->name('equipes.index');
            Route::post('/drag_update', [EquipeController::class, 'drag_update']);
            Route::post('/excluir', [EquipeController::class, 'excluir']);           
            Route::post('/create', [EquipeController::class, 'create']);           

        }
    );
});

