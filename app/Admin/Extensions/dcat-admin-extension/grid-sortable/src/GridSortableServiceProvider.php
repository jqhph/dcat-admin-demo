<?php

namespace Dcat\Admin\Extension\GridSortable;

use Dcat\Admin\Admin;
use Illuminate\Support\ServiceProvider;

class GridSortableServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $extension = GridSortable::make();

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, GridSortable::NAME);
        }

        if ($lang = $extension->lang()) {
            $this->loadTranslationsFrom($lang, GridSortable::NAME);
        }

        if ($migrations = $extension->migrations()) {
            $this->loadMigrationsFrom($migrations);
        }

        $this->app->booted(function () use ($extension) {
            $extension->routes(__DIR__.'/../routes/web.php');
        });

        $extension->boot();
    }
}