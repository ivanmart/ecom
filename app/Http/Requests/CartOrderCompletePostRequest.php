<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartOrderCompletePostRequest extends FormRequest
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
            'city' => 'required',
            'street' => 'required',
            'house' => 'required',
            'flat' => 'required',
            'pay-type' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'city.required' => '',
            'street.required'  => '',
            'house.required'  => '',
            'flat.required'  => '',
            'pay-type.required'  => 'Необходимо указать способ оплаты',
        ];
    }

}
