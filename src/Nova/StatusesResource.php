<?php

declare(strict_types = 1);

namespace MrVaco\NovaStatusesManager\Nova;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Color;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Tag;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;
use MrVaco\NovaStatusesManager\Models\Statuses;

class StatusesResource extends Resource
{
    public static $displayInNavigation = false;
    
    public static $clickAction = 'edit';
    
    public static string $model = Statuses::class;
    
    public static $title = 'name';
    
    public static $search = [
        'id', 'name'
    ];
    
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),
            
            Text::make('Name', 'name')
                ->sortable()
                ->rules('required'),
            
            Color::make('Color', 'color')
                ->required()
                ->default('#000000'),
            
            Boolean::make('Default Active', 'active'),
            Boolean::make('Default Disabled', 'disabled'),
            Boolean::make('Default Draft', 'draft'),
            
            Tag::make('Lists', 'lists', StatusesListResource::class)->preload()->hideFromIndex(),
            Text::make('Lists', function($value)
            {
                $lists = $value->lists;
                $arr   = [];
                
                foreach ($lists as $list)
                {
                    $arr[] = '<span class="inline-flex whitespace-nowrap px-3 py-1 mx-1 my-1 rounded-full uppercase text-xs font-bold bg-primary-50 dark:bg-primary-500 text-primary-600 dark:text-gray-900">' . $list->name . '</span>';
                }
                
                return implode($arr);
            })->asHtml()->onlyOnIndex(),
        ];
    }
    
    public static function redirectAfterCreate(NovaRequest $request, $resource): string
    {
        return '/resources/' . static::uriKey();
    }
    
    public static function redirectAfterDelete(NovaRequest $request): string
    {
        return '/resources/' . static::uriKey();
    }
    
    public static function redirectAfterUpdate(NovaRequest $request, $resource): string
    {
        return '/resources/' . static::uriKey();
    }
}
