<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_type_id' => 'required|exists:event_types,id',
            'family_type_id' => 'required|exists:family_types,id',
            'biological_children' => 'required|integer|min:0',
            'foster_children' => 'required|integer|min:0',
            'disabled_children' => 'required|integer|min:0',
            'disabled_adults' => 'required|integer|min:0',
            'children_in_family' => 'required|integer|min:0',
            'children_in_institution' => 'required|integer|min:0',
            'notes' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $sum =
                $this->biological_children +
                $this->foster_children +
                $this->disabled_children +
                $this->children_in_family +
                $this->children_in_institution;

            if ($sum <= 0) {
                $validator->errors()->add('biological_children', 'Хотя бы одно поле должно быть больше 0');
            }
        });
    }
}
