<?php

namespace Dcat\Page\Admin\Repositories;

use Dcat\Page\DcatPage;
use Dcat\Admin\Grid;
use Dcat\Admin\Repositories\Repository;

class App extends Repository
{
    public function get(Grid\Model $model)
    {
        return collect(DcatPage::getAllAppNames())->map(function ($app) {
            DcatPage::init($app);

            $id = $app;

            $config = \DcatPage\config();

            $authors     = $config['authors'];
            $description = $config['description'] ?? null;
            $homepage    = $config['homepage'] ?? null;

            unset(
                $config['authors'],
                $config['description'],
                $config['homepage']
            );

            return compact('id', 'app', 'authors', 'description', 'homepage', 'config');
        });
    }
}
