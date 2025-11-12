<?php

namespace App\Http\Requests;

use App\Enums\ReactionType;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ToggleLikeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'post_id' => 'required|string|exists:posts,id',
            'type' => ['required', Rule::enum(ReactionType::class)],
        ];
    }
}
