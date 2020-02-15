<?php

namespace App\Providers;

use Dcat\Admin\Admin;
use Illuminate\Support\ServiceProvider;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (config('app.debug') && class_exists(IdeHelperServiceProvider::class)) {
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //        Admin::style(
//            <<<'CSS'
//
///*.material .box-header, .material .card-header {*/
///*    padding:15px 12px;*/
///*}*/
///*.material .box-header .btn, .material .card-header .btn {*/
///*    font-weight:normal;*/
///*    !*text-transform: uppercase;*!*/
///*}*/
///*.material .box-header .btn.btn-primary, .material .card-header .btn.btn-primary {*/
///*    color:var(--primary-dark)!important;*/
///*}*/
//
///*.material .box-header .btn.btn-success, .material .card-header .btn.btn-success {*/
///*    color:var(--success)!important;*/
///*}*/
//
//.material .box-header .btn.btn-danger, .material .card-header .btn.btn-danger {
//    color:var(--danger-dark)!important;
//}
//
///*.material .box-header .btn.btn-custom, .material .card-header .btn.btn-custom {*/
///*    color:var(--primary)!important;*/
///*}*/
//
///*.material .box-header .btn.btn-purple, .material .card-header .btn.btn-purple {*/
///*    color:var(--purple)!important;*/
///*}*/
//CSS
//        );
    }


}
