<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\PreRequisite;
use App\Models\SemesterCourse;
use Illuminate\Database\Eloquent\Factories\Factory;

class PreRequisiteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PreRequisite::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->unique()->uuid,
            'semester_course_uuid' => SemesterCourse::factory()->create()->uuid,
            'course_uuid' => Course::factory()->create()->uuid,
        ];
    }
}
