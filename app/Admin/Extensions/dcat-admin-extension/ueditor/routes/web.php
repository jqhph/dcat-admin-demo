<?php

use Dcat\Admin\Extension\UEditor\Http\Controllers;

Route::any('ueditor/serve', Controllers\UeditorController::class.'@serve');
