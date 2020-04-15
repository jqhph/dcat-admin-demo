<?php

namespace Dcat\Admin\Extension\UEditor;

use Dcat\Admin\Form;
use Illuminate\Support\ServiceProvider;

class UeditorServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $extension = Ueditor::make();

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, Ueditor::NAME);
        }

        if ($lang = $extension->lang()) {
            $this->loadTranslationsFrom($lang, Ueditor::NAME);
        }

        if ($migrations = $extension->migrations()) {
            $this->loadMigrationsFrom($migrations);
        }


        $this->app->booted(function () use ($extension) {
            $extension->routes(__DIR__.'/../routes/web.php');
        });

        if ($this->app->runningInConsole() || request()->getMethod() == 'POST') {
            $this->publishes([__DIR__.'/../config' => config_path()]);
        }

        Form::extend('ueditor', \Dcat\Admin\Extension\UEditor\Form\UEditor::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

}