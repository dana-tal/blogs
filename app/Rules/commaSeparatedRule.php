<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class commaSeparatedRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
       $is_valid = true;
       $list = explode(",",$value);
       $num = count($list);
       for($i=0; $i<$num && $is_valid ;$i++)
       {
            $trimmed = trim($list[$i]);
            if (empty($trimmed))
            {
                $is_valid = false;
            }
       }
       if (!$is_valid)
       {
            $fail($attribute." should be formatted as a comma separated list");
       }
    }
}
