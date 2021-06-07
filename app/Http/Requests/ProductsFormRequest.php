<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // if set to false 403 error authorization error
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
            //all validation rules here 
            'name' => 'required|max:255|min:3',
            'slug' => 'required|string|unique:products',
            'description' => 'required|min:10',
            'price' => 'required|integer',
            'category_id'=>'required|integer|min:1',
            'image'=>'image|size:2048',
        ];
    }

    /**
     * Get the error messages for validation rules 
     * used to customize the error message
     */
    public function messages()
    {
        return[
            'category_id.min'=>'Please select atleast one category',
            'price.integer'=>'Price should be an integer'
        ];
    }

    
    
}
