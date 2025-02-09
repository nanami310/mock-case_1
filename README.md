# もぎたて

## 環境構築
1. git clone git@github.com:coachtech-material/laravel-docker-template.git
2. DockerDesktopアプリを立ち上げる
3. docker-compose up -d --build
4. docker-compose exec php bash
5. composer install
6. cp .env.example .env
7. envに以下の環境変数を追加
``` text
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```
8. マイグレーションの実行
``` bash
php artisan migrate
```

## 使用技術（実行環境）
- PHP 7.4.9
- Laravel 8.83.8
- MySQL 8.0.26

## ER図
![Screenshot of a comment on a GitHub issue showing an image, added in the Markdown, of an Octocat smiling and raising a tentacle.](/index.drawio.png)

## URL
- 開発環境：http://localhost/products
- phpMyAdmin:：http://localhost:8080/
