# Установка

```
composer require mr-vaco/nova-statuses-manager
```

```
php artisan migrate --path=vendor/mr-vaco/nova-statuses-manager/database/migrations

php artisan db:seed --class=\\MrVaco\\NovaStatusesManager\\Seeders\\StatusesSeeder

php artisan db:seed --class=\\MrVaco\\NovaStatusesManager\\Seeders\\StatusesListSeeder
```
