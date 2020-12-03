<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'customer_id' => ['required'],
            'address' => ['required'],
            'shipping_date' => ['date', 'dateFormat:d/m/Y H:i', 'after:today'],
            'product' => ['required', 'array'],
            'product.*.product_id' => ['required'],
            'product.*.quantity' => ['required'],
        ];
    }
}
