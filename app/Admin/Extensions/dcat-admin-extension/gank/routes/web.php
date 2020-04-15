<?php

use Dcat\Admin\Extension\Gank\Http\Controllers;

// 所有干货
Route::get('gank', Controllers\GankController::class.'@index');
// 最新干货
Route::get('gank/latest', Controllers\LatestController::class.'@index');