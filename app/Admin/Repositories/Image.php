<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Grid;
use Dcat\Admin\Repositories\Repository;
use Faker\Factory;

class Image extends Repository
{
    protected $images = [
        'https://cdn.learnku.com/uploads/images/202008/13/38389/9wQkrPvdVv.jpg!large',
        'https://cdn.learnku.com/uploads/images/202008/13/38389/Cctas6kgjU.jpg!large',
        'https://cdn.learnku.com/uploads/images/202008/13/38389/lsIZCz2FzQ.jpg!large',
        'https://cdn.learnku.com/uploads/images/202008/13/38389/pCxWhPgBve.jpg!large',
        'https://cdn.learnku.com/uploads/images/202008/13/38389/MtyxixZyDv.jpg!large',
        'https://cdn.learnku.com/uploads/images/202008/13/38389/R3kTazN5kn.jpg!large',
        'https://cdn.learnku.com/uploads/images/202008/13/38389/pP2ZhkMNq6.jpg!large',
        'https://cdn.learnku.com/uploads/images/202008/13/38389/6nAvsg9BXw.jpg!large',
        'https://cdn.learnku.com/uploads/images/202008/13/38389/rhtzc78DSY.jpg!large',
        'https://cdn.learnku.com/uploads/images/202008/13/38389/gcIL1qWaDu.jpg!large',
        'https://cdn.learnku.com/uploads/images/202008/13/38389/pZ1wS4QbIb.jpg!large',
        'https://cdn.learnku.com/uploads/images/202008/13/38389/IkgjeN0iu1.jpg!large',
        'https://cdn.learnku.com/uploads/images/202008/13/38389/sZ5tloNzHi.jpg!large',
        'https://cdn.learnku.com/uploads/images/202008/13/38389/kNMPe68NAA.jpg!large',
        'https://cdn.learnku.com/uploads/images/202008/13/38389/2SRvmClazu.jpg!large',
        'https://cdn.learnku.com/uploads/images/202008/13/38389/V2qfcLFXTg.jpg!large',
        'https://cdn.learnku.com/uploads/images/202008/13/38389/bJTfJY3Zad.jpg!large',
        'https://cdn.learnku.com/uploads/images/202008/13/38389/2rHDpPs6GF.jpg!large',
        'https://cdn.learnku.com/uploads/images/202008/13/38389/NkkaEADsIi.jpg!large',
        'https://cdn.learnku.com/uploads/images/202008/13/38389/SuDPRIEywe.jpg!large',
    ];

    public function get(Grid\Model $model)
    {
        $total = 20;

        $data = $this->faker();

        return $model->makePaginator($total, $data);
    }

    protected function faker()
    {
        $data = [];

        $faker = Factory::create();

        for ($i = 1; $i <= 20; $i++) {
            $data[] = [
                'id' => $i,
                'name' => $faker->name,
//                'url' => url("img/custom/{$i}.jpg"),
                'url' => $this->images[$i - 1],
                'comment' => $faker->text(20),
                'created_at' => $faker->date('Y-m-d H:i:s'),
                'updated_at' => $faker->date('Y-m-d H:i:s'),
            ];
        }

        return $data;
    }
}
