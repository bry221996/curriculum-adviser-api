<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\Department\CreateRequest;
use App\Http\Requests\Department\UpdateRequest;
use App\Http\Requests\Department\UploadRequest;

class DepartmentController extends Controller
{
    /**
     * List departments
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $data = Department::paginate($request->page_size ?? 10);

        return response($data);
    }

    /**
     * Create department
     *
     * @param CreateRequest $request
     * @return Response
     */
    public function store(CreateRequest $request): Response
    {
        $department = Department::create($request->validated());

        return response([
            'status' => true,
            'data' => $department
        ]);
    }

    /**
     * Update department
     *
     * @param UpdateRequest $request
     * @param Department $department
     * @return Response
     */
    public function update(UpdateRequest $request, Department $department): Response
    {
        $department->update($request->validated());

        return response([
            'status' => true,
            'data' => $department->fresh()
        ]);
    }

    /**
     * Upload department logo.
     *
     * @param Department $department
     * @param UploadRequest $request
     * @return Response
     */
    public function logo(Department $department, UploadRequest $request): Response
    {
        $path = $request->image->store('public');

        $department->update(['logo' => $path]);

        return response([
            'status' => true,
            'data' => $department->fresh()
        ]);
    }

    /**
     * Delete department.
     *
     * @param Department $department
     * @return Response
     */
    public function destroy(Department $department): Response
    {
        $department->delete();

        return response(['status' => true]);
    }
}
