<?php

namespace App\Http\Controllers\Feedback;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class FeedbackStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'datetime' => 'required|int',
            'service_name' => ['required', Rule::in(['Магазин', 'Доставка', 'Приложение'])],
            'rating' => 'required|integer|min:1|max:5',
        ];
    }
}
