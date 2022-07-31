<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Requests\Admin\CategoryStoreRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Models\Category;
use App\Models\Slug;
use Illuminate\Http\Request;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return response()->json([
            "success"=>true,
            "category"=> $category
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
        $category->description = $validated["description"]??null;

        if($category->title != $category->getOriginal("title")){
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
        //
    }
}
