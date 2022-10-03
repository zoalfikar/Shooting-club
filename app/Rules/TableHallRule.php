<?php

namespace App\Rules;

use App\Models\Hall;
use Illuminate\Contracts\Validation\Rule;

class TableHallRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $hall = Hall::all()->pluck('hallNumber')->toArray();
        return in_array($value,$hall);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'هذه الصالة غير موجودة';
    }
}
