* http://www.hsuchihyung.cn/2016/10/08/laravel-kai-fa-api/

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
    * php721 artisan tinker 进入填充数据的一个shell环境
    * 填充数据
    ```
    namespace App;
    factory(Lesson::class,60)->create(); 
    
    
     namespace App;
     factory(User::class,60)->create();
     
    ```
    
* 开始编写api 
   * routes/api.php添加
   ```
Route::group(['prefix' => 'api/v1'], function () {  
    Route::resource('lesson', 'LessonController');
});

```
* 查看已经注册的路由
* php721 artisan route:list

```
+--------+-----------+-----------------------------+----------------+-----------------------------------------------+--------------+
| Domain | Method    | URI                         | Name           | Action                                        | Middleware   |
+--------+-----------+-----------------------------+----------------+-----------------------------------------------+--------------+
|        | GET|HEAD  | /                           |                | Closure                                       | web          |
|        | GET|HEAD  | api/user                    |                | Closure                                       | api,auth:api |
|        | GET|HEAD  | api/v4/lesson               | lesson.index   | App\Http\Controllers\LessonController@index   | api          |
|        | POST      | api/v4/lesson               | lesson.store   | App\Http\Controllers\LessonController@store   | api          |
|        | GET|HEAD  | api/v4/lesson/create        | lesson.create  | App\Http\Controllers\LessonController@create  | api          |
|        | GET|HEAD  | api/v4/lesson/{lesson}      | lesson.show    | App\Http\Controllers\LessonController@show    | api          |
|        | PUT|PATCH | api/v4/lesson/{lesson}      | lesson.update  | App\Http\Controllers\LessonController@update  | api          |
|        | DELETE    | api/v4/lesson/{lesson}      | lesson.destroy | App\Http\Controllers\LessonController@destroy | api          |
|        | GET|HEAD  | api/v4/lesson/{lesson}/edit | lesson.edit    | App\Http\Controllers\LessonController@edit    | api          |
+--------+-----------+-----------------------------+----------------+-----------------------------------------------+--------------+
```
* 默认有个/api前缀，https://d.laravel-china.org/docs/5.5/routing#basic-routing


* 安装laravel help相关插件
* http://mokeee.com/2017/11/02/phpstorm-laravel/
* https://laravel-china.org/topics/2532/extended-recommendation-laravel-ide-helper-efficient-ide-smart-tips-plugin
* https://github.com/barryvdh/laravel-ide-helper
* php721 /usr/local/bin/composer require --dev barryvdh/laravel-ide-helper v2.4.1
* php721 artisan ide-helper:generate
* 根目录会生成一个id_helper.php,最好加到.gitignore里
* php721 artisan ide-helper:models
```
Do you want to overwrite the existing model files? Choose no to write to _ide_helper_models.php instead? (Yes/No):  (yes/no) [no]:
 > yes

Written new phpDocBlock to /mnt/hgfs/YunDun/jason-gao/laravelapi/app/Lesson.php
Written new phpDocBlock to /mnt/hgfs/YunDun/jason-gao/laravelapi/app/User.php

```
* php721 artisan ide-helper:meta
* 根目录生成.phpstorm.meta.php，加到.gitignore忽略里


* 控制器
* LessonController.php
```
    public function index(){
        return Lesson::all();//bad
    }

    public function show($id){
        $lesson = Lesson::findOrFail($id);
        return $lesson;
    }
    
```

* 访问 http://laravelapijasong.vm/api/v4/lesson
* 已经可以正常返回一个json数据了，说明api服务已经通了
* 上面只是流程通了，需要进一步优化

* 更优雅的错误提示
* php721 artisan make:controller ApiController

* 自带auth系统
* php721 artisan make:auth
* http://laravelapijasong.vm/login
* http://laravelapijasong.vm/password/reset
* http://laravelapijasong.vm/register


* api保存课程接口
* api/v4/lesson post
* 如果要用create方法，需要在对应的模型里添加$fillable属性







