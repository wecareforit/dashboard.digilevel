<?php

namespace App\Filament\Resources\SolutionResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSolutionRequest extends FormRequest
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
			'code' => 'required|string',
			'solution' => 'required|string',
			'is_active' => 'required|integer',
			'company_id' => 'required|integer',
			'deleted_at' => 'required'
		];
    }
}
