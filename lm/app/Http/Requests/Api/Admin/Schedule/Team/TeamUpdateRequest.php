<?php

namespace App\Http\Requests\Api\Admin\Schedule\Team;

use App\Models\Client\Club;
use App\Models\Client\Team;
use App\Rules\Api\Admin\Schedule\Team\IsTeamUnique;
use App\Rules\Universal\CheckIfExist;
use Illuminate\Foundation\Http\FormRequest;

class TeamUpdateRequest extends FormRequest
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
        $teamId = null;
        if ($this->route('team')) {
            $teamId = $this->route('team');
        }

        $scheduleId = null;
        if ($this->route('schedule')) {
            $scheduleId = $this->route('schedule');
        }

        $clubUuid = null;
        if ($this->request->get('club')['uuid']) {
            $clubId = fromArrayWithUuidToId(Club::class, $this->request->get('club'));
        }

        return [
            'suffix' => [new IsTeamUnique(Team::class, 'suffix', $scheduleId, $clubId, $teamId)],
            'club' => ['required', new CheckIfExist(Club::class)],
            'players' => ['required', 'min:5'],
        ];
    }
}
