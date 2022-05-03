#Task Api

###Installation

This project using docker. Firstly install docker, then go project folder.

And run command:

```
docker-compose up -d

docker exec -it task-api sh

composer install
```

###Migration

Run doctrine migration commands in docker container.

```
cd /var/wwww

php bin/console make:migration

php bin/console doctrine:migrations:migrate
```

###Test

Run unit test in docker container. Firstly install doctrine fixtures data

```
cd /var/www

php bin/console doctrine:fixtures:load

cd /var/www/tests

php bin/phpunit tests/Api/ApiTest.php
```

Test In:

ROLE_USER account login

ROLE_USER lists tasks

ROLE_USER create task

ROLE_USER invalid close task


ROLE_EXPERT account login

ROLE_EXPERT lists tasks

ROLE_EXPERT create task

ROLE_EXPERT close task


