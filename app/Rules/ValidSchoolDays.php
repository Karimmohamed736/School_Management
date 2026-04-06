<?php

namespace App\Rules;

use App\Models\Holiday;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidSchoolDays implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $date = Carbon::parse($value);

        $schoolDays = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday'];

        if (!in_array(strtolower($date->format('l')), $schoolDays)) {
            $fail("The $attribute must be a valid school day.");
            return;
        }

        if (Holiday::where('date', $value)->exists()) {
            $fail("The $attribute is a holiday.");
        }
    }
}



