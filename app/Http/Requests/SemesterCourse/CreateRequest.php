<?php

namespace App\Http\Requests\SemesterCourse;

use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required',
            'title' => 'required',
            'units' => 'required|integer',
            'lecture_hours' => 'required|integer',
            'laboratory_hours' => 'required|integer'
        ];
    }

    public function courseUuid()
    {
        $course =  Course::firstOrCreate(['code' => $this->code], [
            'title' => $this->title,
            'units' => $this->units,
            'lecture_hours' => $this->lecture_hours,
            'laboratory_hours' => $this->laboratory_hours
        ]);

        return $course->uuid;
    }
}
