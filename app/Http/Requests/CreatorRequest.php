<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatorRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:25', Rule::unique(table: 'creators', column: 'name')->
                      ignore(id: request('creator'), idColumn: 'id')]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => ('Se requiere escribir un nombre'),
            //'name.max' => ('Se sobrepasó la cantidad máxima de cáracteres: 25'),
            'name.unique' => ('El creador ya está registrado')
        ];
    }
}
