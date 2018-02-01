* http://www.hsuchihyung.cn/2016/10/08/laravel-kai-fa-api/
* http://php.net/manual/en/language.oop5.changelog.php
* http://php.net/manual/zh/migration70.new-features.php

* nginx conf

```
server {
    listen       80;
    server_name  laravelapijasong.vm;
    access_log  /var/log/nginx/laravelapijasong.vm.access.log;
    error_log   /var/log/nginx/laravelapijasong.vm.error.log;
    root /mnt/hgfs/YunDun/jason-gao/laravelapi/public;
    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass   127.0.0.1:9007;
        fastcgi_index  index.php;
        include fastcgi.conf;
        include fastcgi_params;
    }
}

```    