<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DepartmentTest extends TestCase
{
    use RefreshDatabase;

    protected $departments;

    protected $departmentData;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->departments = Department::factory()->count(5)->create();

        $this->departmentData = Department::factory()
            ->make()
            ->makeHidden('logo')
            ->toArray();

        Sanctum::actingAs(User::factory()->create());

        Storage::fake();
    }

    /**
     * @group departments
     */
    public function test_list_departments()
    {
        $this->getJson('/api/v1/departments')
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [['id', 'name', 'acronym', 'logo']]
            ]);
    }

    /**
     * @group departments
     */
    public function test_create_department()
    {
        $this->postJson('/api/v1/departments', $this->departmentData)
            ->assertSuccessful()
            ->assertJsonFragment(['status' => true])
            ->assertJsonStructure([
                'data' => ['name', 'acronym']
            ]);

        $this->assertDatabaseHas('departments', $this->departmentData);
    }

    /**
     * @group departments
     */
    public function test_update_department()
    {
        $department = $this->departments->random();

        $this->putJson("/api/v1/departments/$department->id", $this->departmentData)
            ->assertSuccessful()
            ->assertJsonFragment(['status' => true])
            ->assertJsonStructure([
                'data' => ['name', 'acronym', 'logo']
            ]);

        $this->assertDatabaseHas('departments', $this->departmentData);
    }

    /**
     * @group departments
     */
    public function test_delete_department()
    {
        $department = $this->departments->random();

        $this->deleteJson("/api/v1/departments/$department->id")
            ->assertSuccessful()
            ->assertJsonFragment(['status' => true]);

        $this->assertNotNull($department->fresh()->deleted_at);
    }

    /**
     * @group departments
     */
    public function test_upload_department_logo()
    {
        $department = $this->departments->random();

        $file = UploadedFile::fake()->image('logo.jpg');

        $this->postJson("/api/v1/departments/$department->id/logo", ['image' => $file])
            ->assertSuccessful()
            ->assertJsonFragment(['status' => true]);

        Storage::assertExists($department->fresh()->logo);
    }
}
