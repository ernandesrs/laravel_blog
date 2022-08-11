<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Thumb;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Models\Media\Image;
use App\Models\Page;
use App\Models\Slug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Rolandstarke\Thumbnail\Facades\Thumbnail;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * @var string
     */
    private $coversPath = "covers";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.pages.pages-list", [
            "pageTitle" => "Listando páginas",
            "pages" => Page::whereNotNull("id")->orderBy("protection", "DESC")->orderBy("created_at", "DESC")->paginate(12)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.pages.pages-edit", [
            "pageTitle" => "Nova página"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        $validated = $request->validated();

        // MAKE SLUG
        $slug = (new Slug())->set($validated["title"], config("app.locale"));
        if (!$slug->save()) {
            return response()->json([
                "success" => false,
                "message" => message()->warning("Houve um erro ao tentar criar um slug para a página")->float()->render(),
                "errors" => [
                    "title" => "Erro ao criar slug com este título"
                ]
            ]);
        }

        // DADOS DA PÁGINA
        $page = new Page();
        $page->user_id = auth()->user()->id;
        $page->slug_id = $slug->id;
        $page->title = $validated["title"];
        $page->description = $validated["description"];
        $page->content_type = $validated["content_type"];
        $page->follow = $validated["follow"] ?? null ? true : false;
        $page->status = $validated["status"];
        $page->content = $page->getContent($validated);

        // UPLOAD DE CAPA
        if ($cover = $validated["cover"] ?? null) {
            $image = Image::where("id", $cover);
            if ($image)
                $page->cover = $image->path;
        }

        if (!$page->save()) {
            return response()->json([
                "success" => false,
                "message" => message()->warning("Houve um erro ao criar a página. Um log foi registrado.")->float()->render()
            ]);
        }

        message()->success("Nova página cadastrada com sucesso!")->float()->flash();
        return response()->json([
            "success" => true,
            "redirect" => route("admin.pages.edit", ["page" => $page->id])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view("admin.pages.pages-edit", [
            "pageTitle" => "Editar página",
            "page" => $page
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $validator = $this->validatePage($request, $page);

        if ($errors = $validator->errors()->messages()) {
            return response()->json([
                "success" => false,
                "message" => message()->warning("Erro ao validar dados, verifique e tente de novo.")->float()->render(),
                "errors" => $errors
            ]);
        }

        // DADOS VALIDADOS
        $validated = $validator->validated();

        // INSERE DADOS VALIDADOS
        $page->set($validated);

        // SLUGS
        if ($page->protection != Page::PROTECTION_SYSTEM) {
            $slugs = $page->slugs();
            $slugs->set(Str::slug($page->title), $page->lang);
            $slugs->save();
        }

        // UPLOAD DE CAPA
        if ($cover = $validated["cover"] ?? null) {
            if ($page->cover) {
                Thumb::clear($page->cover);
                Storage::disk("public")->delete($page->cover);
            }

            $page->cover = $cover->store($this->coversPath, "public");
        }

        if (!$page->save()) {

            Storage::disk("public")->delete($page->cover);

            return response()->json([
                "success" => false,
                "message" => message()->warning("Erro ao validar dados, verifique e tente de novo.")->float()->render()
            ]);
        }

        message()->success("A página foi atualizada com sucesso!")->float()->flash();
        return response()->json([
            "success" => true,
            "redirect" => route("admin.pages.edit", ["page" => $page->id])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        if ($page->protection == Page::PROTECTION_SYSTEM) {
            return response()->json([
                "success" => false,
                "message" => message()->warning("Página protegida do sistema não pode ser excluída!")->fixed()->render()
            ]);
            return;
        }

        $slugs = $page->slugs();

        if ($page->cover) {
            Thumb::clear($page->cover);
            Storage::disk("public")->delete($page->cover);
        }

        $page->delete();

        if ($slugs && !$slugs->hasPages())
            $slugs->delete();

        message()->success("A página foi excluída com sucesso!")->float()->flash();
        return response()->json([
            "success" => true,
            "reload" => true
        ]);
    }

    /**
     * @param Request $request
     * @param Page|null $page
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validatePage(Request $request, ?Page $page = null): \Illuminate\Contracts\Validation\Validator
    {
        $only = ["title", "description", "cover", "lang", "content_type", "content", "follow", "view_path", "status", "scheduled_to"];
        $rules = [
            "title" => ["required", "max:255"]
        ];

        if ($page)
            $rules["title"] = array_merge($rules["title"], [Rule::unique('pages')->ignore($page->id)]);
        else
            $rules["title"] += array_merge($rules["title"], ["unique:pages,title"]);

        $rules += [
            "description" => ["required", "max:255"],
            "cover" => ["mimes:jpg,png,webp", "max:2048", Rule::dimensions()->minWidth(800)->minHeight(600)],
            "lang" => [Rule::in(config("app.locales"))],
            "content_type" => ["required", Rule::in(Page::CONTENT_TYPES)],
            "content" => [],
            "follow" => ["string"],
            "view_path" => ["required_if:content_type," . Page::CONTENT_TYPE_VIEW],
            "status" => ["required", Rule::in(Page::STATUS)],
            "scheduled_to" => ["required_if:status," . Page::STATUS_SCHEDULED],
        ];

        if ($page && $page->protection == Page::PROTECTION_SYSTEM) {
            unset(
                $only["content_type"],
                $only["status"],
                $rules["content_type"],
                $rules["status"]
            );
        }

        return Validator::make($request->only($only), $rules);
    }
}
