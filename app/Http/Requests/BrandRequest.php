<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
        return $this->getBrandRules($this->input('class'));
    }

    public function getBrandRules($class){
        $rules = [];
        switch ($class){
            case "createBrand":
                $rules = [
                    'name'=> 'required|string',
                    'media'=> 'required/mimes:png,jpg,jpeg|max:2048',
                ];
                break;
            case "deleteBrand":
                $rules = [
                    'brand_id' => 'required|exists:brands,id',
                ];
                break;
            case "restoreBrand":
                $rules = [
                    'brand_id' => 'required|exists:brands,id',
                ];
                break;
            case "updateBrand":
                $rules = [
                    'name'=> 'string',
                    'description'=> 'string',
                    'in_stock'=> 'Integer',
                    'start_date' => 'date',
                    'end_date' => 'date',
                    'category_id' => 'exists:categories,id',
                    'brand_id' => 'exists:brands,id',
                    'media'=> 'mimes:png,jpg,jpeg|max:2048',
                    'image'=> 'mimes:png,jpg,jpeg|max:2048',
                ];
                break;
            case "specificBrand":
                $rules = [
                    'product_id' => 'required|exists:products,id',
                ];
                break;
            case "deleteMedia":
                $rules = [
                    'media_id' => 'required|exists:medias,id',
                ];
                break;
        }
        return $rules;
    }
}
