# QueueCommand
https://img.shields.io/badge/PHP%20VERSION-%3E%3D8.1.*-succes
https://img.shields.io/badge/Symfony-%3E%3D6.1-succes

Est une Symfony\Component\Console\Command\Command enrichie d'une file d'attente de commande. 
Les arguments InputInterface de la file d'attente sont transmis à la commande suivante par défaut.

## Installation 

### Dev
```php
composer require inwebo/queue-command
```

### Prod 
```php
composer require inwebo/queue-command  --no-dev
```

## Tests

```php
./vendor/bin/phpunit --testdox tests
```
