<?php

    namespace App\Http\Requests\Api\Admin\Schedule;

    use App\Models\Client\League;
    use App\Models\Client\Schedule;
    use App\Rules\Api\Admin\Schedule\IsScheduleUnique;
    use App\Rules\Universal\CheckIfExist;
    use App\Rules\Universal\IsUnique;
    use Illuminate\Foundation\Http\FormRequest;

    class ScheduleStoreRequest extends FormRequest {
        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        public function authorize() {
            return true;
        }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules() {
            return [
                'league' => ['required', new CheckIfExist(League::class), new IsScheduleUnique()],
            ];
        }
    }
