<?php

namespace Tests\Feature;

use App\Models\CoRequisite;
use App\Models\Course;
use App\Models\PreRequisite;
use App\Models\Semester;
use App\Models\SemesterCourse;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SemesterCourseTest extends TestCase
{
    use RefreshDatabase;

    protected $semester;

    protected $semesterCourses;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->semester = Semester::factory()->create();

        $this->semesterCourses = SemesterCourse::factory()
            ->count(5)
            ->create(['semester_uuid' => $this->semester->uuid]);

        PreRequisite::factory()->create([
            'semester_course_uuid' => $this->semesterCourses->random()->uuid
        ]);

        CoRequisite::factory()->create([
            'semester_course_uuid' => $this->semesterCourses->random()->uuid
        ]);

        Sanctum::actingAs(User::factory()->create());
    }

    public function test_list_semester_courses()
    {
        $this->getJson('/api/v1/semesters/' . $this->semester->uuid . '/courses')
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [[
                    'uuid',
                    'course_uuid',
                    'semester_uuid',
                    'pre_requisites',
                    'co_requisites',
                    'course' => ['uuid', 'code', 'title', 'units', 'lecture_hours', 'laboratory_hours']
                ]]
            ]);
    }

    public function test_create_semester_course_with_non_existing_course()
    {
        $courseData = Course::factory()
            ->make()
            ->makeHidden('uuid')
            ->toArray();

        $this->postJson('/api/v1/semesters/' . $this->semester->uuid . '/courses', $courseData)
            ->dump()
            ->assertSuccessful();

        $this->assertDatabaseHas('courses', ['code' => $courseData['code']]);
    }
}
