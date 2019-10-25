# SnowTricks
![alt text](assets/img/snowtricks_preview_index.png)

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/697b6e21b6cc40439af6c5eb9a0ba816)](https://www.codacy.com/manual/bpel/snowtricks?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=bpel/snowtricks&amp;utm_campaign=Badge_Grade) 

## About the project

Development of a community website for sharing snowboard figures using the Symfony framework.

### Prerequisites
```
PHP >= 7.2.10
MySQL >= 8.0.17
Symfony = 4.3
Twig >= 1.5
Composer >= 1.9
Yarn >= 1.16
```

### Download or clone the repository


```
Git clone https://github.com/bpel/snowtricks.git
```

## Download dependencies

```
// from /snowtricks/
composer update
```


## Config

 `.env`

   ```
   // dev or prod
   APP_ENV=prod
   // define db_user & db_password
   DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/snowtricks
   // for maildev : smtp://localhost:1025
   MAILER_URL=smtp://localhost:1025
   ```

### Create database

```
// from /snowtricks/
// 1) create database (need .env config)
php bin/console doctrine:database:create
// 2) Load schema
php bin/console doctrine:schema:update --force
OR
php bin/console make:migration
php bin/console doctrine:migrations:migrate
// 3) Load fixtures
php bin/console doctrine:fixtures:load
```
## Deployment

```
yarn encore production

php bin/console server:run
```

### Default user

username | email | password
---- | ----- | --------
Demo Test| demo@test.fr | demo