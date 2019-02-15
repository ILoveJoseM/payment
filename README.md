laravel-admin extension
======

# 基于laravel的支付管理

!> 暂时只支持微信公众号支付

## 安装

``
composer require "jose-chan/payment"
``

## 数据库导入

#### 表结构导入

``
php artisan migrate --path=vendor/jose-chan/payment/database/migrations
``

#### 数据导入

- 先更新Composer自动加载器

``
composer dump-autoload
``

- 在DatabaseSeeder中引入Seeder类

```php

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

         $this->call([
             PaymentTypeConfigSeeder::class,
             PaymentTypeSeeder::class,
             MenuSeeder::class,
         ]);
    }
```

- 执行填充数据库

``
php artisan db:seed
``

## 后台组件加载配置

#### 引入PaymentServiceProvider

config/app.php

````php

return [
    
    //……其他配置项省略

    'providers' => [
    
        //……其他配置项省略
        
        /**
         * laravel-admin providers
         */
        \JoseChan\Payment\PaymentServiceProvider::class,
        
    ]
]

````

#### 加载extensions

config/admin.php

````php

return [

    //……其他配置项省略
    
    /*
     * Settings for extensions.
     */
    'extensions' => [
        "payment"=>[
            "enable" => true,
        ]
    ],
];

````

## 支付api加载

#### 引入ApiServiceProvider

````php

return [
    
    //……其他配置项省略

    'providers' => [
    
        //……其他配置项省略
        
        /**
         * laravel-admin providers
         */
        \JoseChan\Payment\ApiServiceProvider::class,
        
    ]
]

````
