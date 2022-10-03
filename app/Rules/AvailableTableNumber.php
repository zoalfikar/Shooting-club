<?php

namespace App\Rules;

use App\Models\Table;
use Illuminate\Contracts\Validation\Rule;

class AvailableTableNumber implements Rule
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
        return $value == Table::where('hallNumber', $this->hallNumber)->max('tableNumber') + 1 ;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'ارقام الطاولات متسسلسلة';
    }
}
