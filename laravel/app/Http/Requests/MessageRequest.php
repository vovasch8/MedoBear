<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name" => "required|max:255|min:3",
            "subject" => "required|max:255|min:3",
            "text" => "required|max:5000|min:10",
            "phone" => "required|max:15|min:5"
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'name.required' => 'Поле ім\'я обов\'язкове',
            'subject.required' => 'Поле тема обов\'язкове',
            'text.required' => 'Поле повідомлення обов\'язкове',
            'phone.required' => 'Поле телефон обов\'язкове',
            'name.max' => 'Поле ім\'я не повинно бути довше 255 символів',
            'subject.max' => 'Поле тема не повинно бути довше 255 символів',
            'text.max' => 'Поле повідомлення не повинно бути довше 5000 символів',
            'phone.max' => 'Поле телефон не повинно бути довше 15 символів',
            'name.min' => 'Поле ім\'я повинно бути довше 3 символів',
            'subject.min' => 'Поле тема повинно бути довше 3 символів',
            'text.min' => 'Поле повідомлення повинно бути довше 10 символів',
            'phone.min' => 'Поле телефон повинно бути довше 5 символів'
        ];
    }
}
