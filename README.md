Разворачивание сайта "с нуля"
=============================

Создать конфигурационные файлы
--------------------------------------------------

Для nginx. Скопировать и подкорректировать потом
```
su
cp ./conf/nginx/spobuhov.conf.dist /etc/nginx/conf.d/spobuhov.conf
touch /var/log/spobuhov.log
chown nginx:webservice /var/log/spobuhov.log
chmod g+w /var/log/spobuhov.log
```

Создать базу данных
-------------------

```
CREATE DATABASE `spobuhovdb` CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE USER 'spobuhov_user'@'localhost' IDENTIFIED BY 'password';
GRANT ALTER,CREATE,CREATE TEMPORARY TABLES,DELETE,DROP,INDEX,INSERT,LOCK TABLES,SELECT,UPDATE ON spobuhovdb.* TO 'spobuhov_user'@'localhost';
FLUSH PRIVILEGES;
```

Создание каталогов
------------------

Создать каталог в подкаталоге, обрабатывающий веб-сервером
```
mkdir /web/spobuhov/
chown -R :webservice /web/spobuhov/
chown -R :webservice /home/develop/spobuhov/
chmod -R g+w /web/spobuhov/
```


Тема и плагин для сайта
--------------
https://wordpress.org/themes/spacious/

```
ln -s /home/develop/spobuhov/wp-content/themes/spacious /web/spobuhov/wp-content/themes/spacious
ln -s /home/develop/spobuhov/wp-content/plugins/people-reception /web/spobuhov/wp-content/plugins/people-reception
```


Дополнительно
-------------

Если переносим откуда-то, то вот распаковка бекапа
```
gunzip < spobuhov_arc.sql.gz | mysql -uspobuhov_user -p spobuhovdb
```

Для распаковки нормально бекапа, может потребоваться увеличить лимиты патяти тут /etc/my.cnf
```
[mysqld]
max_allowed_packet=128M
innodb_log_file_size = 100M
```

Стуктура
=========

Сущности
--------

* page - Статичная страница (заголовок, текст-разметка);
* Рубрика (заголовок)
* post - Публикация (заголовок, дата, авторство, текст-разметка, иллюстрации, принадлежность к рубрике);
* appeal - Обращение (тема, дата обращения, статус, дата последнего обновления, текст обращения, текст запросов, текст ответов, скан-копии документов);
* book - Книга/брошюра (заголовок, редакция, краткое описание, иллюстрации, файл с книгой);
* bill - Законопроект (название, дата внесения в ГД, краткое описание, ссылка на полную версию на интернет-сайте duma.gov.ru);
* transcript - Текст стенограммы (тема выступления, дата выступления, текст выступления);
* voting - Голосование (тема голосования, дата голосования, как голосовал, ссылка на полное описание голосования на интернет-сайте duma.gov.ru).