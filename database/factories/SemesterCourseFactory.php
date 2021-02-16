<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Semester;
use App\Models\SemesterCourse;
use Illuminate\Database\Eloquent\Factories\Factory;

class SemesterCourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SemesterCourse::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->unique()->uuid,
            'course_uuid' => Course::factory()->create()->uuid,
            'semester_uuid' => Semester::factory()->create()->uuid,
        ];
    }
}
