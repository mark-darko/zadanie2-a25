<?php

namespace App\Http\Controllers\Feedback;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackStoreRequest extends FormRequest
{
    public $service_names = ['Магазин', 'Приложение', 'Доставка'];
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
            'service_name' => 'required|string|in:'.implode(',', $this->service_names),
            'rating' => 'required|int',
        ];
    }
}
