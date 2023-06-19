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
            'statuses' => [2, 3, 4, 5]
        ],
        [
            'name'     => 'Base',
            'statuses' => [2, 3, 4, 5]
        ],
        [
            'name'     => 'Short',
            'statuses' => [3, 4, 5]
        ],
    ];
    
    public function run()
    {
        foreach ($this->statuses_list as $item)
        {
            $value = $this->create($item['name']);
            $value->statuses()->sync($item['statuses']);
        }
    }
    
    protected function create(string $item): StatusesList
    {
        return StatusesList::query()->create(['name' => $item]);
    }
}
