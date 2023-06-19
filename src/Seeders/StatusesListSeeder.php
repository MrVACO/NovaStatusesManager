<?php

declare(strict_types = 1);

namespace MrVaco\NovaStatusesManager\Seeders;

use Illuminate\Database\Seeder;
use MrVaco\NovaStatusesManager\Models\StatusesList;

class StatusesListSeeder extends Seeder
{
    protected array $statuses_list = [
        [
            'name'     => 'Full',
            'slug'     => 'full',
            'statuses' => [2, 3, 4, 5]
        ],
        [
            'name'     => 'Base',
            'slug'     => 'base',
            'statuses' => [2, 3, 4, 5]
        ],
        [
            'name'     => 'Short',
            'slug'     => 'short',
            'statuses' => [3, 4, 5]
        ],
    ];
    
    public function run()
    {
        foreach ($this->statuses_list as $item)
        {
            $ids = $item['statuses'];
            unset($item['statuses']);
            
            $value = $this->create($item);
            $value->statuses()->sync($ids);
        }
    }
    
    protected function create(array $item): StatusesList
    {
        return StatusesList::query()->create($item);
    }
}
