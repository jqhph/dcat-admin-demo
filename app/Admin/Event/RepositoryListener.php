<?php

namespace App\Admin\Event;

use Dcat\Admin\Form;
use Dcat\Admin\Repositories\RepositoryListener as Listener;

class RepositoryListener extends Listener
{
    public function updated(Form $form, array $originalAttributes, $result)
    {
//        dd($form->builder()->getResourceId(), $form->getKeyName(), $originalAttributes);
    }
}
