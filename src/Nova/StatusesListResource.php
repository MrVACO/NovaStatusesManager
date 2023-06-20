<?php

declare(strict_types = 1);

namespace MrVaco\NovaStatusesManager\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Laravel\Nova\Resource;
use MrVaco\NovaStatusesManager\Models\StatusesList;

class StatusesListResource extends Resource
{
    public static $displayInNavigation = false;
    
    public static string $model = StatusesList::class;
    
    public static function label(): string
    {
        return __('Lists for statuses');
    }
    
    public static function singularLabel(): string
    {
        return __('record');
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
                'resource' => '',
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
            
            Text::make(__('List name'), 'name')
                ->sortable()
                ->rules('required'),
            
            Slug::make(__('Code'), 'slug')
                ->from('name')
                ->sortable()
                ->rules('required'),
            
            Text::make(__('Used for statuses'), function($value)
            {
                $lists = $value->statuses;
                $arr   = [];
                
                foreach ($lists as $list)
                {
                    $arr[] = '<span class="px-2 py-1 mx-1 my-1 text-xs font-bold" style="color: ' . $list->color . '">' . $list->name . '</span>';
                }
                
                return implode($arr);
            })->asHtml()->onlyOnIndex(),
        ];
    }
}
