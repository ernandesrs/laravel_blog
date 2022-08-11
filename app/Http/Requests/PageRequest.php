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
        $rules = [
            "title" => ["required", "max:255"],
            "description" => ["required", "min:5", "max:255"],
            "content_type" => ["required", Rule::in(Page::CONTENT_TYPES)],
            "follow" => ["nullable"],
            "content" => ["required_if:content_type," . Page::CONTENT_TYPE_TEXT],
            "view_path" => ["required_if:content_type," . Page::CONTENT_TYPE_VIEW],
            "cover" => ["nullable", "integer"],
            "status" => ["required", Rule::in(Page::STATUS)],
            "scheduled_to" => ["required_if:status," . Page::STATUS_SCHEDULED]
        ];

        // UPDATE
        if ($this->page) {
            $rules["title"] = array_merge($rules["title"], ["unique:pages,title," . $this->page->id]);

            if($this->page->protection == Page::PROTECTION_SYSTEM){
                unset($rules["content_type"]);
                unset($rules["status"]);
                unset($rules["view_path"]);
            }
        } else {
            $rules["title"] = array_merge($rules["title"], ["unique:pages,title"]);
        }

        return $rules;
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
