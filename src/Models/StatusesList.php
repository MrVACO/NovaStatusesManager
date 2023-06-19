<?php

namespace MrVaco\NovaStatusesManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StatusesList extends Model
{
    protected $table = 'statuses_lists';
    
    protected $fillable = [
        'name',
    ];
    
    public function statuses(): BelongsToMany
    {
        return $this->belongsToMany(Statuses::class, 'statuses_rel_statuses_lists');
    }
}
