<?php

    namespace App\Http\Requests\Api\Admin\Club;

    use App\Models\Client\Club;
    use App\Rules\Universal\IsUnique;
    use Illuminate\Foundation\Http\FormRequest;

    class ClubUpdateRequest extends FormRequest {
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
                'name' => ['required', 'min:1', 'max:255', new IsUnique(Club::class, null, [], $this->route('club'))],
            ];
        }
    }
