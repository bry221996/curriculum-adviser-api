<?php

namespace Database\Factories;

use App\Models\Curriculum;
use App\Models\Semester;
use Illuminate\Database\Eloquent\Factories\Factory;

class SemesterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Semester::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->unique()->uuid,
            'curriculum_id' => Curriculum::factory()->create()->id,
            'year' => $this->faker->numberBetween(0, 5),
            'type' => $this->faker->randomElement(['first', 'second', 'midterm']),
        ];
    }
}
