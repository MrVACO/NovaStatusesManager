<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statuses_lists', function(Blueprint $table)
        {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });
        
        Schema::create('statuses_rel_statuses_lists', function(Blueprint $table)
        {
            $table->integer('statuses_id')->unsigned();
            $table->integer('statuses_list_id')->unsigned();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('statuses_lists');
        Schema::dropIfExists('statuses_rel_statuses_lists');
    }
};
