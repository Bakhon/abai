<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ClassName implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param string $className
     * @return bool
     */
    public function passes($attribute, $className)
    {
        $parts = explode('\\', ltrim($className, '\\'));

        foreach ($parts as $part) {
            if (!(bool)preg_match(
                "%
            ^                       # A valid class name starts with
            [a-z_\x80-\xff]         # a letter or underscore,
            [a-z0-9_\x80-\xff]*     # followed by any number of letters, numbers, or underscores
            $                       # and nothing else
            %xi",
                $part
            )) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Class name is not valid';
    }
}
