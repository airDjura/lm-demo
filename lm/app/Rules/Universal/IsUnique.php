<?php

    namespace App\Rules\Universal;

    use Illuminate\Contracts\Validation\Rule;

    class IsUnique implements Rule {
        public $class;

        public $field;

        public $whereArray;

        public $uuid;

        /**
         * Create a new rule instance.
         *
         * @return void
         */
        public function __construct(string $class, $field = null, array $whereArray = [], $uuid = null) {
            $this->class = $class;
            $this->field = $field;
            $this->whereArray = $whereArray;
            $this->uuid = $uuid;
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
            if ($this->whereArray) {
                $query->where($this->whereArray);
            }

            if ($this->uuid) {
                $query->where('uuid', '!=', $this->uuid);
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
            return $this->field . '.exists';
        }
    }
