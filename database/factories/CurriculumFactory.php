<?php

namespace Database\Factories;

use App\Models\Curriculum;
use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

class CurriculumFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Curriculum::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'program_id' => Program::factory()->create()->id,
            'academic_year_start' => now()->subYear()->format('Y'),
            'academic_year_end' => now()->format('Y'),
            'description' => $this->faker->paragraph,
            'is_draft' => 1,
            'status' => 0,
        ];
    }
}
