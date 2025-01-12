## 機能一覧

### 1. タスク管理機能

- **タスクの作成**

  - タスクは以下の属性を持つ：
    - タイトル
    - 期限日
    - 状態（「未着手」「着手中」「完了」の 3 種類）

- **タスクの一覧表示**

- **タスクの編集**

  - 編集可能な項目：
    - タイトル
    - 期限日
    - 状態

- **タスクの削除**

---

### 2. フォルダ管理機能

- **フォルダの作成**

- **フォルダの一覧表示**

- **フォルダの編集**

  - 編集可能な項目：
    - タイトル

- **フォルダの削除**

---

### 3. ユーザー管理機能

- **アカウント作成**

- **ログイン・ログアウト**

- **ログイン後の操作**

  - 自分のフォルダおよびタスクのみを閲覧・編集・削除できる。

- **パスワード再登録**
  - ユーザーがパスワードを忘れた場合に再登録できる。

---

### 4. セキュリティ機能

- **ユーザーデータの保護**

  - 各ユーザーのデータは他のユーザーから見えないようにする。

- **認証機能**

  - ログイン必須の機能については認証を求める。

- **本人確認**
  - パスワード再登録時には本人確認を行う。

## 環境構築手順

### ディレクトリの作成

1. 各端末の作業用のディレクトリに移動
2. laravel-todo というディレクトを作成

```bash
mkdir laravel-todo
```

### Docker

1. larave-todo 直下に docker-compose.yml を作成

```bash
cd laravel-todo && touch docker-compose.yml
```

docker-compose.yml

```docker-compose.yml
version: "3"
services:
  db:
    platform: linux/amd64
    image: mysql:5.7.36
    container_name: "mysql_test"
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: todolist
      MYSQL_USER: admin
      MYSQL_PASSWORD: secret
      TZ: "Asia/Tokyo"
    # ポートフォワードの指定（ホスト側ポート：コンテナ側ポート）
    ports:
      - 3306:3306
    # コマンドの指定
    command: mysqld --character-set-server=utf8mb4 --collation-server=utf8mb4_unicode_ci
    # 名前付きボリュームを設定する（名前付きボリューム:コンテナ側ボリュームの場所）
    volumes:
      - db_data_test:/var/lib/mysql
      - db_my.cnf_test:/etc/mysql/conf.d/my.cnf
      - db_sql_test:/docker-entrypoint-initdb.d

  php:
    build: ./docker/php
    container_name: "php-fpm"
    # ボリュームを設定する（ホスト側ディレクトリ:コンテナ側ボリュームの場所）
    volumes:
      - ./src:/var/www

  nginx:
    image: nginx:latest
    container_name: "nginx_test"
    # ポートフォワードの指定（ホスト側ポート：コンテナ側ポート）
    ports:
      - 80:80
    # ボリュームを設定する（ホスト側ディレクトリ:コンテナ側ボリュームの場所）
    volumes:
      - ./src:/var/www
      - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
    # サービスの依存関係を指定（nginxをphpに依存させる）
    depends_on:
      - php

  phpmyadmin:
    image: phpmyadmin/phpmyadmin:latest
    container_name: "phpmyadmin_test"
    environment:
      - PMA_ARBITRARY=1 # サーバ設定：サーバーをローカル以外も指定
      - PMA_HOST=db # ホスト設定：dbを指定
      - PMA_USER=root # 初期ユーザー設定：adminを指定
      - PMA_PASSWORD=root # 初期PW設定：secretを指定
    # db（サービス名）とのリンクを設定する
    links:
      - db
    # ポートフォワードの指定（ホスト側ポート：コンテナ側ポート）
    ports:
      - 8080:80
    # ボリュームを設定する（ホスト側ディレクトリ:コンテナ側ボリュームの場所）
    volumes:
      - ./phpmyadmin/sessions:/sessions

  node:
    image: node:14.18-alpine
    container_name: "node14.18-alpine"
    # コンテナ内の標準出力とホストの出力を設定：trueを指定
    tty: true
    # ボリュームを設定する（ホスト側ディレクトリ:コンテナ側ボリュームの場所）
    volumes:
      - ./src:/var/www
    # コンテナ起動後のカレントディレクトリを設定
    working_dir: /var/www

  mail:
    image: mailhog/mailhog
    container_name: "mailhog"
    # ポートフォワードの指定（ホスト側ポート：コンテナ側ポート）
    ports:
      - 8025:8025

# サービスレベルで名前付きボリュームを命名する
volumes:
  db_data_test:
  db_my.cnf_test:
  db_sql_test:

```

2. docker と src ディレクトリを作成

```bash
mkdir docker && mkdir src
```

3. docker ディレクト内に php と nginx ディレクトリを作成

```bash
cd docker && mkdir php && mkdir nginx
```

4. php ディレクト内に Dockerfile php.ini を作成

```bash
cd ../php && touch Dockerfile && touch php.ini
```

```Dockerfile
# Dockerimage の指定
FROM php:8.1-fpm
COPY php.ini /usr/local/etc/php/

# Package & Library install
RUN apt-get update \
    && apt-get install -y zlib1g-dev mariadb-client vim libzip-dev \
    && docker-php-ext-install zip pdo_mysql

# Composer install
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

# WorkDir Path setting
WORKDIR /var/www

# Laravel Package install
RUN composer global require "laravel/installer"
```

```php.ini
; 日付設定
[Date]
date.timezone = "Asia/Tokyo"
; 文字＆言語設定
[mbstring]
mbstring.internal_encoding = "UTF-8"
mbstring.language = "Japanese"
```

5. nginx ディレクトリ内に default.conf を作成

```bash
cd ../nginx && touch default.conf
```

```default.conf
server {
    listen 80;
    index index.php index.html;

    root /var/www/public;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass php:9000;
        fastcgi_index index.php;
        include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_param PATH_INFO $fastcgi_path_info;
    }
}
```

6. Docker を起動

```bash
cd ../../ && docker-compose up -d
```

### Laravel プロジェクトの作成

1. php コンテナに移動

```bash
docker-compose exec php bash
```

2. Laravel をインストール

```bash
composer create-project "laravel/laravel=10.*" .
```

3. .env の内容を変更

```.env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=todolist
DB_USERNAME=root
DB_PASSWORD=root
```

4. マイグレーションの実行

```bash
php artisan migrate
```
