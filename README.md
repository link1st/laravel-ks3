# laravel-sk3
金山云存储

## 安装
加载包

`"link1st/laravel-ks3": "dev-master"`

或

`composer require link1st/laravel-ks3`

在配置文件中添加 **config/app.php**

```php
    'providers' => [
        /**
         * 添加供应商
         */
        link1st\Ks3\Ks3ServiceProvider::class,
    ],
    'aliases' => [
         /**
          * 添加别名
          */
        'Ks3' => link1st\Ks3\Facades\Ks3::class,
    ],
```

生成配置文件

`php artisan vendor:publish`

设置金山云的参数 **config/ks3.php**


## 使用
- - -
### 上传图片 获取图片url 失败返回false 
- `$file_path` 本地文件路径
- `$new_file_name` 上传以后新的文件名
`\Ks3::putObjectByFile($file_path,$new_file_name);`


