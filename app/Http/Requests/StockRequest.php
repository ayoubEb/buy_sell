<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StockRequest extends FormRequest
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
      $stockId = $this->route('stock') ? $this->route('stock')->id : null;
         return [
          "quantite"=>isset($this->quantite) ? ['required','numeric','min:1'] : ['nullable'],
          "reference" => isset($this->reference) ?  ["required",
          Rule::unique('stocks', 'num')->ignore($stockId)] : ['nullable'],
          "qte_min"   => ['required','numeric','min:1'],
          "qte_max"   => ['required','numeric','min:0'],
          "qte_alert" => ['required','numeric','min:1'],
          
        ];
    }
}
