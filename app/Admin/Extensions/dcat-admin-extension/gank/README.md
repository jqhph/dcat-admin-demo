Dcat Admin扩展 - 干货集中营
======

这是一个`Dcat Admin`的扩展包，写着玩的。

## 安装

请先确保安装了[Dcat Admin](https://github.com/jqhph/dcat-admin)，执行
```php
composer require dcat-admin-extension/gank
```

最后用浏览器打开`http://localhost:8000/admin/helpers/extensions`找到`gank`这一行，点击`启用`按钮，即可使用。

除了通过界面启用扩展，也可以手动开启扩展：打开`config/admin-extensions.php`(如果文件不存在请手动创建)，加入以下代码：
```php
return [
    'gank' => [
        'enable' => true,
    ],
];
```

## 使用

以上步骤都完成之后刷新页面，就可以看到`干货集中营`的菜单了。
