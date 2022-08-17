<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Models\AccessRegister;
use App\Models\Media\Image;
use App\Models\Page;
use App\Models\Slug;

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
            "pageTitle" => "Listando paginas",
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

        // MAKE ACCESS REGISTER
        $accessRegister = new AccessRegister();
        $accessRegister->save();

        // DADOS DA PÁGINA
        $page = new Page();
        $page->user_id = auth()->user()->id;
        $page->slug_id = $slug->id;
        $page->access_register_id = $accessRegister->id;
        $page->title = $validated["title"];
        $page->description = $validated["description"];
        $page->content_type = $validated["content_type"];
        $page->follow = $validated["follow"] ?? null ? true : false;
        $page->content = $page->getContent($validated);
        $page->status = $validated["status"];

        if ($validated["status"] == Page::STATUS_SCHEDULED)
            $page->scheduled_to = date("Y-m-d H:i:s", strtotime($validated["scheduled_to"]));
        elseif ($validated["status"] == Page::STATUS_PUBLISHED)
            $page->published_at = date("Y-m-d H:i:s");

        // UPLOAD DE CAPA
        if ($cover = $validated["cover"] ?? null) {
            $image = Image::where("id", $cover)->first();
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
     * @param  PageRequest  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, Page $page)
    {
        $validated = $request->validated();

        // DADOS DA PÁGINA
        $page->title = $validated["title"];
        $page->description = $validated["description"];
        $page->follow = $validated["follow"] ?? null ? true : false;

        if ($page->protection != Page::PROTECTION_SYSTEM) {
            $page->content_type = $validated["content_type"];
            $page->content = $page->getContent($validated);
            $page->status = $validated["status"];

            if ($page->status == Page::STATUS_SCHEDULED) {
                if ($page->getOriginal("status") != Page::STATUS_SCHEDULED)
                    $page->scheduled_to = date("Y-m-d H:i:s", strtotime($validated["scheduled_to"]));

                $page->published_at = null;
            } else if ($page->status == Page::STATUS_PUBLISHED) {
                if ($page->getOriginal("status") != Page::STATUS_PUBLISHED)
                    $page->published_at = date("Y-m-d H:i:s");
                $page->scheduled_to = null;
            } else {
                $page->published_at = null;
                $page->scheduled_to = null;
            }

            /** @var Slug $slugs */
            $slugs = $page->slugs()->first();
            $slugs->set($validated["title"], $page->lang);
            $slugs->save();
        } else {
            if ($page->content_type == Page::CONTENT_TYPE_TEXT)
                $page->content = $page->getContent([
                    "content_type" => $page->content_type,
                    "content" => $validated["content"],
                ]);
        }

        // UPLOAD DE CAPA
        if ($cover = $validated["cover"] ?? null) {
            $image = Image::where("id", $cover)->first();
            if ($image)
                $page->cover = $image->path;
        }

        if (!$page->save()) {
            return response()->json([
                "success" => false,
                "message" => message()->warning("Houve um erro ao salvar a página. Um log foi registrado.")->float()->render()
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

        $slugs = $page->slugs()->first();

        $page->delete();

        if ($slugs && !$slugs->hasPages())
            $slugs->delete();

        message()->success("A página foi excluída com sucesso!")->float()->flash();
        return response()->json([
            "success" => true,
            "reload" => true
        ]);
    }
}
