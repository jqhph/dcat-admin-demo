<?php
/*
 * This file is part of the overtrue/laravel-ueditor.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Dcat\Admin\Extension\UEditor;

use Dcat\Admin\Extension\UEditor\Events\Catched;
use Dcat\Admin\Extension\UEditor\Events\Uploaded;
use Dcat\Admin\Extension\UEditor\Events\Uploading;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Storage
{
    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected $disk;

    /**
     * Constructor.
     *
     * @param \Illuminate\Contracts\Filesystem\Filesystem $disk
     */
    public function __construct(Filesystem $disk)
    {
        $this->disk = $disk;
    }

    /**
     * Upload a file.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        $config = $this->getUploadConfig($request->get('action'));

        if (!$request->hasFile($config['field_name'])) {
            return $this->error('UPLOAD_ERR_NO_FILE');
        }

        $file = $request->file($config['field_name']);

        if ($error = $this->fileHasError($file, $config)) {
            return $this->error($error);
        }

        $filename = $this->getFilename($file, $config);

        if ($this->eventSupport()) {
            $modifiedFilename = event(new Uploading($file, $filename, $config), [], true);
            $filename = !is_null($modifiedFilename) ? $modifiedFilename : $filename;
        }

        $this->store($file, $filename);

        $response = [
            'state' => 'SUCCESS',
            'url' => $this->getUrl($filename),
            'title' => $filename,
            'original' => $file->getClientOriginalName(),
            'type' => $file->getExtension(),
            'size' => $file->getSize(),
        ];

        if ($this->eventSupport()) {
            event(new Uploaded($file, $response));
        }

        return response()->json($response);
    }

    /**
     * Fetch a file.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetch(Request $request)
    {
        $config = $this->getUploadConfig($request->get('action'));
        $urls = $request->get($config['field_name']);

        if (count($urls) === 0) {
            return $this->error('UPLOAD_ERR_NO_FILE');
        }

        $urls = array_unique($urls);
        $list = array();
        foreach ($urls as $key => $url) {
            $img = $this->download($url, $config);
            if ($img['state'] === 'SUCCESS') {
                $file = $img['file'];
                $filename = $img['filename'];
                $this->storeContent($file, $filename);
                if ($this->eventSupport()) {
                    unset($img['file']);
                    event(new Catched($img));
                }
            }
            unset($img['file']);
            array_push($list, $img);
        }

        $response = [
            'state' => count($list) ? 'SUCCESS' : 'ERROR',
            'list' => $list
        ];

        return response()->json($response);
    }

    /**
     * Download a file.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Http\JsonResponse $info
     */
    private function download($url, $config)
    {
        if (strpos($url, 'http') !== 0) {
            return $this->error('ERROR_HTTP_LINK');
        }

        $pathRes = parse_url($url);
        $img = new \SplFileInfo($pathRes['path']);
        $original = $img->getFilename();
        $ext = $img->getExtension();
        $title = md5($url) . '.' . $ext;
        $filename = $this->formatPath($config['path_format'], $title);

        $info = [
            'state' => 'SUCCESS',
            'url' => $this->getUrl($filename),
            'title' => $title,
            'original' => $original,
            'source' => $url,
            'size' => 0,
            'file' => '',
            'filename' => $filename,
        ];

        $context = stream_context_create(
            array('http' => array(
                'follow_location' => false, // don't follow redirects
            ))
        );

        $file = fopen($url, 'r', false, $context);
        if ($file === false) {
            $info['state'] = 'ERROR';
            return $info;
        }

        $content = stream_get_contents($file);
        fclose($file);
        $info['file'] = $content;
        $info['siez'] = strlen($content);

        return $info;
    }

    /**
     * @return bool
     */
    public function eventSupport()
    {
        return trait_exists('Illuminate\Foundation\Events\Dispatchable');
    }

    /**
     * List all files of dir.
     *
     * @param string $path
     * @param int $start
     * @param int $size
     * @param array $allowFiles
     *
     * @return array
     */
    public function listFiles($path, $start, $size = 20, array $allowFiles = [])
    {
        $allFiles = $this->disk->listContents($path, true);
        $files = $this->paginateFiles($allFiles, $start, $size);

        return [
            'state' => empty($files) ? 'EMPTY' : 'SUCCESS',
            'list' => $files,
            'start' => $start,
            'total' => count($allFiles),
        ];
    }

    /**
     * Split results.
     *
     * @param array $files
     * @param int $start
     * @param int $size
     *
     * @return array
     */
    protected function paginateFiles(array $files, $start = 0, $size = 50)
    {
        return collect($files)->where('type', 'file')->splice($start)->take($size)->map(function ($file) {
            return [
                'url' => $this->getUrl($file['path']),
                'mtime' => $file['timestamp'],
            ];
        })->all();
    }

    /**
     * Store file.
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @param string $filename
     *
     * @return mixed
     */
    protected function store(UploadedFile $file, $filename)
    {
        return $this->disk->put($filename, fopen($file->getRealPath(), 'r+'));
    }

    /**
     * Store file from content.
     *
     * @param string
     * @param string $filename
     *
     * @return mixed
     */
    protected function storeContent($content, $filename)
    {
        return $this->disk->put($filename, $content);
    }

    /**
     * Validate the input file.
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @param array $config
     *
     * @return bool|string
     */
    protected function fileHasError(UploadedFile $file, array $config)
    {
        $error = false;

        if (!$file->isValid()) {
            $error = $file->getError();
        } elseif ($file->getSize() > $config['max_size']) {
            $error = 'upload.ERROR_SIZE_EXCEED';
        } elseif (!empty($config['allow_files']) &&
            !in_array('.' . $file->getClientOriginalExtension(), $config['allow_files'])) {
            $error = 'upload.ERROR_TYPE_NOT_ALLOWED';
        }

        return $error;
    }

    /**
     * Get the new filename of file.
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @param array $config
     *
     * @return string
     */
    protected function getFilename(UploadedFile $file, array $config)
    {
        $ext = '.' . $file->getClientOriginalExtension();
        $filename = config('ueditor.hash_filename') ? md5($file->getFilename()) . $ext : $file->getClientOriginalName();
        return $this->formatPath($config['path_format'], $filename);
    }

    /**
     * Get configuration of current action.
     *
     * @param string $action
     *
     * @return array
     */
    protected function getUploadConfig($action)
    {
        $upload = Ueditor::getUploadConfig();
        $prefixes = [
            'image', 'scrawl', 'snapscreen', 'catcher', 'video', 'file',
            'imageManager', 'fileManager',
        ];
        $config = [];

        foreach ($prefixes as $prefix) {
            if ($action == $upload[$prefix . 'ActionName']) {
                $config = [
                    'action' => Arr::get($upload, $prefix . 'ActionName'),
                    'field_name' => Arr::get($upload, $prefix . 'FieldName'),
                    'max_size' => Arr::get($upload, $prefix . 'MaxSize'),
                    'allow_files' => Arr::get($upload, $prefix . 'AllowFiles', []),
                    'path_format' => Arr::get($upload, $prefix . 'PathFormat'),
                ];
                break;
            }
        }

        return $config;
    }

    /**
     * Make error response.
     *
     * @param $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error($message)
    {
        return response()->json(['state' => trans("ueditor::upload.{$message}")]);
    }

    /**
     * Format the storage path.
     *
     * @param string $path
     * @param string $filename
     *
     * @return mixed
     */
    protected function formatPath($path, $filename)
    {
        $replacement = array_merge(explode('-', date('Y-y-m-d-H-i-s')), [$filename, time()]);
        $placeholders = ['{yyyy}', '{yy}', '{mm}', '{dd}', '{hh}', '{ii}', '{ss}', '{filename}', '{time}'];
        $path = str_replace($placeholders, $replacement, $path);

        // 替换随机字符串
        if (preg_match('/\{rand\:([\d]*)\}/i', $path, $matches)) {
            $length = min($matches[1], strlen(PHP_INT_MAX));
            $path = preg_replace('/\{rand\:[\d]*\}/i', str_pad(mt_rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT), $path);
        }

        if (!Str::contains($path, $filename)) {
            $path = Str::finish($path, '/') . $filename;
        }
        return $path;
    }

    /**
     * @param string $filename
     *
     * @return string
     */
    public function getUrl($filename)
    {
        return $this->disk->url($filename);
    }

    /**
     * @param null $disk
     * @return static
     */
    public static function make($disk = null)
    {
        if (!$disk) {
            $disk = Ueditor::make()->config('disk') ?: config('admin.upload.disk', 'public');
        }

        if (is_string($disk)) {
            $disk = \Illuminate\Support\Facades\Storage::disk($disk);
        }

        return new static($disk);
    }

}