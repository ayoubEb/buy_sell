<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategorieRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
      $categorieId = $this->route('categorie') ? $this->route('categorie')->id : null;
      return [
        "nom" => ["required",
        Rule::unique('categories', 'nom')->ignore($categorieId),
      ],
        "img"=>["nullable","unique:categories,image"],
        ];
    }
}
