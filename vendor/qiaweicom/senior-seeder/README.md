a composer about seeder  for  Laravel 5
======



## Install 

```
composer require qiaweicom/senior-seeder 

```




## Usage

如果你是使用的laravel 5.5以上版本可以直接利用composer安装即可。

```
composer require qiaweicom/senior-seeder 
```

如果使用laravel5.4及以下版本需要你手动设置laravel到服务提供列表中。



找到 `config/app.php` 配置文件中，key为 `providers` 的数组，在数组中添加服务提供者。

```php
    'providers' => [
        // ...
        QiaWeiCom\SeniorSeeder\Providers\SeniorSeederServiceProvider::class,
    ]
```



运行 `php artisan vendor:publish` 命令，发布配置文件到你的项目中。

配置文件 `config/senoir_seeder.php` 一般不需要修改。


