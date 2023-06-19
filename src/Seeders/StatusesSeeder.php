<?php

declare(strict_types = 1);

namespace MrVaco\NovaStatusesManager\Seeders;

use Illuminate\Database\Seeder;
use MrVaco\NovaStatusesManager\Models\Statuses;

class StatusesSeeder extends Seeder
{
    protected array $statuses = [
        [
            'name'     => 'Protected',
            'color'    => '#cdd110',
            'active'   => false,
            'disabled' => false,
            'draft'    => false,
        ],
        [
            'name'     => 'New',
            'color'    => '#008ae6',
            'active'   => false,
            'disabled' => false,
            'draft'    => false,
        ],
        [
            'name'     => 'Draft',
            'color'    => '#8f8f8f',
            'active'   => false,
            'disabled' => false,
            'draft'    => true,
        ],
        [
            'name'     => 'Disabled',
            'color'    => '#A94442',
            'active'   => false,
            'disabled' => true,
            'draft'    => false,
        ],
        [
            'name'     => 'Actively',
            'color'    => '#31c433',
            'active'   => true,
            'disabled' => false,
            'draft'    => false,
        ],
    ];
    
    public function run()
    {
        foreach ($this->statuses as $item)
        {
            Statuses::query()->create($item);
        }
    }
}
