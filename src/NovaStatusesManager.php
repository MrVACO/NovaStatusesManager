<?php

namespace MrVaco\NovaStatusesManager;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Tool;
use MrVaco\NovaStatusesManager\Nova\StatusesListResource;
use MrVaco\NovaStatusesManager\Nova\StatusesResource;

class NovaStatusesManager extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot(): void {}
    
    /**
     * Build the menu that renders the navigation links for the tool.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed
     */
    public function menu(Request $request): mixed
    {
        return MenuSection::make(StatusesResource::label(), [
            MenuItem::make(StatusesListResource::label())
                ->path('/resources/' . StatusesListResource::uriKey())
        ])
            ->path('/resources/' . StatusesResource::uriKey())
            ->icon('view-list');
    }
}
