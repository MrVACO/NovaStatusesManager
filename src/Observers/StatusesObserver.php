<?php

declare(strict_types = 1);

namespace MrVaco\NovaStatusesManager\Observers;

use Illuminate\Support\Collection;
use MrVaco\NovaStatusesManager\Models\Statuses;

class StatusesObserver
{
    public function created(Statuses $model): void
    {
        $this->refreshDefaults($model);
    }
    
    public function updated(Statuses $model): void
    {
        $this->refreshDefaults($model);
    }
    
    public function restored(Statuses $model): void
    {
        $this->refreshDefaults($model);
    }
    
    protected function refreshDefaults($model): void
    {
        $id = $model->id;
        
        if ($model->active)
        {
            $this->setStatuses($id, 'active');
        }
        
        if ($model->disabled)
        {
            $this->setStatuses($id, 'disabled');
        }
        
        if ($model->draft)
        {
            $this->setStatuses($id, 'draft');
        }
    }
    
    protected function getStatuses(int $id, string $column): Collection
    {
        return Statuses::query()
            ->where('id', '<>', $id)
            ->where($column, true)
            ->get();
    }
    
    protected function setStatuses(int $id, string $column): void
    {
        $this->getStatuses($id, $column)->each(function(Statuses $model) use ($column)
        {
            $model->update([
                $model->{$column} = false
            ]);
        });
    }
}
