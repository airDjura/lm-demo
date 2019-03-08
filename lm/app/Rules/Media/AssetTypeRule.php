<?php

namespace App\Rules\Media;

use Illuminate\Contracts\Validation\Rule;

class AssetTypeRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->allowClasses = [
            'player',
            'club',
        ];
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
        return in_array($value, $this->allowClasses);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute expects strings => ' . implode(', ', $this->allowClasses) . '.';
    }
}
