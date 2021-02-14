<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProgramTest extends TestCase
{
    use RefreshDatabase;

    protected $department;

    protected $programs;

    protected $programData;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->department = Department::factory()->create();

        $this->programs = Program::factory()
            ->count(5)
            ->create(['department_id' => $this->department->id]);

        $this->programData = Program::factory()
            ->make(['department_id' => $this->department->id])
            ->toArray();

        Sanctum::actingAs(User::factory()->create());
    }

    /**
     * @group programs
     */
    public function test_list_department_programs()
    {
        $this->getJson('/api/v1/departments/' . $this->department->id . '/programs')
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [['id', 'name', 'acronym', 'department_id']]
            ]);
    }

    /**
     * @group programs
     */
    public function test_create_department_program()
    {
        $this->postJson('/api/v1/departments/' . $this->department->id . '/programs', $this->programData)
            ->assertSuccessful()
            ->assertJsonFragment(['status' => true])
            ->assertJsonStructure([
                'data' => ['id', 'name', 'acronym', 'department_id']
            ]);

        $this->assertDatabaseHas('programs', $this->programData);
    }

    /**
     * @group programs
     */
    public function test_update_department_program()
    {
        $program = $this->programs->random();

        $this->putJson("/api/v1/departments/" . $this->department->id . "/programs/$program->id", $this->programData)
            ->assertSuccessful()
            ->assertJsonFragment(['status' => true])
            ->assertJsonStructure([
                'data' => ['id', 'name', 'acronym', 'department_id']
            ]);

        $this->assertDatabaseHas('programs', $this->programData);
    }

    /**
     * @group programs
     */
    public function test_delete_department_program()
    {
        $program = $this->programs->random();

        $this->deleteJson("/api/v1/departments/" . $this->department->id . "/programs/$program->id")
            ->assertSuccessful()
            ->assertJsonFragment(['status' => true]);

        $this->assertNotNull($program->fresh()->deleted_at);
    }
}
