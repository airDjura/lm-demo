<?php

namespace App\Http\Requests\Api\Admin\League;

use App\Models\Client\League;
use App\Rules\Universal\IsUnique;
use Illuminate\Foundation\Http\FormRequest;

class LeagueUpdateRequest extends FormRequest
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
            'name' => ['required', 'min:1', 'max:255', new IsUnique(League::class, null, [], $this->route('league'))],
        ];
    }
}
