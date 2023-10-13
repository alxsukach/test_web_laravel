## Инструкция по запуску проекта с использованием Laravel Sail и Docker WSL2
1. Выполнить [инструкцию по установке WSL2 и Docker](https://blog.devgenius.io/kickstart-your-laravel-web-app-using-laravel-sail-30276265e588).
А именно: **Install WSL 2**, **Install Docker**
2. Выполнить копанду: ```wsl --setdefault DISTRO-NAME``` e.g. DISTRO-NAME = Ubuntu-22.04
3. Установить PHP и Composer

```wsl -u root```
```
apt update
apt install php-cli php-xml php-dom php-curl unzip
cd ~
curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
HASH=`curl -sS https://composer.github.io/installer.sig`
echo $HASH
php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
```
4. Скопировать и запустить проект

```wsl```
```
cd ~
git clone https://github.com/alxsukach/test_web_laravel.git
composer install
./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```
Перед запуском контейнеров ```./vendor/bin/sail up -d``` необходимо установить настройки окружения в .env

### Стек:
 - PHP 8.2
- MySQL 8
- Laravel 10
- Bootstrap 5
- Laravel Livewire 3

