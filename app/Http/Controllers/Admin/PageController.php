<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Slug;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Rolandstarke\Thumbnail\Facades\Thumbnail;
use Illuminate\Support\Str;

class PageController extends Controller
{
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
        return view("admin.pages.pages-new", [
            "pageTitle" => "Nova página"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validatePage($request);

        if ($errors = $validator->errors()->messages()) {
            return response()->json([
                "success" => false,
                "message" => message()->warning("Erro ao validar dados, verifique e tente de novo.")->float()->render(),
                "errors" => $errors
            ]);
        }

        // DADOS VALIDADOS
        $validated = $validator->validated();

        // DADOS DA PÁGINA
        $page = (new Page())->set($validated, $request->user());

        // DADOS DO SLUG
        $slug = new Slug();
        $slug = $slug->set($page->title, $page->lang);

        if (!$slug->save()) {
            return response()->json([
                "success" => false,
                "message" => message()->warning("Erro ao criar slug para o título informado.")->float()->render(),
                "errors" => ["title" => "Tente outro título"]
            ]);
        }

        $page->slug = $slug->id;

        // UPLOAD DE CAPA
        if ($cover = $validated["cover"] ?? null)
            $page->cover = $cover->store("public/pages/covers");

        if (!$page->save()) {

            $slug->delete();
            Storage::delete($page->cover);

            return response()->json([
                "success" => false,
                "message" => message()->warning("Erro ao criar slug para o título informado.")->float()->render(),
                "errors" => ["title" => "Tente outro título"]
            ]);
        }

        message()->success("Nova página cadastrada com sucesso!")->float()->flash();
        return response()->json([
            "success" => true,
            "redirect" => route("admin.pages.index")
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
                Thumbnail::src(Storage::path($page->cover))->delete();
                Storage::delete($page->cover);
            }

            $page->cover = $cover->store("public/pages/covers");
        }

        if (!$page->save()) {

            Storage::delete($page->cover);

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
            Thumbnail::src(Storage::path($page->cover))->delete();
            Storage::delete($page->cover);
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
