<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // dd($this->product);
        return [
            'title'                 =>  'required|string|max:255',
            'price'                 =>  'required|numeric',
            'compare_price'         =>  'nullable|numeric',
            'category_id'           =>  'required|exists:categories,id',
            'brand_id'              =>  'required|exists:brands,id',
            'sku'                   =>  'required|unique:products,sku,'. $this->product .',id',
            'status'                =>  'required|in:1,0',
            'is_featured'           =>  'required|in:no,yes',
            'description'           =>  'nullable|string',
            'short_description'     =>  'nullable|string',
            'qty'                   =>  'nullable|numeric',
            'barcode'               =>  'nullable|string',
            'sizes'                 =>  'nullable|array',
        ];
    }
}
