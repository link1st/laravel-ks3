# laravel-sk3
金山云存储

## 安装
加载包

`"link1st/laravel-sk3": "dev-master"`

或

`composer require ink1st/laravel-easemob`

在配置文件中添加 **config/app.php**

```php
    'providers' => [
        /**
         * 添加供应商
         */
        link1st\Easemob\EasemobServiceProvider::class,
    ],
    'aliases' => [
         /**
          * 添加别名
          */
        'Sk3' => link1st\Easemob\Facades\Easemob::class,
    ],
```

生成配置文件

`php artisan vendor:publish`

设置环信的参数 **config/easemob.php**


## 使用
- - -
### 获取token
`\Easemob::getToken();`

