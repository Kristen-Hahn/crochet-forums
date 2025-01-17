<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'postID' => ['required', 'integer'],
            'title' => ['required', 'string'],
            'tags' => ['required'],
            'body' => ['required', 'string'],
            'images' => ['nullable'],
        ];
    }
}
