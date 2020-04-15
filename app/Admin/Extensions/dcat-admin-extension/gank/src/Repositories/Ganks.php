<?php

namespace Dcat\Admin\Extension\Gank\Repositories;

use Dcat\Admin\Grid;
use Dcat\Admin\Repositories\Repository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class Ganks extends Repository
{
    protected $api = 'http://gank.io/api/data/{category}/{limit}/{page}';

    protected $searchApi = 'http://gank.io/api/search/query/{key}/category/{category}/count/{limit}/page/{page}';

    /**
     * 查询表格数据
     *
     * @param Grid\Model $model
     * @return Collection
     */
    public function get(Grid\Model $model)
    {
        $currentPage = $model->getCurrentPage();
        $perPage = $model->getPerPage();

        // 获取筛选参数
        $category = $model->filter()->input(Grid\Filter\Scope::QUERY_NAME, 'all');
        $keyword  = trim($model->filter()->input('keyword'));

        $api = $keyword ? $this->searchApi : $this->api;

        $client = new \GuzzleHttp\Client();

        $response = $client->get(str_replace(
            ['{category}', '{limit}', '{page}', '{key}'],
            [$category, $perPage, $currentPage, $keyword],
            $api
        ));
        $data = collect(
            json_decode((string) $response->getBody(), true)['results'] ?? []
        );

        $total = $keyword ? 400 : ($category == 'all' ? 1000 : 500);

        $paginator = new LengthAwarePaginator(
            $data,
            $category == '福利' ? 680 : $total,
            $perPage, // 传入每页显示行数
            $currentPage // 传入当前页码
        );

        $paginator->setPath(\url()->current());

        return $paginator;
    }

    public function getKeyName()
    {
        return '_id';
    }

}
