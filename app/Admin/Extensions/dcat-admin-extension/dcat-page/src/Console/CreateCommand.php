<?php

namespace Dcat\Page\Console;

use Dcat\Page\DcatPage;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\SplFileInfo;

class CreateCommand extends Command
{
    use DcatApp;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dcatpage:create {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a app.';

    /**
     * @var array
     */
    protected $dirs = DcatPage::NAME;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->getAppName();

        if ($this->exist($name)) {
            return $this->error("[$name] already exists!");
        }

        $path = $this->path($name);

        $from = $this->getTemplatePath();

        $this->makeDirectories($from, $path);
        $this->copy($from, $path);

        $this->showTree($path);
    }

    protected function showTree($path)
    {
        $tree = <<<TREE
{$path}
    ├── package.json
    ├── webpack.mix.js
    ├── config.php
    ├── .gitignore
    ├── assets
    │   ├── js
    │   │   └── ...
    │   └── sass
    │       └── ...
    ├── public
    │   └── assets
    │       └── ...
    ├── views
    │   ├── pages
    │   │   ├── docs.blade.php
    │   │   └── index.blade.php
    │   ├── partials
    │   │   └── ...
    │   └── app.blade.php 
    └── docs
        └── master
            ├── documentation.md
            └── installation.md        
TREE;

        $this->info($tree);
    }

    protected function copy($from, $to)
    {
        /* @var Filesystem $files */
        $files = app('files');

        $allFiles = collect($files->allFiles($from, true))->map(function (SplFileInfo $fileInfo) {
            return $fileInfo->getRealPath();
        })->toArray();

        foreach ($allFiles as $path) {
            $files->copy($path, $to.str_replace($from, '', $path));
        }
    }

    protected function makeDirectories($from, $to)
    {
        if (!is_dir($from)) {
            return;
        }

        /* @var Filesystem $files */
        $files = app('files');

        if (!is_dir($to)) {
            $files->makeDirectory($to, 0755, true);
        }

        foreach ($files->directories($from) as $dir) {
            $dir = basename($dir);

            $files->makeDirectory($to.'/'.$dir);

            $this->makeDirectories($from.'/'.$dir, $to.'/'.$dir);
        }
    }

    protected function getTemplatePath()
    {
        return dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'templates';
    }
}
