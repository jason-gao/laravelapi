* laravel 5.5.0
* php721是我的php7.2.1可执行行文件，指定Php7.2.1去安装laravel

```
php721 /usr/local/bin/composer create-project --prefer-dist laravel/laravel=5.5.28 laravelapi
php721 artisan serve
ab -c10 -n100  http://127.0.0.1:8000/
wrk -t12 -c15 -d5s http://127.0.0.1:8000/

```

* 配置.env
 * DB_DATABASE=laravelapi
 * DB_CONNECTION=mysql此处name需要和config/database.php中connections中的key一致，如果有多个数据库，定义多个映射

* 创建migrate
    * php721 artisan make:migration create_lessons_table --create=lessons
    * 生成database/migrations/2018_02_01_092222_create_lessons_table.php
* 创建Model
    * php721 artisan make:model Lesson
    * 生成app/Lesson.php
* 创建控制器
    * php721 artisan make:controller LessonController
    * 生成app/Http/Controllers/LessonController.php

* 编辑migrate
```
public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('body');
            $table->boolean('free');
            $table->timestamps();
        });
    }
    
```

* 数据迁移：php721 artisan migrate
    * error 1071 Specified key was too lo  
              ng; max key length is 767 bytes (SQL: alter table `users` add unique `users_emai  
              l_unique`(`email`)
    * 解决办法：https://stackoverflow.com/questions/1814532/1071-specified-key-was-too-long-max-key-length-is-767-bytes
    * http://blog.xieyc.com/utf8-and-utf8mb4/
    * 由于目前测试环境数据库版本是5.6，所以将数据库默认编码改为utf8mb4->utf8,如果是5.7最好还是用utf8mb4,可以直接存emoj表情
    * php721 artisan migrate --path=xx 只迁移migrations/xx目录下的数据表

* 添加database/factories/LessonFactory.php
    * php721 artisan tinker
    * 填充数据
    ```
    namespace App;
    factory(Lesson::class,60)->create(); 
    
    
     namespace App;
     factory(User::class,60)->create();
     
    ```
    
* 开始编写api 
   * 