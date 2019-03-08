<?php

namespace App\Http\Requests\Api\Admin\Schedule\Team;

use App\Models\Client\Group;
use App\Rules\Universal\CheckIfExist;
use Illuminate\Foundation\Http\FormRequest;

class ChangeGroupRequest extends FormRequest
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
            'group' => [new CheckIfExist(Group::class)]
        ];
    }
}
