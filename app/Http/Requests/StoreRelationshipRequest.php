<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StoreRelationshipRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'entity_from' => ['required', 'integer'],
            'entity_to' => ['required', 'integer'],
            'type' => ['required'],
            'desc' => ['required'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(
            collect($this->all())
                ->mapWithKeys(fn ($value, $key) => [Str::snake($key) => $value])
                ->all()
        );
    }
}
