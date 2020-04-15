<?php

namespace Dcat\Admin\Extension\Gank\Repositories;

use Dcat\Admin\Grid;
use Dcat\Admin\Repositories\Repository;
use Illuminate\Support\Collection;

class Latest extends Repository
{
    protected $api = 'http://gank.io/api/today';

    /**
     * 查询表格数据
     *
     * @param Grid\Model $model
     * @return Collection
     */
    public function get(Grid\Model $model)
    {
        // 获取筛选参数
        $type = $model->filter()->input(Grid\Filter\Scope::QUERY_NAME);

        $client = new \GuzzleHttp\Client();

        $response = $client->get($this->api);
        $data = collect(
            json_decode((string) $response->getBody(), true)['results'] ?? []
        );

        if ($type) {
            $data = $data->filter(function ($v, $k) use ($type) {
                return $type == $k;
            });
        } else {
            $data = $data->reject(function ($v, $k) {
                return in_array($k, ['iOS', 'Android', '休息视频']);
            });
        }

        return $data->flatten(1);
    }

    public function getKeyName()
    {
        return '_id';
    }

    function post($url, $data = [])
    {
        $postdata = http_build_query(
            $data
        );

        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);
        return $result;
    }

}
