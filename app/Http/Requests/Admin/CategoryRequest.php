<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->category)
            $unique = "unique:categories,title," . $this->category->id;
        else
            $unique = "unique:categories,title";
        
        return [
            "title" => ["required", "string", $unique, "min:2", "max:25"],
            "description" => ["nullable", "string", "max:125"],
            "cover" => ["nullable", "integer"],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($validator->errors()->messages()) {
                $validator->errors()->add("message", message()->warning("Houve erro(s) ao validar o(s) dado(s) informado(s).")->render());
            }
        });
    }
}
