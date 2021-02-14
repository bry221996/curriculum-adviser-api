<?php

namespace App\Http\Controllers;

use App\Http\Requests\Curriculum\CreateRequest;
use App\Models\Curriculum;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CurriculumController extends Controller
{
    /**
     * List Program curricula.
     *
     * @param Request $request
     * @param Program $program
     * @return Response
     */
    public function index(Request $request, Program $program): Response
    {
        $data = Curriculum::where('program_id', $program->id)
            ->paginate($request->page_size ?? 10);

        return response($data);
    }

    /**
     * Save program curriculum.
     *
     * @param CreateRequest $request
     * @param Program $program
     * @return Response
     */
    public function store(CreateRequest $request, Program $program): Response
    {
        $curriculum = $program->curricula()
            ->create($request->curriculumInput());

        $curriculum->structures()->createMany($request->structures);

        return response([
            'status' => true,
            'data' => $curriculum->load('structures')
        ]);
    }

    /**
     * Update program curriculum description.
     *
     * @param Request $request
     * @param Program $program
     * @param Curriculum $curriculum
     * @return Response
     */
    public function update(Request $request, Program $program, Curriculum $curriculum): Response
    {
        $data = $request->validate([
            'description' => 'required'
        ]);

        $curriculum->update($data);

        return response([
            'status' => true,
            'data' => $curriculum->load('structures')
        ]);
    }

    /**
     * Delete program curriculum.
     *
     * @param Program $program
     * @param Curriculum $curriculum
     * @return Response
     */
    public function destroy(Program $program, Curriculum $curriculum): Response
    {
        $curriculum->delete();

        return response([
            'status' => true,
        ]);
    }
}
