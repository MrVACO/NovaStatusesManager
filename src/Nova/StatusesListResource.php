<?php

declare(strict_types = 1);

namespace MrVaco\NovaStatusesManager\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;
use MrVaco\NovaStatusesManager\Models\StatusesList;

class StatusesListResource extends Resource
{
    public static $displayInNavigation = false;
    
    public static string $model = StatusesList::class;
    
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
            
            Text::make('Used in statuses', function($value)
            {
                $lists = $value->statuses;
                $arr   = [];
                
                foreach ($lists as $list)
                {
                    $arr[] = '<span class="inline-flex whitespace-nowrap px-3 py-1 mx-1 my-1 rounded-full uppercase text-xs font-bold text-white dark:text-gray-900" style="background: ' . $list->color . '">' . $list->name . '</span>';
                }
                
                return implode($arr);
            })->asHtml()->onlyOnIndex(),
        ];
    }
}
