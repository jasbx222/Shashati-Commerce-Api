<?php

namespace App\Rules;

use App\Models\Client;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckOtpCodeRule implements ValidationRule
{
    public function __construct(
        private ?string $phone
    )
    {

    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->phone) {
            $fail('الايميل مطلوب');
        }

        if (!Client::where('phone', $this->phone)
            ->where('otp', $value)
            ->exists()) {
            $fail('الكود المدخل غير صحيح');
        }
    }
}
