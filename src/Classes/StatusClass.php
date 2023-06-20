<?php

declare(strict_types = 1);

namespace MrVaco\NovaStatusesManager\Classes;

use MrVaco\NovaStatusesManager\Models\Statuses;

class StatusClass
{
    public static function DEFAULT_ID(): int
    {
        return Statuses::query()->first()->id;
    }
    
    public static function ACTIVE(): Statuses
    {
        return Statuses::isActive()->first();
    }
    
    public static function DISABLED(): Statuses
    {
        return Statuses::isDisabled()->first();
    }
    
    public static function DRAFT(): Statuses
    {
        return Statuses::isDraft()->first();
    }
    
    public static function BY_ID(int $id): Statuses
    {
        return Statuses::query()->find($id);
    }
    
    /**
     * @param  string  $code
     * @param  bool    $swapKeyValue
     *
     * @return array
     */
    public static function LIST(string $code, bool $swapKeyValue = false): array
    {
        $data = Statuses::query()->whereHas('lists', function($query) use ($code)
        {
            $query->where('slug', 'like', $code . '%');
        })->get();
        
        if ($swapKeyValue)
            return $data->pluck('id', 'name')->toArray();
        
        return $data->pluck('name', 'id')->toArray();
    }
}
