<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'service_type' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'budget_range' => ['nullable', 'string', 'max:255'],
            'deadline' => ['nullable', 'date'],
            'attachments' => ['nullable', 'array', 'max:5'],
            'attachments.*' => ['file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpg,jpeg,png,webp,txt', 'max:10240'],
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
            'title.required' => 'وارد کردن عنوان پروژه الزامی است.',
            'service_type.required' => 'انتخاب نوع خدمت الزامی است.',
            'description.required' => 'توضیحات پروژه الزامی است.',
            'attachments.max' => 'حداکثر می‌توانید ۵ فایل ضمیمه کنید.',
            'attachments.*.mimes' => 'فرمت فایل ارسالی مجاز نیست (فرمت‌های مجاز: عکس، PDF، آفیس، فشرده).',
            'attachments.*.max' => 'حجم هر فایل نمی‌تواند بیشتر از ۱۰ مگابایت باشد.',
        ];
    }
}
