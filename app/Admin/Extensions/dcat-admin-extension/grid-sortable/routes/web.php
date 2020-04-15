<?php

use Dcat\Admin\Extension\GridSortable\Http\Controllers;

Route::post('extension/grid-sort', Controllers\GridSortableController::class.'@sort')->name('dcat-admin-grid-sortable');