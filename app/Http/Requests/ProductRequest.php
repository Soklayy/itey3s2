<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'description' => [$this->isPostMethod(),'string'], 
            'price'       => [$this->isPostMethod(),'numeric'], 
            'discount'    => [$this->isPostMethod(),'numeric'], 
            'quantity'    => [$this->isPostMethod(),'numeric'], 
            'product_image_path' => [$this->isPostMethod(),'string']
        ];
    }


    // Post method or not
    private function isPostMethod(){
        if($this->isMethod('post')){
            return 'required';
        }

        return '';
    }
}
