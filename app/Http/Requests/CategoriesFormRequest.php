<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriesFormRequest extends FormRequest
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
            'name' => 'required|unique:categories|max:255|min:3',
            'description' => 'required|max:255|min:10',
            'image'=>'image|size:2048',
            'slug'=>'required|unique:categories',
        ];
    }

}
