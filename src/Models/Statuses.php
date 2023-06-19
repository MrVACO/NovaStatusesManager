<?php

declare(strict_types = 1);

namespace MrVaco\NovaStatusesManager\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Statuses extends Model
{
    protected $table = 'statuses';
    
    protected $fillable = [
        'name',
        'color',
        'active',
        'disable',
        'draft',
    ];
    
    public function lists(): BelongsToMany
    {
        return $this->belongsToMany(StatusesList::class, 'statuses_rel_statuses_lists');
    }
    
    public function scopeIsActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }
    
    public function scopeIsDisabled(Builder $query): Builder
    {
        return $query->where('disabled', true);
    }
    
    public function scopeIsDraft(Builder $query): Builder
    {
        return $query->where('draft', true);
    }
}
