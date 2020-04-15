<?php

namespace Dcat\Page\Http;

use Illuminate\Http\Response;

/**
 * http请求静态文件处理类.
 */
class Assets
{
    /**
     * 文件类型返回配置.
     *
     * @var array
     */
    protected static $mimeTypeMap = [
        'json'   => 'application/json',
        'css'    => 'text/css',
        'js'     => 'text/javascript',
        'html'   => 'text/html',
        'htm'    => 'text/html',
        'txt'    => 'text/plain',
        'text'   => 'text/plain',
        'conf'   => 'text/plain',
        'log'    => 'text/plain',
        'gif'    => 'image/gif',
        'jpg'    => 'image/jpg',
        'jpeg'   => 'image/jpeg',
        'pjpeg'  => 'image/pjpeg',
        'jp2'    => 'image/jp2',
        'jpg2'   => 'image/jp2',
        'jpm'    => 'image/jpm',
        'jpgm'   => 'image/jpm',
        'jpx'    => 'image/jpx',
        'jpf'    => 'image/jpx',
        'svg'    => 'image/svg+xml',
        'svgz'   => 'image/svg+xml-compressed',
        '3ds'    => 'image/x-3ds',
        'png'    => 'image/png',
        'x-png'  => 'image/x-png',
        'webp'   => 'image/webp',
        'x-webp' => 'image/x-webp',
        'bmp'    => 'image/bmp',
        'ico'    => 'image/icon',
        'icon'   => 'image/icon',
        'avi'    => 'video/avi',
        'avf'    => 'video/avi',
        'divx'   => 'video/avi',
        'dv'     => 'video/dv',
        'flv'    => 'video/flv',
        'mp4'    => 'video/mp4',
        'mp4v'   => 'video/mp4',
        'mpg4'   => 'video/mp4',
        'f4v'    => 'video/mp4',
        'lrv'    => 'video/mp4',
        'wmv'    => 'video/x-ms-wmv',
        'wm'     => 'video/x-ms-wm',
        'asf'    => 'video/x-ms-wm',
        'ogv'    => 'video/x-ogg',
        'ogg'    => 'video/x-ogg',
        'mp3'    => 'audio/mp3',
        'flac'   => 'audio/flac',
        'wma'    => 'audio/wma',
        'amr'    => 'audio/amr-encrypted',
        '3gp'    => 'audio/3gpp',
        '3gpp'   => 'audio/3gpp',
        '3ga'    => 'audio/3gpp',
    ];

    public static function addMimeType(string $extension, string $type)
    {
        if (!$extension || !$type) {
            return;
        }
        static::$mimeTypeMap[$extension] = $type;
    }

    /**
     * 读取请求文件.
     *
     * @param $path
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return Response
     */
    public static function response($path)
    {
        if ($fullPath = static::getFullPath($path)) {
            return static::makeResponseWithPath($fullPath);
        }

        abort(404);
    }

    /**
     * 发送文件.
     *
     * @param string $path 文件完整路径
     *
     * @return Response
     */
    public static function makeResponseWithPath(string $path)
    {
        $fileInfo = pathinfo($path);
        $extension = isset($fileInfo['extension']) ? $fileInfo['extension'] : '';

        $headers = [
            'Content-Type'        => 'application/octet-stream',
            'Content-Disposition' => '',
            'Connection'          => 'keep-alive',
        ];

        if (!empty(static::$mimeTypeMap[$extension])) {
            $headers['Content-Type'] = static::$mimeTypeMap[$extension];
        } else {
            $headers['Content-Type'] = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $path);
        }

        return response(file_get_contents($path), 200, $headers);
    }

    /**
     * 根据请求地址查找文件路径.
     *
     * @param string $path
     *
     * @return null|string
     */
    public static function getFullPath(string $path)
    {
        if (is_file($path)) {
            return $path;
        }

        return null;
    }
}
