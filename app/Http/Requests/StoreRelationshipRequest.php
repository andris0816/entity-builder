<?php

namespace App\Http\Requests;

use App\Models\Relationship;
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
            'entity_from' => ['required', 'exists:entities,id', 'different:entity_to'],
            'entity_to' => ['required', 'exists:entities,id', 'different:entity_from'],
            'type' => ['required', 'string'],
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

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $from = $this->input('entity_from');
            $to = $this->input('entity_to');

            $exists = Relationship::where('entity_from', $from)
                ->where('entity_to', $to)
                ->orWhere('entity_from', $to)
                ->where('entity_to', $from)
                ->exists();

            if ($exists) {
                $validator->errors()->add(
                    'entity_from',
                    'A relationship between these entities already exists.'
                );
            }
        });
    }
}
