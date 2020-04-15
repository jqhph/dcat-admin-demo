<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Grid;
use Dcat\Admin\Repositories\EloquentRepository;
use Faker\Factory;
use Illuminate\Pagination\LengthAwarePaginator;

class Top250 extends ComingSoon
{
    protected $api = 'https://api.douban.com/v2/movie/top250';
}
