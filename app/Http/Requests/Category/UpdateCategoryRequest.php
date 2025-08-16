<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('category')->id ?? null;
        return [
             'name' => ['sometimes','required','string','max:120', Rule::unique('categories','name')->ignore($id)],
            'slug' => ['sometimes','required','string','max:150', Rule::unique('categories','slug')->ignore($id)],
        ];
    }
}
