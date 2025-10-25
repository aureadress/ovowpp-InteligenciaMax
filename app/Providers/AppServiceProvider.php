<?php

namespace App\Providers;


use App\Lib\Searchable;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Builder::mixin(new Searchable);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Forçar idioma PT-BR em toda a aplicação
        App::setLocale('pt_BR');
        
        // Garantir que Carbon também use PT-BR para datas
        if (class_exists('\Carbon\Carbon')) {
            \Carbon\Carbon::setLocale('pt_BR');
        }
        
        Paginator::useBootstrapFive();
        
        Builder::macro("firstOrFailWithApi", function ($modelName = "data") {
            $data = $this->first();
            if (!$data) {
                throw new \Exception("custom_not_found_exception || The $modelName is not found", 404);
            }
            return $data;
        });

        Builder::macro("findOrFailWithApi", function ($modelName = "data", $id) {
            $data = $this->where("id", $id)->first();
            if (!$data) {
                throw new \Exception("custom_not_found_exception || The $modelName is not found", 404);
            }
            return $data;
        });
    }
}
