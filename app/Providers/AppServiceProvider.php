<?php

namespace App\Providers;

use App\Models\Empresa;
use Exception;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Cache\Factory;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try {  
            $empresa__ = Empresa::all();
            $empresa =  array();
            foreach (Empresa::all() as $empresa__) {
                $empresa[$empresa__->settings] =$empresa__->value;
                config()->set($empresa__->settings, $empresa__->value);
            }

        }catch (Exception $e) {  
            echo '</br> <b> Exception Message: ' .$e->getMessage() .'</b>';  
        }
        
    }
}
