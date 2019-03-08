<?php

    namespace App\Rules\Api\Admin\Schedule\Team;

    use App\Models\Client\Club;
    use App\Models\Client\Schedule;
    use App\Models\Client\Team;
    use Illuminate\Contracts\Validation\Rule;

    class IsTeamUnique implements Rule {
        public $class;

        public $field;

        public $scheduleId;

        public $clubId;

        public $teamId;

        /**
         * Create a new rule instance.
         *
         * @return void
         */
        public function __construct(string $class, $field = null, $scheduleId = null, $clubId = null, $teamId = null) {
            $this->class = $class;
            $this->field = $field;
            $this->scheduleId = $scheduleId;
            $this->clubId = $clubId;
            $this->teamId = $teamId;
        }

        /**
         * Determine if the validation rule passes.
         *
         * @param  string $attribute
         * @param  mixed  $value
         *
         * @return bool
         */
        public function passes($attribute, $value) {
            if ($this->field == null) {
                $pieces = explode('.', $attribute);
                $this->field = array_pop($pieces);
            }

            $query = $this->class::where($this->field, $value);

            if ($this->scheduleId) {
                $query->where('schedule_id', $this->scheduleId);
            }

            if ($this->clubId) {
                $query->where('club_id', $this->clubId);
            }

            if ($this->teamId) {
                $query->where('id', '!=', $this->teamId);
            }

            $item = $query->first();

            return !is_object($item);
        }

        /**
         * Get the validation error message.
         *
         * @return string
         */
        public function message() {
            return class_basename($this->class) . ' with that ' . $this->field . ' already exists.';
        }
    }
