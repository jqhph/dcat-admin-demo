
<div align="center">

# DCAT-ADMIN GRID-SORTABLE

</div>

这个插件可以帮助你通过拖动数据列表的行来进行排序，前端基于[SortableJS](https://github.com/SortableJS/Sortable), 后端基于[eloquent-sortable](https://github.com/spatie/eloquent-sortable)。


![sortable](https://raw.githubusercontent.com/jqhph/dcat-admin-grid-sortable/docs/img/grid-sortable.png)

## 安装

```shell
composer require dcat-admin-extension/grid-sortable -vvv
```

然后打开`http://yourhost/admin/helpers/extensions`，依次点击`启用`和`导入`。

## 使用

修改模型

```php
<?php

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class MyModel extends Model implements Sortable
{
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];
}
```

在表格中使用

```php
$grid = new Grid(new MyModel());

$grid->sortable();
```

## 翻译

在对应的语言种类文件夹下的`global.php`中可以修改按钮文本，以简体中文为例：翻译文件是`resources/lang/zh-CN.json`
```php
return [
    'fields' => [...],
    'labels' => [
        ...
        'Save order' => '保存排序',
    ],
];
```

License
------------
Licensed under [The MIT License (MIT)](LICENSE).
