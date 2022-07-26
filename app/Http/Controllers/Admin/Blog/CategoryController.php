<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use App\Models\Media\Image;
use App\Models\Slug;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.blog.categories-list", [
            "pageTitle" => "Categorias",
            "categories" => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();

        $lang = config("app.locale");

        // CREATE SLUG
        $slug = (new Slug())->set($validated["title"], $lang);
        if (!$slug->save()) {
            return response()->json([
                "success" => false,
                "message" => message()->warning("Houve um erro inesperado ao criar o slug para a categoria. Um log foi registrado.")->render()
            ]);
        }

        $category = new Category();
        $category->title = $validated["title"];
        $category->description = $validated["description"] ?? null;
        $category->lang = $lang;
        $category->slug_id = $slug->id;

        if ($cover = $validated["cover"] ?? null) {
            $image = Image::where("id", $cover)->first();
            if ($image)
                $category->cover = $image->path;
        }

        if (!$category->save()) {
            return response()->json([
                "success" => false,
                "message" => message()->warning("Houve um erro inesperado ao salvar a categoria. Um log foi registrado.")->render()
            ]);
        }

        message()->success("Uma nova categoria foi cadastrada com sucesso.")->float()->flash();
        return response()->json([
            "success" => true,
            "redirect" => route("admin.blog.categories.index")
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $category->thumb = $category->cover ? thumb(Storage::path("public/" . $category->cover), 200, 100) : null;

        return response()->json([
            "success" => true,
            "category" => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $validated = $request->validated();

        $category->title = $validated["title"];
        $category->description = $validated["description"] ?? null;

        if ($cover = $validated["cover"] ?? null) {
            $image = Image::where("id", $cover)->first();
            if ($image)
                $category->cover = $image->path;
        }

        if ($category->title != $category->getOriginal("title")) {
            // UPDATE SLUG
            $slug = Slug::where("id", $category->slug_id)->first();
            $slug->set($category->title, $category->lang);
            $slug->save();
        }

        if (!$category->save()) {
            return response()->json([
                "success" => false,
                "message" => message()->warning("Houve um erro inesperado ao atualizar a categoria. Um log foi registrado.")->render()
            ]);
        }

        message()->success("As alterações desta categoria foram salvas com sucesso.")->float()->flash();
        return response()->json([
            "success" => true,
            "redirect" => route("admin.blog.categories.index")
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $slug = $category->slugs();

        if (!$category->delete()) {
            return response()->json([
                "success" => false,
                "message" => message()->warning("Houve um erro inesperado ao tentar excluir a categoria. Um log foi registrado.")->render(),
            ]);
        }

        if ($slug)
            $slug->delete();

        message()->success("A categoria foi excluída com sucesso.")->float()->flash();
        return response()->json([
            "success" => true,
            "redirect" => route("admin.blog.categories.index")
        ]);
    }
}
