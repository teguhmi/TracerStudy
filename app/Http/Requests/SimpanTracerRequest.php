<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SimpanTracerRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
      return [
        'jawaban.F505'       => 'nullable|numeric|min:0',
        'jawaban.F505_range' => 'nullable|integer|in:1,2,3,4,5,6,7',
      ];
    }
  public function withValidator($validator)
  {
    $validator->after(function ($validator) {
      $nominal = $this->input('jawaban.F505');
      $range = $this->input('jawaban.F505_range');

      if ($nominal !== null && $range !== null) {
        $ranges = [
          1 => ['min' => 0, 'max' => 999999],
          2 => ['min' => 1000000, 'max' => 2999999],
          3 => ['min' => 3000000, 'max' => 4999999],
          4 => ['min' => 5000000, 'max' => 9999999],
          5 => ['min' => 10000000, 'max' => 19999999],
          6 => ['min' => 20000000, 'max' => 49999999],
          7 => ['min' => 50000000, 'max' => 999999999],
        ];

        if (isset($ranges[$range])) {
          $min = $ranges[$range]['min'];
          $max = $ranges[$range]['max'];

          if ($nominal < $min || $nominal > $max) {
            $validator->errors()->add(
              'jawaban.F505',
              'Nilai pendapatan aktual tidak sesuai dengan rentang pendapatan yang dipilih.'
            );
          }
        }
      }
    });
  }
}
