![Mr.VACO Statuses Manager](https://preview.dragon-code.pro/Mr.VACO/Statuses%20Manager.svg?pretty-title=0&github%5Brepository%5D=MrVACO%2FNovaStatusesManager&mode=auto)

Plugin/Module/Package... Code - Unification of statuses for further use in their packages.

> [RU readme](https://github.com/MrVACO/NovaStatusesManager/blob/main/README.ru.md)

# Installation

1. ```composer require mr-vaco/nova-statuses-manager```
2. ```php artisan migrate --path=vendor/mr-vaco/nova-statuses-manager/database/migrations```
3. ```php artisan db:seed --class=\\MrVaco\\NovaStatusesManager\\Seeders\\StatusesSeeder```
4. ```php artisan db:seed --class=\\MrVaco\\NovaStatusesManager\\Seeders\\StatusesListSeeder```

# Using

- ```StatusClass::LIST('this_code_from_list')``` - Getting a list of statuses by "code" sheet parameter - by default: full / base / short

- ```StatusClass::DEFAULT_ID()``` - object - get the first by ID status

```php
StatusClass::DEFAULT_ID()->id
StatusClass::DEFAULT_ID()->name
StatusClass::DEFAULT_ID()->color
```

- ```StatusClass::ACTIVE()``` - object - get status "active" (default)

```php
StatusClass::ACTIVE()->id
StatusClass::ACTIVE()->name
StatusClass::ACTIVE()->color
```

- ```StatusClass::DISABLED()``` - object - get "disabled" status (default)

```php
StatusClass::DISABLED()->id
StatusClass::DISABLED()->name
StatusClass::DISABLED()->color
```

- ```StatusClass::DRAFT()``` - object - get "draft" status (default)

```php
StatusClass::DRAFT()->id
StatusClass::DRAFT()->name
StatusClass::DRAFT()->color
```

- ```StatusClass::BY_ID($id)``` - object - get status by ID

```php
StatusClass::BY_ID($id)->name
StatusClass::BY_ID($id)->color
```

### Use in resources Laravel Nova:

```php
use MrVaco\NovaStatusesManager\Classes\StatusClass;
use MrVaco\NovaStatusesManager\Fields\Status;

public function fields(NovaRequest $request): array
{
    return [
        Status::make(__('Status'), 'status')
            ->options(StatusClass::LIST('short'))
            ->default(StatusClass::ACTIVE()->id),
    ];
}
```
