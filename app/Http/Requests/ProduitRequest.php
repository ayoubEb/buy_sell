<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProduitRequest extends FormRequest
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
      // Check if we are updating an existing product
      $produitId = $this->route('produit') ? $this->route('produit')->id : null;
      return [
        "reference" => [
            "required",
            Rule::unique('produits', 'reference')->ignore($produitId),
        ],
        "designation"  => ["required"],
        "categorie"    => ["required", "exists:categories,id"],
        "prix_achat"   => ["required", "numeric", "min:0"],
        "prix_revient" => ["required", "numeric", "min:0"],
        "prix_vente"   => ["required", "numeric", "min:0"],
      ];
    }
}
