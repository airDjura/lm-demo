<?php

namespace App\Rules\Universal;

use Illuminate\Contracts\Validation\Rule;

class CheckIfExist implements Rule
{
    public $class;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $item = $this->class::getByUuid($value['uuid']);

        return is_object($item);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return class_basename($this->class) . ' does not exists.';
    }
}
