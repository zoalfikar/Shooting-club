<?php

namespace App\Rules;

use App\Models\Hall;
use Illuminate\Contracts\Validation\Rule;

class MaxHallCapacity implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    protected $hallNumber;

    public function __construct($hallNumber)
    {
        $this->hallNumber = $hallNumber;
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
        return $value <= Hall::where('hallNumber',$this->hallNumber)->pluck('maxCapacity')->first();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ' تم الوصول للحد الاقصى للطاولات ';
    }
}
