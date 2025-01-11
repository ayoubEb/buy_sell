<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FournisseurRequest extends FormRequest
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
      $fournisseurId = $this->route('fournisseur') ? $this->route('fournisseur')->id : null;
      return [
          "raison_sociale"  => ["required"],
          "code_postal"     => ['nullable',"numeric","digits:5"],
          "telephone"       => ["numeric","required"],
          "maxMontantPayer" => ["nullable","numeric",'min:0'],
          'ice' => [
            "nullable", "digits_between:1,16",
            Rule::unique('fournisseurs', 'ice')->ignore($fournisseurId),
          ],
          'rc' => [
            "nullable", "digits_between:1,16",
            Rule::unique('fournisseurs', 'rc')->ignore($fournisseurId),
          ],
          'email' => [
            "nullable","email",
            Rule::unique('fournisseurs', 'email')->ignore($fournisseurId),
          ],
      ];
    }
}
