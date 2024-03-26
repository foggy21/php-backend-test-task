***

## *Примечание для проверяющего*

*Использованные технологии:*

 - PHP 8.3.3
 - Symfony 6.4
 - Composer 2.7.2
 - MySQL 8.3.0

База данных подключается в файле **.env.local**:

`DATABASE_URL="mysql://username:password@127.0.0.1:3306/databaseName?serverVersion=8.3.0&charset=utf8mb4"`

## *Идея решения задачи распределения*
Идея заключается в использовании жадного алгоритма распределения: самые менее требовательные задачи, у которых меньше всего запросов по процессорам и памяти, идут в обработку в самые мощные машины, у которых больше всего доступно процессоров и памяти.

## Тестирование
Тестовая база данных подключается в файле **.env.test.local**:

    DATABASE_URL="mysql://username:password@127.0.0.1:3306/databaseName?serverVersion=8.3.0&charset=utf8mb4
*P.s. databaseName такое же, как и у БД в проде, доктрина сама добавит суффикс "_test" к имени*

Перед запуском команды

    php bin/phpunit
   
Необходимо выполнить команду загрузку данных в тестовую БД с классов Fixtures:

```
php bin/console --env=test doctrine:fixtures:load
```
