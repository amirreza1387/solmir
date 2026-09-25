<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'in:general,technical,billing,order'],
            'priority' => ['required', 'string', 'in:low,medium,high,urgent'],
            'message' => ['required', 'string', 'max:5000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'وارد کردن عنوان تیکت الزامی است.',
            'category.required' => 'انتخاب دسته‌بندی الزامی است.',
            'category.in' => 'دسته‌بندی انتخاب شده معتبر نیست.',
            'priority.required' => 'انتخاب اولویت الزامی است.',
            'priority.in' => 'اولویت انتخاب شده معتبر نیست.',
            'message.required' => 'متن پیام تیکت الزامی است.',
        ];
    }
}
