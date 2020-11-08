<?php


namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->text(100),
            'priority' => $this->faker->numberBetween(0, 2),
            'status' => $this->faker->numberBetween(0, 3),
            'manager_id' => $this->faker->numberBetween(1, 3),
            'worker_id' => $this->faker->numberBetween(4, 10),
        ];
    }
}
