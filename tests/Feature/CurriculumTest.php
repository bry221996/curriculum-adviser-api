<?php

namespace Tests\Feature;

use App\Models\Curriculum;
use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CurriculumTest extends TestCase
{
    use RefreshDatabase;

    protected $program;

    protected $curriculum;

    protected $curriculumData;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->program = Program::factory()->create();

        $this->curriculum = Curriculum::factory()
            ->create(['program_id' => $this->program->id]);

        Sanctum::actingAs(User::factory()->create());

        $this->curriculumData = Curriculum::factory()
            ->make(['program_id' => $this->program->id])
            ->toArray();
    }

    /**
     * @group curricula
     */
    public function test_list_programs_curriculumns()
    {
        $this->getJson('/api/v1/programs/' . $this->program->id . '/curricula')
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [['program_id', 'academic_year_start', 'academic_year_end', 'description', 'status', 'is_draft']]
            ]);
    }

    /**
     * @group curricula
     */
    public function test_create_program_curricumn()
    {
        $data = $this->curriculumData;

        $data['semesters'] = [];

        collect(range(1, 4))
            ->each(function ($year) use (&$data) {
                collect(['first', 'second', 'midterm'])
                    ->filter(function ($semester) use ($year) {
                        if ($semester == 'midterm') {
                            return $year == 4 ? false : rand(0, 1);
                        }
                        return true;
                    })
                    ->each(function ($semester) use ($year, &$data) {
                        array_push($data['semesters'], ['year' => $year, 'type' => $semester]);
                    });
            });

        $this->postJson('/api/v1/programs/' . $this->program->id . '/curricula', $data)
            ->assertSuccessful()
            ->assertJsonFragment(['status' => true])
            ->assertJsonStructure([
                'data' => [
                    'academic_year_start',
                    'academic_year_end',
                    'description',
                    'program_id',
                    'semesters' => [['year', 'type']]
                ]
            ]);

        $this->assertDatabaseHas('curricula', $this->curriculumData);
    }

    /**
     * @group curricula
     */
    public function test_update_program_curriculum()
    {
        $this->putJson('/api/v1/programs/' . $this->program->id . '/curricula/' . $this->curriculum->id, $this->curriculumData)
            ->assertSuccessful()
            ->assertJsonFragment(['status' => true]);

        $this->assertDatabaseHas('curricula', $this->curriculumData);
    }

    /**
     * @group curricula
     */
    public function test_delete_program_curriculum()
    {
        $this->deleteJson('/api/v1/programs/' . $this->program->id . '/curricula/' . $this->curriculum->id)
            ->assertSuccessful()
            ->assertJsonFragment(['status' => true]);

        $this->assertNotNull($this->curriculum->fresh()->deleted_at);
    }
}
