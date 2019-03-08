<?php

namespace App\Http\Requests\Api\Admin\Season;

use App\Models\Client\Season;
use App\Rules\Universal\IsUnique;
use Illuminate\Foundation\Http\FormRequest;

class SeasonUpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'min:1', 'max:255', new IsUnique(Season::class, null, [], $this->route('season'))]
        ];
    }
}
