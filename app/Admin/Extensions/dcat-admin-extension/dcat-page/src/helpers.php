<?php

namespace DcatPage
{

    use Dcat\Page\DcatPage;
    use Illuminate\Support\Str;

    \define('DCAT_PAGE_VERSION', DcatPage::NAME);

    /**
     * 获取配置.
     *
     * @param null $key
     * @param null $default
     * @param null $app     应用名称
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    function config($key = null, $default = null, $app = null)
    {
        $app = $app ?: DcatPage::getCurrentAppName();

        $name = DcatPage::NAME;

        if ($key === null) {
            return \config("$name.$app");
        }

        return \config("$name.$app.$key", $default);
    }

    /**
     * 获取文档默认版本号.
     *
     * @param null $app 应用名称
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    function default_version($app = null)
    {
        return config('doc.version', 'master', $app);
    }

    /**
     * 获取应用路径.
     *
     * @param $path
     * @param string $app 应用名称
     *
     * @return string
     */
    function path($path = null, $app = null)
    {
        $app = $app ?: DcatPage::getCurrentAppName();

        $name = DcatPage::NAME;

        $prefix = resource_path("$name/$app");

        if ($path === null) {
            return rtrim($prefix, '/');
        }

        return $prefix.'/'.trim($path, '/');
    }

    /**
     * SVG helper.
     *
     * @param string $src Path to svg in the cp image directory
     *
     * @return string
     */
    function svg($src)
    {
        return asset('assets/svg/'.trim($src, '/').'.svg');
    }

    /**
     * Convert some text to Markdown...
     */
    function markdown($text)
    {
        return (new \ParsedownExtra())->text($text);
    }

    /**
     * 获取静态资源路径.
     *
     * @param $path
     * @param null $app 应用名称
     *
     * @return string
     */
    function asset($path, $app = null)
    {
        if (Str::contains($path, '//')) {
            return $path;
        }

        if (DcatPage::isCompiling()) {
            return trim($path, '/');
        }

        $app = $app ?: DcatPage::getCurrentAppName();

        $name = DcatPage::NAME;

        return "/$name/$app/resource/".trim($path, '/');
    }

    /**
     * 获取页面链接.
     *
     * @param $url
     * @param null $app
     *
     * @return string
     */
    function url($url, $app = null)
    {
        if (\url()->isValidUrl($url)) {
            return $url;
        }

        if (DcatPage::isCompiling()) {
            if (!$url = trim($url, '/')) {
                return 'index.html';
            }

            if (!Str::contains($url, '.html')) {
                $url .= '.html';
            }

            return str_replace('/', '-', slug($url));
        }

        $app = $app ?: DcatPage::getCurrentAppName();

        $name = DcatPage::NAME;

        return "/$name/$app/".trim($url, '/');
    }

    /**
     * 获取文档链接.
     *
     * @param $doc
     * @param null $version
     *
     * @return mixed|string
     */
    function doc_url($doc, $version = null)
    {
        $version = $version ?: default_version();

        if (DcatPage::isCompiling()) {
            return generate_doc_path_when_compiling($version, $doc);
        }

        return url("docs/$version/$doc");
    }

    /**
     * 生成编译环境的文档路径.
     *
     * @param string $version
     * @param string $doc
     *
     * @return mixed
     */
    function generate_doc_path_when_compiling($version, $doc)
    {
        if (!Str::contains($doc, '.md')) {
            $doc .= '.md';
        }

        return slug("docs/{$version}/".str_replace('.md', '.html', $doc));
    }

    /**
     * 获取页面视图.
     *
     * @param $view
     * @param null $app
     *
     * @return \Illuminate\View\View
     */
    function page($view, $app = null)
    {
        $app = $app ?: DcatPage::getCurrentAppName();

        $name = DcatPage::NAME;

        $view = "$name::{$app}.views.pages.{$view}";

        abort_if(!\view()->exists($view), 404);

        return \view($view);
    }

    /**
     * 获取页面视图名称.
     *
     * @param $view
     * @param null $app
     *
     * @return string
     */
    function view_name($view, $app = null)
    {
        $app = $app ?: DcatPage::getCurrentAppName();

        $name = DcatPage::NAME;

        return "$name::{$app}.views.{$view}";
    }

    /**
     * 获取视图.
     *
     * @param $view
     * @param null $app
     *
     * @return \Illuminate\View\View
     */
    function view($view, $app = null)
    {
        $view = view_name($view, $app);

        abort_if(!\view()->exists($view), 404);

        return \view($view);
    }

    /**
     * 渲染视图.
     *
     * @param $view
     * @param null $app
     *
     * @return string
     */
    function render($view, array $vars = [])
    {
        return view($view)->with($vars)->render();
    }

    /**
     * 获取css引入html.
     *
     * @param $path
     * @param null $app
     *
     * @return string
     */
    function html_css($path, $app = null)
    {
        $path = asset($path, $app);

        return <<<HTML
 <link rel="stylesheet" href="$path">
HTML;
    }

    /**
     *  获取js引入html.
     *
     * @param $path
     * @param null $app
     *
     * @return string
     */
    function html_js($path, $app = null)
    {
        $path = asset($path, $app);

        return <<<HTML
 <script src="$path"></script>
HTML;
    }

    /**
     * Generate a URL friendly "slug" from a given string.
     *
     * @param string $name
     * @param string $symbol
     *
     * @return mixed
     */
    function slug(string $name, string $symbol = '-')
    {
        $text = preg_replace_callback('/([A-Z])/', function (&$text) use ($symbol) {
            return $symbol.strtolower($text[1]);
        }, $name);

        return str_replace('_', $symbol, ltrim($text, $symbol));
    }

}
