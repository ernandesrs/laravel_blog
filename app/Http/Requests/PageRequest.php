<?php

namespace App\Http\Requests;

use App\Models\Page;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
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
        $title_unique = "unique:pages,title";

        // UPDATE
        if ($this->page) {
            $title_unique .= "," . $this->page->id;
        }

        return [
            "title" => ["required", $title_unique, "max:255"],
            "description" => ["required", "min:5", "max:255"],
            "content_type" => ["required", Rule::in(Page::CONTENT_TYPES)],
            "follow" => ["nullable"],
            "content" => ["required_if:content_type," . Page::CONTENT_TYPE_TEXT],
            "view_path" => ["required_if:content_type," . Page::CONTENT_TYPE_VIEW],
            "cover" => ["nullable", "integer"],
            "status" => ["required", Rule::in(Page::STATUS)],
            "scheduled_to" => ["required_if:status," . Page::STATUS_SCHEDULED]
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
