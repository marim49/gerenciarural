<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('unique_combustivel', function ($attribute, $value, $parameters, $validator) {
            $inputs = $validator->getData();
            $id_fazenda = $inputs['id_fazenda'];
            $id_tipo_combustivel = $inputs['id_tipo_combustivel'];
            $result = true;

            $insumo = \DB::select('select * from combustivel 
                        where id_fazenda = ? AND id_tipo_combustivel = ?',
                        [$id_fazenda, $id_tipo_combustivel]);

            if ($insumo) {
                $result = false;
            }
            return $result;
        });
        Validator::extend('unique_insumo', function ($attribute, $value, $parameters, $validator) {
            $inputs = $validator->getData();
            $id_celeiro = $inputs['id_celeiro'];
            $id_tipo_insumo = $inputs['id_tipo_insumo'];
            $result = true;

            $insumo = \DB::select('select * from insumo 
                        where id_celeiro = ? AND id_tipo_insumo = ?',
                        [$id_celeiro, $id_tipo_insumo]);

            if ($insumo) {
                $result = false;
            }
            return $result;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
