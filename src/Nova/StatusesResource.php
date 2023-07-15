<?php

declare(strict_types = 1);

namespace MrVaco\NovaStatusesManager\Nova;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Color;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Tag;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Laravel\Nova\Resource;
use MrVaco\NovaStatusesManager\Fields\Status;
use MrVaco\NovaStatusesManager\Models\Statuses;

class StatusesResource extends Resource
{
    public static $displayInNavigation = false;
    
    public static $clickAction = 'edit';
    
    public static string $model = Statuses::class;
    
    public static function label(): string
    {
        return __('Statuses');
    }
    
    public static function singularLabel(): string
    {
        return __('status');
    }
    
    public static $title = 'name';
    
    public static $search = [
        'id', 'name'
    ];
    
    public function fields(NovaRequest $request): array
    {
        return $this->getFields();
    }
    
    public function fieldsForUpdate(NovaRequest $request): array
    {
        return [
            Panel::make(__('Update :resource: :title', [
                'resource' => __('statusa'),
                'title'    => $this->title()
            ]), $this->getFields())
        ];
    }
    
    public function fieldsForDetail(NovaRequest $request): array
    {
        return [
            Panel::make(__(':resource Details: :title', [
                'resource' => '',
                'title'    => $this->title()
            ]), $this->getFields())
        ];
    }
    
    protected function getFields(): array
    {
        return [
            ID::make()->sortable(),
            
            Status::make(__('Preview'), 'id')
                ->hideWhenCreating()
                ->hideWhenUpdating(),
            
            Text::make(__('Status name'), 'name')
                ->hideFromIndex()
                ->sortable()
                ->rules('required')
                ->width(6)
                ->fullWidth(),
            
            Tag::make(__('Displayed in lists'), 'lists', StatusesListResource::class)
                ->preload()
                ->hideFromIndex()
                ->width(6)
                ->fullWidth(),
            
            Color::make(__('Color'), 'color')
                ->hideFromIndex()
                ->required()
                ->default('#000000')
                ->width(3),
            
            Boolean::make(__('Default Active'), 'active')->width(3),
            Boolean::make(__('Default Disabled'), 'disabled')->width(3),
            Boolean::make(__('Default Draft'), 'draft')->width(3),
            
            Text::make(__('Displayed in lists'), function($value)
            {
                $lists = $value->lists;
                $arr   = [];
                
                foreach ($lists as $list)
                {
                    $arr[] = '<span class="text-xs">' . $list->name . '</span>';
                }
                
                return implode(', ', $arr);
            })
                ->asHtml()
                ->onlyOnIndex(),
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
