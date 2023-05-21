<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>



## class YandexMusicParser:

- Получает данные треков и сохраняет их в БД (название трека, продолжительность и с какого альбома трек);
- Получает данные артиста и сохраняет их в БД (имя артиста, количество подписчиков, количество слушателей за месяц, количество альбомов и информацию об артисте);


- Php 8.1 
- Laravel 
- Mysql
- Docker
- Docker-compose
- Composer

## Как пользоваться:

1. Склонируйте репозиторий с помощью команды:
```
git clone https://github.com/theNorth97/YandexMusicParser.git
 ```

2. Перейдите в папку проекта:
 ```
 cd ./YandexMusicParser
```
3. Напишите в .env данные для входа в БД:
```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=ваши данные
DB_USERNAME=ваши данные
DB_PASSWORD=ваши данные
```

4. Установите зависимости:
   ```composer install```

5. Создайте контейнеры:
   ```docker compose build```

6. Запустите их:
   ```docker compose up -d```

7. Проверьте созданные docker-контейнеры:
   ```docker ps```

8. Выполните миграции:
```
php artisan migrate   
 ```
или
```
docker-compose exec app php artisan migrate
 ```

9. Далее вы можете пользотваться сервисом :

```
В контроллере YandexMusicParserController.php, в методе parseAll() можете вставлять ссылку на артиста , 
например :  https://music.yandex.ru/artist/36800 и получать парсинг данного артиста .
```

