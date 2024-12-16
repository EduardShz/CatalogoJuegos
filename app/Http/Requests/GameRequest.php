<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GameRequest extends FormRequest
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
             'name' => ['required', 'string', 'max:150', Rule::unique('games', 'name')->ignore($this->route('game'), 'id')],
             'published_year' => ['required', 'string', 'max:4'],
             'rating' => ['required', 'numeric' ,'between:0,10'],
             'creator_id' => ['required' ,'exists:creators,id'],
             'platform_id' => ['required', 'array'],
             'platform_id.*' => 'exists:platforms,id',
             'genre_id' => ['required', 'array'],
             'genre_id.*' => 'exists:genres,id',
         ];
     }
}
