<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuItemRequest extends FormRequest
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
    public function update()
    {
       if (!$this->pace) {
         $this->pace = 1;
       }
       if (!isset($this->fragmentable)) {
        $this->request->add(['fragmentable' => 0]);
      }
      if (!isset($this->active)) {
        $this->request->add(['active' => 0]);
      }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->update();
        return [
            'title' => ['required'],
            'section' => ['required','exists:menu_sections,id'],
            'unit' => ['required'],
            'price' => 'required|numeric|between:0.00,9999999.99',
            'fragmentable' => 'required',
            'active'=>'required'
        ];
    }
}
