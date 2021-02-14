<?php

namespace App\Http\Requests\Curriculum;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

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
            'academic_year_start' => 'required|date_format:Y',
            'academic_year_end' => 'required|date_format:Y',
            'description' => 'required',
            'structures' => 'required|array',
            'structures.*.year' => 'required|integer',
            'structures.*.semester' => 'required|in:first,second,midterm',
        ];
    }

    public function curriculumInput(): array
    {
        return [
            'academic_year_start' => $this->academic_year_start,
            'academic_year_end' => $this->academic_year_end,
            'description' => $this->description,
        ];
    }
}
