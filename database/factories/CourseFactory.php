<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $units = $this->faker->numberBetween(1, 5);
        return [
            'uuid' => $this->faker->unique()->uuid,
            'code' => strtoupper($this->faker->unique()->lexify('????')) . ' ' . $this->faker->numerify('###'),
            'title' => $this->faker->sentence,
            'units' => $units,
            'lecture_hours' => $this->faker->numberBetween(1, $units),
            'laboratory_hours' => $this->faker->numberBetween(1, $units),
        ];
    }
}
