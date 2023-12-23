<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        return $this->getProductRules($this->input('class'));
    }

    public function getProductRules($class){
        $rules = [];
        switch ($class){
            case "createProduct":
                $rules = [
                    'name'=> 'required|string',
                    'description'=> 'required|string',
                    'in_stock'=> 'required|Integer',
                    'price'=> 'required',
                    'price_before'=> 'required',
                    'has_offer' => 'required',
                    'start_date' => 'required/date',
                    'end_date' => 'required/date',
                    'category_id' => 'required|exists:categories,id',
                    'brand_id' => 'required|exists:brands,id',
                    'media'=> 'required/mimes:png,jpg,jpeg|max:2048',
                ];
                break;
            case "deleteProduct":
                $rules = [
                    'product_id' => 'required|exists:products,id',
                ];
                break;
            case "restoreProduct":
                $rules = [
                    'product_id' => 'required|exists:products,id',
                ];
                break;
            case "updateProduct":
                $rules = [
                    'name'=> 'string',
                    'description'=> 'string',
                    'in_stock'=> 'Integer',
                    'start_date' => 'date',
                    'end_date' => 'date',
                    'category_id' => 'exists:categories,id',
                    'brand_id' => 'exists:brands,id',
                    'image'=> 'mimes:png,jpg,jpeg|max:2048',
                ];
                break;
            case "specificProduct":
                $rules = [
                    'product_id' => 'required|exists:products,id',
                ];
                break;
        }
        return $rules;
    }
}
