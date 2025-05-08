### Команда для создания и подключения к БД ###
#### Если ваши данные от БД отличаются, то замените их своими ####
```
# 1 раз при первом запуске
echo "DB_HOST=localhost" >> .env
echo "DB_USER=root" >> .env
echo "DB_PASS=root" >> .env
echo "DB_NAME=Collection" >> .env
```

### Команда для заполнения базы данных ###
```
php config/seeds.php
```