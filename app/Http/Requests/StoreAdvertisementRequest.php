<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdvertisementRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            //'image_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'boolean',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Titulo',
            'description' => 'Descrição',
            'price' => 'Preço',
            'image_url' => 'Imagem',
        ];
    }
}
