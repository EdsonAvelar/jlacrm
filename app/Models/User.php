<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'telefone',
        'avatar',
        'status',
        'cargo_id',
        'data_contratacao',
        'rg',
        'cpf',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany("App\Models\Role");
    }

    public function leads()
    {
        return $this->belongsToMany("App\Models\Lead");
    }

    public function equipe(){
      return $this->belongsTo("App\Models\Equipe");
    }

    public function cargo(){
      return $this->belongsTo("App\Models\Cargo");
    }


    public function vendas(){
      return $this->hasMany("App\Models\Venda");
    }

    
    public function is($roleName)
    {
        foreach ($this->roles()->get() as $role)
        {
            if ($role->name == $roleName)
            {
                return true;
            }
        }

        return false;
    }

    public function hasAnyRole($roles)
    {
      if (is_array($roles)) {
        foreach ($roles as $role) {
          if ($this->hasRole($role)) {
            return true;
          }
        }
      } else {
        if ($this->hasRole($roles)) {
          return true;
        }
      }
      return false;
    }
    

    public function hasRole($role)
    {
      if ($this->roles()->where('name', $role)->first()) {
        return true;
      }
      return false;
    }

    public function ativos()
    {
      
      return $this->where('status', UserStatus::ativo)->get();
    }

    public function vendedores()
    {
      $cargos = Cargo::where(  ['nome' => 'Vendedor' ])->orWhere(['nome'=>'Coordenador'])->pluck('id');
      $users = User::whereIn('cargo_id', $cargos)->where(['status' => UserStatus::ativo] )->get();

      return $users;
    }

    public function vendedores_sem_equipes()
    {


      $cargos = Cargo::where(  ['nome' => 'Vendedor' ])->orWhere(['nome'=>'Coordenador'])->pluck('id');
      $users = User::whereIn('cargo_id', $cargos)->where(['status' => UserStatus::ativo, 'equipe_id' => null] )->get();

      return $users;
    }

}
