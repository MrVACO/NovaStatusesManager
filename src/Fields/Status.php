<?php

declare(strict_types = 1);

namespace MrVaco\NovaStatusesManager\Fields;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\SupportsDependentFields;
use MrVaco\NovaStatusesManager\Models\Statuses;

class Status extends Field
{
    use SupportsDependentFields;
    
    public $showOnCreation = false;
    
    public $showOnUpdate = false;
    
    public function component(): string
    {
        $this->withMeta([
            'status' => Statuses::query()->find($this->value)
        ]);
        
        return 'status-field';
    }
}
