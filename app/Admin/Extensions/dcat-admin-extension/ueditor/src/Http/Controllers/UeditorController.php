<?php

namespace Dcat\Admin\Extension\UEditor\Http\Controllers;

use Dcat\Admin\Extension\UEditor\Storage;
use Dcat\Admin\Extension\UEditor\Ueditor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UeditorController extends Controller
{
    /**
     * @var Storage
     */
    protected $storage;

    public function serve(Request $request)
    {
        $upload = Ueditor::getUploadConfig();

        switch ($request->get('action')) {
            case 'config':
                return $upload;
            // lists
            case $upload['imageManagerActionName']:
                return $this->storage()->listFiles(
                    $upload['imageManagerListPath'],
                    $request->get('start'),
                    $request->get('size'),
                    $upload['imageManagerAllowFiles']);

            case $upload['fileManagerActionName']:
                return $this->storage()->listFiles(
                    $upload['fileManagerListPath'],
                    $request->get('start'),
                    $request->get('size'),
                    $upload['fileManagerAllowFiles']);

            case $upload['catcherActionName']:
                return $this->storage()->fetch($request);

            default:
                return $this->storage()->upload($request);

        }
    }

    protected function storage()
    {
        $disk = \request('disk');

        return $this->storage ?: ($this->storage = Storage::make($disk));
    }

}