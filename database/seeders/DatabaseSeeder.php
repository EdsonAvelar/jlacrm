<?php

namespace Database\Seeders;

use App\Models\MotivoPerda;
use App\Models\Negocio;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Equipe;
use App\Models\Cargo;
use App\Enums\UserStatus;
use Carbon\Carbon;
use App\Models\Empresa;


class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{

		$this->motivo_Perdas();

		#$this->createEquipe();

		$this->createCargoTable();

		$this->roleTable();
		$this->command->info('Criados os papeis (gerente, administrativo, coordenador, vendedor,financeiro)');


		$this->adminTable();

		#Configurações Iniciais
		$this->initConfig();


		#$this->usersTable();
		#$this->command->info('usuario (Gerente,Administrador,Coordenador,Financeiro,Vendedor) criados com sucesso, senha padrão: 123');

		$this->call([
			FunilSeeder::class,
			//LeadSeeder::class,
			//NegocioSeeder::class
		]);

	}

	private function motivo_Perdas()
	{

		$motivos = [
			'Cliente não quer comprar agora',
			'Cliente não gostou da proposta',
			'Cliente não atendeu 3 tentativas'
		];

		foreach ($motivos as $motivo) {
			$perdas = new MotivoPerda();
			$perdas->motivo = $motivo;
			$perdas->save();
		}
	}
	private function createEquipe()
	{

		$equipe = new Equipe();
		$equipe->nome = "EquipeFera1";
		$equipe->descricao = "Equipe Fera 1";
		$equipe->logo = 'user-padrao.png';
		$equipe->save();

		$equipe = new Equipe();
		$equipe->nome = "EquipeFera2";
		$equipe->descricao = "Equipe Fera 2";
		$equipe->logo = 'user-padrao.png';
		$equipe->save();
	}


	private function createCargoTable()
	{
		$cargo = new Cargo();
		$cargo->nome = "Gerente Geral";
		$cargo->setor = "Todos";
		$cargo->save();

		$cargo = new Cargo();
		$cargo->nome = "Vendedor";
		$cargo->setor = "Comercial";
		$cargo->save();

		$cargo = new Cargo();
		$cargo->nome = "Coordenador";
		$cargo->setor = "Comercial";
		$cargo->save();

		$cargo = new Cargo();
		$cargo->nome = "Gerente Administrativo";
		$cargo->setor = "Administrativo";
		$cargo->save();


		$cargo = new Cargo();
		$cargo->nome = "Assistente Adminstrativo";
		$cargo->setor = "Adiminstrativo";
		$cargo->save();


		$cargo = new Cargo();
		$cargo->nome = "Pós Venda";
		$cargo->setor = "Adiminstrativo";
		$cargo->save();

	}


	private function roleTable()
	{

		$role_employee = new Role();
		$role_employee->name = 'admin';
		$role_employee->save();

		$role_manager = new Role();
		$role_manager->name = 'gerenciar_equipe';
		$role_manager->save();

		$role_employee = new Role();
		$role_employee->name = 'gerenciar_funcionarios';
		$role_employee->save();

		$role_employee = new Role();
		$role_employee->name = 'importar_leads';
		$role_employee->save();

		$role_employee = new Role();
		$role_employee->name = 'gerenciar_vendas';
		$role_employee->save();

	}

	private function save_config($config_name, $config_value)
	{
		$empresa = Empresa::where('settings', $config_name)->first();

		// Make sure you've got the Page model
		if ($empresa) {
			$empresa->value = $config_value;
			$empresa->save();
		} else {
			$empresa = new Empresa();
			$empresa->settings = $config_name;
			$empresa->value = $config_value;
			$empresa->save();
		}

		$this->command->info('Atualizando configuração: (' . $config_name . ',' . $config_value . ')');
	}

	private function initConfig()
	{

		$dia = intval(Carbon::now('America/Sao_Paulo')->subMonth(1)->format('d'));
		if ($dia <= 20) {
			$data_inicio = "20/" . (Carbon::now('America/Sao_Paulo')->subMonth(1)->format('m/Y'));
		} else {
			$data_inicio = "20/" . (Carbon::now('America/Sao_Paulo')->format('m/Y'));
		}

		$data_fim = Carbon::now('America/Sao_Paulo')->format('d/m/Y');

		$this->save_config('data_inicio', $data_inicio);
		$this->save_config('data_fim', $data_fim);


		$url = preg_replace("(^https?://)", "", url(''));

		$this->save_config('broadcast_canal', $url);


		$this->save_config('racing_agendamento_max', 10);
		$this->save_config('racing_vendas_max', 1500000);
		$this->save_config('racing_vendas_equipe', 3000000);


	}


	private function adminTable()
	{
		$role_gerente = Role::where('name', 'admin')->first();
		$gerenciar_funcionarios = Role::where('name', 'gerenciar_funcionarios')->first();
		$importar_leads = Role::where('name', 'importar_leads')->first();
		$gerenciar_equipe = Role::where('name', 'gerenciar_equipe')->first();
		$gerenciar_vendas = Role::where('name', 'gerenciar_vendas')->first();

		$cargo_gerente = Cargo::where('nome', 'Gerente Geral')->first();

		$role_gerente = Role::where('name', 'admin')->first();
		$user = new User();
		$user->name = 'Gerente';

		$url = preg_replace("(^https?://)", "", url(''));

		$user->email = 'gerente@com.br';
		$user->avatar = 'images/sistema/user-padrao.png';

		$this->command->info('Avatar Padrão: ' . $user->avatar);


		$user->status = UserStatus::ativo;

		$senha_padrao = '#admin123';
		$user->password = Hash::make($senha_padrao);
		$user->cargo_id = $cargo_gerente->id;
		$user->save();
		$user->roles()->attach($role_gerente);
		$user->roles()->attach($gerenciar_funcionarios);
		$user->roles()->attach($importar_leads);
		$user->roles()->attach($gerenciar_equipe);
		$user->roles()->attach($gerenciar_vendas);


		$this->command->info('Usuario Gerente criado com email: ' . $user->email . ' e senha: ' . $senha_padrao);
	}

	private function usersTable()
	{
		$role_gerente = Role::where('name', 'admin')->first();
		$gerenciar_funcionarios = Role::where('name', 'gerenciar_funcionarios')->first();
		$importar_leads = Role::where('name', 'importar_leads')->first();
		$gerenciar_equipe = Role::where('name', 'gerenciar_equipe')->first();
		$gerenciar_vendas = Role::where('name', 'gerenciar_vendas')->first();
		$role_administrativo = Role::where('name', 'gerenciar_funcionarios')->first();

		$equipe1 = Equipe::where('nome', 'EquipeFera1')->first();
		$equipe2 = Equipe::where('nome', 'EquipeFera2')->first();

		$cargo_vendedor = Cargo::where('nome', 'Vendedor')->first();
		$cargo_gerente = Cargo::where('nome', 'Gerente Geral')->first();
		$cargo_coordenador = Cargo::where('nome', 'Coordenador')->first();
		$cargo_posvenda = Cargo::where('nome', 'Pós Venda')->first();
		$cargo_vendedor = Cargo::where('nome', 'Vendedor')->first();
		$cargo_admvo = Cargo::where('nome', 'Assistente Adminstrativo')->first();

		$user = new User();
		$user->name = 'Gerente';
		$user->email = 'gerente@' . env('APP_SHORT_NAME');
		$user->avatar = 'user-padrao.png';
		$user->status = UserStatus::ativo;
		$user->password = Hash::make('123');
		$user->cargo_id = $cargo_gerente->id;
		$user->save();
		$user->roles()->attach($role_gerente);
		$user->roles()->attach($gerenciar_funcionarios);
		$user->roles()->attach($importar_leads);
		$user->roles()->attach($gerenciar_equipe);
		$user->roles()->attach($gerenciar_vendas);

		$user = new User();
		$user->name = 'Administrador';
		$user->email = 'administrativo@' . env('APP_SHORT_NAME');
		$user->status = UserStatus::ativo;
		$user->avatar = 'user-padrao.png';
		$user->cargo_id = $cargo_admvo->id;
		$user->password = Hash::make('123');
		$user->save();
		$user->roles()->attach($gerenciar_funcionarios); # Papel de gestão de funcionarios

		$user = new User();
		$user->name = 'Coordenador1';
		$user->email = 'coordenador1@' . env('APP_SHORT_NAME');
		$user->avatar = 'user-padrao.png';
		$user->cargo_id = $cargo_coordenador->id;
		$user->status = UserStatus::ativo;
		$user->password = Hash::make('123');
		$user->equipe_id = $equipe1->id;
		$user->save();
		$user->roles()->attach($gerenciar_equipe);
		$user->roles()->attach($importar_leads);

		$equipe1->lider_id = $user->id;
		$equipe1->save();

		$user = new User();
		$user->name = 'Coordenador2';
		$user->email = 'coordenador2@' . env('APP_SHORT_NAME');
		$user->cargo_id = $cargo_coordenador->id;
		$user->avatar = 'user-padrao.png';
		$user->status = UserStatus::ativo;
		$user->password = Hash::make('123');
		$user->equipe_id = $equipe2->id;
		$user->save();
		$user->roles()->attach($gerenciar_equipe);

		$equipe2->lider_id = $user->id;

		$equipe2->save();

		$user = new User();
		$user->name = 'Vendedor1';
		$user->email = 'vendedor1@' . env('APP_SHORT_NAME');
		$user->avatar = 'user-padrao.png';
		$user->cargo_id = $cargo_vendedor->id;

		$user->status = UserStatus::ativo;
		$user->password = Hash::make('123');
		$user->equipe_id = $equipe1->id;
		$user->save();


		$user = new User();
		$user->name = 'Vendedor2';
		$user->email = 'vendedor2@' . env('APP_SHORT_NAME');
		$user->avatar = 'user-padrao.png';
		$user->cargo_id = $cargo_vendedor->id;
		$user->status = UserStatus::ativo;
		$user->password = Hash::make('123');
		$user->equipe_id = $equipe1->id;
		$user->save();


		$user = new User();
		$user->name = 'Vendedor3';
		$user->email = 'vendedor3@' . env('APP_SHORT_NAME');
		$user->avatar = 'user-padrao.png';
		$user->cargo_id = $cargo_vendedor->id;
		$user->equipe_id = $equipe2->id;
		$user->status = UserStatus::ativo;
		$user->password = Hash::make('123');
		$user->save();


		$user = new User();
		$user->name = 'Vendedor4';
		$user->email = 'vendedor4@' . env('APP_SHORT_NAME');
		$user->avatar = 'user-padrao.png';
		$user->cargo_id = $cargo_vendedor->id;
		$user->equipe_id = $equipe2->id;
		$user->status = UserStatus::ativo;
		$user->password = Hash::make('123');
		$user->save();


		$user = new User();
		$user->name = 'Pos Venda';
		$user->email = 'posvenda@' . env('APP_SHORT_NAME');
		$user->avatar = 'user-padrao.png';
		$user->cargo_id = $cargo_posvenda->id;
		$user->status = UserStatus::ativo;
		$user->password = Hash::make('123');
		$user->save();

	}
}