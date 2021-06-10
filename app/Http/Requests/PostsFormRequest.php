<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostsFormRequest extends FormRequest
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
            //all validation rules here 
            'title' => 'required|max:255|min:3',
            'slug' => 'required|string|unique:posts',
            'body' => 'required|min:10',
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
             'category_id.min'=>'Please select atleast one category'
         ];
     }
}
