<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\Repository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Dcat\Admin\Grid;

class TeaTable extends Repository
{
    /**
     * Get the grid data.
     *
     * @param Grid\Model $model
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection|array
     */
    public function get(Grid\Model $model)
    {
        $page     = $model->getCurrentPage();
        $pageSize = $model->getPerPage();

        $collection = $this->all()->forPage($page, $pageSize);

        return $model->makePaginator(
            $this->all()->count(),
            $collection
        );
    }

    protected function all()
    {
        return collect([
            [
                'id'        => 1,
                'name'      => '现代简约客厅茶几',
                'norms'     => '长120*宽60*高41cm',
                'category'  => '茶几',
                'price'     => 4299000,
                'shop_name' => 'AiW官方旗舰店',
                'brand'     => 'AiW',
                'state'     => 1,
                'added_at'  => '2019-10-17 12:11:19',
            ],


            [
                'id'        => 2,
                'name'      => '客厅双层大茶几',
                'norms'     => '长160*宽70*高52cm',
                'category'  => '茶几',
                'price'     => 2810000,
                'shop_name' => 'YaLM官方旗舰店',
                'brand'     => 'YaLM',
                'state'     => 1,
                'added_at'  => '2019-10-20 12:11:19',
            ],

            [
                'id'        => 3,
                'name'      => '家居小户型茶几',
                'norms'     => '长80*宽50*高40cm',
                'category'  => '茶几',
                'price'     => 799000,
                'shop_name' => '全有官方旗舰店',
                'brand'     => '全有家居',
                'state'     => 0,
                'added_at'  => '',
            ],


            [
                'id'        => 4,
                'name'      => '茶几电视柜组合套装',
                'norms'     => '长120*宽60*高41cm',
                'category'  => '地柜式',
                'price'     => 2799000,
                'shop_name' => '众徘官方旗舰店',
                'brand'     => '众徘',
                'state'     => 1,
                'added_at'  => '2019-11-10 08:11:19',
            ],


            [
                'id'        => 5,
                'name'      => '北欧轻奢地柜',
                'norms'     => '长80*宽40*高40cm',
                'category'  => '地柜式',
                'price'     => 599000,
                'shop_name' => '予以官方旗舰店',
                'brand'     => '予以',
                'state'     => 1,
                'added_at'  => '2019-09-22 15:21:48',
            ],


            [
                'id'        => 6,
                'name'      => '现代简约双层带抽茶几',
                'norms'     => '长220*宽75*高48cm',
                'category'  => '地柜式',
                'price'     => 4299000,
                'shop_name' => 'AiW官方旗舰店',
                'brand'     => 'AiW',
                'state'     => 1,
                'added_at'  => '2019-10-17 12:11:19',
            ],


            [
                'id'        => 7,
                'name'      => '现代简约可伸缩地柜家具',
                'norms'     => '长120*宽60*高41cm',
                'category'  => '茶几',
                'price'     => 8756000,
                'shop_name' => '李沙公馆官方旗舰店',
                'brand'     => '李沙公馆',
                'state'     => 0,
                'added_at'  => '',
            ],

            [
                'id'        => 8,
                'name'      => '实木框架乳胶沙发 茶几电视柜组合',
                'norms'     => '长120*宽60*高41cm',
                'category'  => '布艺沙发',
                'price'     => 3680000,
                'shop_name' => '饭爱家具官方旗舰店',
                'brand'     => '饭爱家具',
                'state'     => 1,
                'added_at'  => '2019-10-17 12:11:19',
            ],

            [
                'id'        => 9,
                'name'      => '实木新中式茶桌椅组合茶桌套',
                'norms'     => '长200*宽90*高60cm',
                'category'  => '茶台',
                'price'     => 1988000,
                'shop_name' => '偶堂家私官方旗舰店',
                'brand'     => '偶堂家私',
                'state'     => 1,
                'added_at'  => '2019-10-17 12:11:19',
            ],


            [
                'id'        => 10,
                'name'      => '新中式功夫茶几桌 原木大板客厅禅意泡茶桌',
                'norms'     => '长180*宽70*高55cm',
                'category'  => '茶台',
                'price'     => 1580000,
                'shop_name' => '甜梦官方旗舰店',
                'brand'     => '甜梦',
                'state'     => 1,
                'added_at'  => '2019-11-03 02:11:19',
            ],


//            [
//                'id'        => 11,
//                'name'      => '现代简约客厅茶几',
//                'norms'     => '长120*宽60*高41cm',
//                'category'  => '茶几',
//                'price'     => 4299000,
//                'shop_name' => 'AiW官方旗舰店',
//                'brand'     => 'AiW',
//                'state'     => 1,
//                'added_at'  => '2019-10-17 12:11:19',
//            ],
//
//
//            [
//                'id'        => 12,
//                'name'      => '现代简约客厅茶几',
//                'norms'     => '长120*宽60*高41cm',
//                'category'  => '茶几',
//                'price'     => 4299000,
//                'shop_name' => 'AiW官方旗舰店',
//                'brand'     => 'AiW',
//                'state'     => 1,
//                'added_at'  => '2019-10-17 12:11:19',
//            ],
//
//
//            [
//                'id'        => 13,
//                'name'      => '现代简约客厅茶几',
//                'norms'     => '长120*宽60*高41cm',
//                'category'  => '茶几',
//                'price'     => 4299000,
//                'shop_name' => 'AiW官方旗舰店',
//                'brand'     => 'AiW',
//                'state'     => 1,
//                'added_at'  => '2019-10-17 12:11:19',
//            ],
//
//
//            [
//                'id'        => 14,
//                'name'      => '现代简约客厅茶几',
//                'norms'     => '长120*宽60*高41cm',
//                'category'  => '茶几',
//                'price'     => 4299000,
//                'shop_name' => 'AiW官方旗舰店',
//                'brand'     => 'AiW',
//                'state'     => 1,
//                'added_at'  => '2019-10-17 12:11:19',
//            ],
//
//
//            [
//                'id'        => 15,
//                'name'      => '现代简约客厅茶几',
//                'norms'     => '长120*宽60*高41cm',
//                'category'  => '茶几',
//                'price'     => 4299000,
//                'shop_name' => 'AiW官方旗舰店',
//                'brand'     => 'AiW',
//                'state'     => 1,
//                'added_at'  => '2019-10-17 12:11:19',
//            ],
//
//            [
//                'id'        => 16,
//                'name'      => '现代简约客厅茶几',
//                'norms'     => '长120*宽60*高41cm',
//                'category'  => '茶几',
//                'price'     => 4299000,
//                'shop_name' => 'AiW官方旗舰店',
//                'brand'     => 'AiW',
//                'state'     => 1,
//                'added_at'  => '2019-10-17 12:11:19',
//            ],
//
//            [
//                'id'        => 17,
//                'name'      => '现代简约客厅茶几',
//                'norms'     => '长120*宽60*高41cm',
//                'category'  => '茶几',
//                'price'     => 4299000,
//                'shop_name' => 'AiW官方旗舰店',
//                'brand'     => 'AiW',
//                'state'     => 1,
//                'added_at'  => '2019-10-17 12:11:19',
//            ],
//
//
//            [
//                'id'        => 18,
//                'name'      => '现代简约客厅茶几',
//                'norms'     => '长120*宽60*高41cm',
//                'category'  => '茶几',
//                'price'     => 4299000,
//                'shop_name' => 'AiW官方旗舰店',
//                'brand'     => 'AiW',
//                'state'     => 1,
//                'added_at'  => '2019-10-17 12:11:19',
//            ],
//


        ]);
    }

}
