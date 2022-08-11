<?php

namespace App\Http\Requests\Admin;

use App\Models\Article;
use App\Models\Media\Image;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class ArticleRequest extends FormRequest
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
        $this->merge([
            "categories" => !empty($this->categories) ? Collection::make(explode(",", $this->categories)) : null
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $title_unique = "unique:articles,title";

        // UPDATE
        if ($this->article) {
            $title_unique .= "," . $this->article->id;
        }

        return [
            "title" => ["required", $title_unique, "max:100"],
            "description" => ["required", "min:5", "max:255"],
            "content" => ["required"],
            "cover" => ["nullable", "integer"],
            "categories" => ["required"],
            "status" => ["required", Rule::in(Article::STATUS)],
            "scheduled_to" => ["required_if:status," . Article::STATUS_SCHEDULED]
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
