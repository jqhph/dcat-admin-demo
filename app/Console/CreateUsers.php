<?php

namespace App\Console;

use Dcat\Admin\Models\Administrator;
use Illuminate\Console\Command;

class CreateUsers extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'create-users';

    /**
     * @return void
     */
    public function handle()
    {
        $number = 5000;

        $this->line('开始');

        factory(Administrator::class, $number)->create();

        $this->info("已创建{$number}条数据！");
    }
}
