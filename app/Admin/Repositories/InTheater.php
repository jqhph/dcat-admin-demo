<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Repositories\Repository;
use Illuminate\Pagination\LengthAwarePaginator;

class InTheater extends Repository
{
    protected $api = 'https://api.douban.com/v2/movie/in_theaters';

    protected $apiKey = 'apikey=0b2bdeda43b5688921839c8ecb20399b';

    /**
     * 查询表格数据
     *
     * @param Grid\Model $model
     * @return LengthAwarePaginator
     */
    public function get(Grid\Model $model)
    {
        $currentPage = $model->getCurrentPage();
        $perPage = $model->getPerPage();

        // 获取筛选参数
        $city = '广州';

        $start = ($currentPage - 1) * $perPage;

        $client = new \GuzzleHttp\Client();

        //$response = $client->get("{$this->api}?{$this->apiKey}&city={$city}&start=$start&count=$perPage");
        //$data = json_decode((string)$response->getBody(), true);
        $data = [
            'total' => 1,
            'subjects' => [
                [
                    'title' => '盗梦空间',
                    'images' => ['https://img9.doubanio.com/view/photo/s_ratio_poster/public/p2616355133.webp'],
                    'year' => '2010',
                    'rating' => '9.3',
                    'directors' => [['name' => '克里斯托弗·诺兰']],
                    'genres' => ['剧情', '科幻', '悬疑', '冒险'],
                ],
            ],
        ];

        return $model->makePaginator(
            $data['total'] ?? 0,
            $data['subjects'] ?? []
        );
    }

    /**
     * 查询编辑页数据
     *
     * @param Form $form
     * @return array
     */
    public function edit(Form $form): array
    {
        $id = $form->builder()->getResourceId();

        $data = file_get_contents("http://api.douban.com/v2/movie/subject/$id?{$this->apiKey}");

        return json_decode($data, true);
    }

    /**
     * 编辑数据
     *
     * @param Form $form
     */
    public function update(Form $form)
    {
        $id = $form->builder()->getResourceId();

        $attributes = $form->getUpdates();

        // TODO
//        var_dump($id, $attributes);
    }

    /**
     * 查询删除前数据
     *
     * @param Form $form
     * @return array
     */
    public function getDataWhenDeleting(Form $form): array
    {
        $id = $form->builder()->getResourceId();

//        $data = file_get_contents("http://api.douban.com/v2/movie/subject/$id");
//
//        return json_decode($data, true);

        return [];
    }

    /**
     * 删除数据
     *
     * @param Form $form
     * @param array $deletingData
     */
    public function destroy(Form $form, array $deletingData)
    {
        $id = $form->builder()->getResourceId();

        // TODO
//        var_dump($id, $deletingData);
    }

}
