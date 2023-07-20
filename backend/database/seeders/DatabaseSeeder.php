<?php

namespace Database\Seeders;
use App\Models\Event;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Chamando o Factory para criar 10 eventos de exemplo
        Event::factory()->count(10)->create();
    }
}

