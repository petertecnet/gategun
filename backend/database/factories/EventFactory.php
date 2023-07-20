<?php
namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'location' => $this->faker->city,
            'date' => $this->faker->date,
            'time' => $this->faker->time,
            'price' => $this->faker->randomFloat(2, 0, 100),
            'image_url' => 'default_image.jpg', // Substitua 'default_image.jpg' pela URL ou nome da imagem padrão.
        ];
    }
}
