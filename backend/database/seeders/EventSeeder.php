<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Exemplo de eventos de teste
        $events = [
            [
                'name' => 'Evento 1',
                'location' => 'Local 1',
                'date' => '2023-07-20',
                'time' => '19:00',
                'price' => 50.00,
            ],
            [
                'name' => 'Evento 2',
                'location' => 'Local 2',
                'date' => '2023-07-25',
                'time' => '20:30',
                'price' => 30.00,
            ],
            // Adicione mais eventos de exemplo aqui, se desejar
        ];

        // Insira os eventos na tabela de eventos
        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
