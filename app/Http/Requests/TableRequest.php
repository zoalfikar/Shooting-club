<?php

namespace App\Http\Requests;

use App\Rules\AvailableTableNumber;
use App\Rules\MaxHallCapacity;
use App\Rules\TableHallRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tableNumber' => ['required','numeric', Rule::unique('tables')->where(fn ($query) => $query->where('hallNumber', $this->hallNumber)), new AvailableTableNumber($this->hallNumber),new MaxHallCapacity($this->hallNumber)],
            'hallNumber' => ['required','numeric', new TableHallRule()],
            'maxCapacity' => 'required|numeric|min:1',
            'active'=>'required'
        ];
    }
}
