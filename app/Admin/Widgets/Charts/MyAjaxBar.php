<?php

namespace App\Admin\Widgets\Charts;

use Illuminate\Http\Request;

class MyAjaxBar extends MyBar
{
    /**
     * 处理请求
     * 如果你的图表类中包含此方法，则可以通过此方法处理前端通过ajax提交的获取图表数据的请求
     *
     * @param Request $request
     * @return mixed|void
     */
    public function handle(Request $request)
    {
        switch ((int) $request->get('option')) {
            case 30:
                // 你的数据查询逻辑
                $data = [
                    [
                        'data' => [44, 55, 41, 64, 22, 43, 21]
                    ],
                    [
                        'data' => [53, 32, 33, 52, 13, 44, 32]
                    ]
                ];
                $categories = [2001, 2002, 2003, 2004, 2005, 2006, 2007];

                break;
            case 28:
                // 你的数据查询逻辑
                $data = [
                    [
                        'data' => [44, 55, 41, 64, 22, 43, 21]
                    ],
                    [
                        'data' => [53, 32, 33, 52, 13, 44, 32]
                    ]
                ];
                $categories = [2001, 2002, 2003, 2004, 2005, 2006, 2007];

                break;
            case 7:
            default:
                // 你的数据查询逻辑
                $data = [
                    [
                        'data' => [44, 55, 41, 64, 22, 43, 21]
                    ],
                    [
                        'data' => [53, 32, 33, 52, 13, 44, 32]
                    ]
                ];
                $categories = [2001, 2002, 2003, 2004, 2005, 2006, 2007];
                break;
        }

        $this->withData($data);
        $this->withCategories($categories);
    }

    /**
     * 这里覆写父类的方法，不再查询数据
     */
    protected function buildData()
    {
    }
}
