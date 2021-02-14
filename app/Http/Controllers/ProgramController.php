<?php

namespace App\Http\Controllers;

use App\Http\Requests\Program\UpdateRequest;
use App\Http\Requests\Program\CreateRequest;
use App\Models\Department;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProgramController extends Controller
{
    /**
     * List department programs.
     *
     * @param Request $request
     * @param Department $department
     * @return Response
     */
    public function index(Request $request, Department $department): Response
    {
        $data = Program::where('department_id', $department->id)
            ->paginate($request->page_size ?? 10);

        return response($data);
    }

    /**
     * Create department program.
     *
     * @param CreateRequest $request
     * @param Department $department
     * @return Response
     */
    public function store(CreateRequest $request, Department $department): Response
    {
        $program = $department->programs()->create($request->validated());

        return response([
            'status' => true,
            'data' => $program
        ]);
    }

    /**
     * update department program.
     *
     * @param UpdateRequest $request
     * @param Department $department
     * @param Program $program
     * @return Response
     */
    public function update(UpdateRequest $request, Department $department, Program $program): Response
    {
        $program->update($request->validated());

        return response([
            'status' => true,
            'data' => $program->fresh()
        ]);
    }

    /**
     * Delete department program.
     *
     * @param Department $department
     * @param Program $program
     * @return Response
     */
    public function destroy(Department $department, Program $program): Response
    {
        $program->delete();

        return response([
            'status' => true
        ]);
    }
}
