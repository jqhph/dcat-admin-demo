# Dcat Admin

本项目是[Dcat Admin](https://github.com/jqhph/dcat-admin)的DEMO源码，在线预览[点击这里](https://jqhph.github.io/dcat-admin/demo.html)。

## 安装

运行
```shell
composer install
```

安装完之后，复制一份`.env.example`文件并命名为`.env`，然后运行
```shell
php artisan key:generate
```

然后配置好数据库连接信息运行以下命令

> 这里会提示文件夹已存在，忽略即可。

```php
php artisan admin:install
```

最后运行`php artisan serve`。然后打开`http://localhost:8000/admin`即可访问，账号`admin`，密码`admin`。



