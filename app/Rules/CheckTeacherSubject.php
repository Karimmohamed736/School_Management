<?php

namespace App\Rules;

use App\Models\Teaching;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class CheckTeacherSubject implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $teacherId = request()->input('teacher_id');
        $subjectId = $value;

        if (!Teaching::where('teacher_id', $teacherId)->where('subject_id', $subjectId)->exists()) {
            $fail('The selected teacher does not teach the selected subject.');
        }

    }

    public function passes($attribute, $value)
    {
        $teacherId = request()->input('teacher_id');
        $subjectId = $value;

        return Teaching::where('teacher_id', $teacherId)->where('subject_id', $subjectId)->exists();
    }
}
