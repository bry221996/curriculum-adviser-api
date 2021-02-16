<?php

namespace App\Http\Controllers;

use App\Http\Requests\SemesterCourse\CreateRequest;
use App\Models\Semester;
use App\Models\SemesterCourse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SemesterCourseController extends Controller
{
    /**
     * List semester courses.
     *
     * @param Request $request
     * @param Semester $semester
     * @return Response
     */
    public function index(Request $request, Semester $semester): Response
    {
        $data = SemesterCourse::where('semester_uuid', $semester->uuid)
            ->with([
                'course',
                'preRequisites' => function ($query) {
                    $query->with('course:uuid,code');
                },
                'coRequisites' => function ($query) {
                    $query->with('course:uuid,code');
                }
            ])
            ->paginate($request->page_size ?? 10);

        return response($data);
    }

    public function store(CreateRequest $request, Semester $semester)
    {
        $semesterCourse = SemesterCourse::create([
            'semester_uuid' => $semester->uuid,
            'course_uuid' => $request->courseUuid()
        ]);

        return response([
            'status' => true,
            'data' => $semesterCourse->load('course')
        ]);
    }
}
