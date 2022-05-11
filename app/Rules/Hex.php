<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Hex implements Rule
{
    public function passes($attribute, $value)
    {
        $pattern = '/^#([a-fA-F0-9]{3}|[a-fA-F0-9]{6})$/';

        return (bool) preg_match($pattern, $value);
    }

    public function message()
    {
        return 'The :attribute field must be a valid hex code.';
    }
}
