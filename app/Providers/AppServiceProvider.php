<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

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
        Builder::macro('search', function($field, $string) {
            if(is_array($string)){
                $string = explode($string);
                $string = $string[0];
            }
                
            switch($field){
                case ('calendario_id_cal'):
                    return $string ? $this->where($field, $string) : $this;
                    break;

                case ('alumno_id_alumno'):
                    return $string ? $this->where($field, $string) : $this;
                    break;

                case('empresa_id_empresa'):
                    return $string ? $this->where($field, $string) : $this;
                    break;

                default:
                    return $string ? $this->where($field, 'like', '%'.$string.'%') : $this;
                    break;
            }

        });
    }
}
