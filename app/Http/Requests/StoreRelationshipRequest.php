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
            'source' => ['required', 'exists:entities,id', 'different:target'],
            'target' => ['required', 'exists:entities,id', 'different:source'],
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

            $relationship = $this->route('relationship');
            $from = $this->input('source');
            $to = $this->input('target');

            $exists = Relationship::where(function ($q) use ($from, $to) {
                $q->where(function ($q) use ($from, $to) {
                    $q->where('source', $from)
                        ->where('target', $to);
                })->orWhere(function ($q) use ($from, $to) {
                    $q->where('source', $to)
                        ->where('target', $from);
                });
            })->when(
                $relationship, fn ($q) =>
                    $q->where('id', '!=', $relationship->getKey())
                )
                ->exists();

            if ($exists) {
                $validator->errors()->add(
                    'source',
                    'A relationship between these entities already exists.'
                );
            }
        });
    }
}
