<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Helpers\Thumb;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleRequest;
use App\Http\Requests\Admin\ImageRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Media\Image;
use App\Models\Slug;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.blog.articles-list", [
            "pageTitle" => "Lista de artigos",
            "articles" => Article::whereNotNull("id")->orderBy("created_at", "DESC")->paginate(12)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.blog.articles-edit", [
            "pageTitle" => "Novo artigo",
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $validated = $request->validated();

        // MAKE SLUG
        $slug = (new Slug())->set($validated["title"], config("app.locale"));
        if (!$slug->save()) {
            return response()->json([
                "success" => false,
                "message" => message()->warning("Houve um erro ao tentar criar um slug para o artigo")->float()->render(),
                "errors" => [
                    "title" => "Erro ao criar slug com este título"
                ]
            ]);
        }

        // MAKE ARTICLE
        $article = new Article();
        $article->slug_id = $slug->id;
        $article->user_id = $request->user()->id;
        $article->title = $validated["title"];
        $article->description = $validated["description"];
        $article->lang = config("app.locale");
        $article->content = $validated["content"];
        $article->status = $validated["status"];

        if ($validated["status"] == Article::STATUS_SCHEDULED)
            $article->scheduled_to = $validated["scheduled_to"];
        elseif ($validated["status"] == Article::STATUS_PUBLISHED)
            $article->published_at = date("Y-m-d H:i:s");

        if ($cover = $validated["cover"] ?? null) {
            $image = Image::where("id", $cover)->first();
            if ($image)
                $article->cover = $image->path;
        }

        if (!$article->save()) {
            return response()->json([
                "success" => false,
                "message" => message()->warning("Houve um erro ao tentar salvar o artigo. Um log será registrado.")->float()->render(),
            ]);
        }

        if (count($validated["categories"])) {
            $categories = Category::find($validated["categories"]);
            $article->categories()->attach($categories);
        }

        message()->success("O artigo <strong>{$article->title}</strong> foi criado com sucesso!")->float()->flash();
        return response()->json([
            "success" => true,
            "redirect" => route("admin.blog.articles.edit", ["article" => $article])
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view("admin.blog.articles-edit", [
            "pageTitle" => "Editar artigo",
            "article" => $article
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ArticleRequest  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $validated = $request->validated();

        /**
         * 
         * TODOS OS IDS DAS CATEGORIAS DO ARTIGO
         * 
         */
        $articleCategories = $article->categoriesId();

        /**
         * 
         * CATEGORIAS ADICIONADAS
         * 
         */
        $addedCategories = $validated["categories"]->diff($articleCategories);
        $article->categories()->attach($addedCategories);

        /**
         * 
         * CATEGORIAS REMOVIDAS
         * 
         */
        $removedCategories = $articleCategories->diff($validated["categories"]);
        $article->categories()->detach($removedCategories);

        /**
         * 
         * ATUALIZAR O ARTIGO
         * 
         */
        $article->title = $validated["title"];
        $article->description = $validated["description"];
        $article->content = $validated["content"];
        $article->status = $validated["status"];

        if ($article->status == Article::STATUS_SCHEDULED) {
            $article->scheduled_to = date("Y-m-d H:i:s", strtotime($validated["scheduled_to"]));
            $article->published_at = null;
        } else if ($article->status == Article::STATUS_PUBLISHED) {
            $article->published_at = date("Y-m-d H:i:s");
            $article->scheduled_to = null;
        } else {
            $article->published_at = null;
            $article->scheduled_to = null;
        }

        if ($article->getOriginal("title") != $article->title) {
            $slug = $article->slugs()->first()->set($article->title, $article->lang);
            $slug->save();
        }

        if ($validated["cover"] ?? null) {
            $image = Image::where("id", $validated["cover"])->first();
            if ($image)
                $article->cover = $image->path;
        }

        if (!$article->save()) {
            return response()->json([
                "success" => false,
                "message" => message()->warning("Houve um erro ao tentar atualizar o artigo. Um log será registrado.")->float()->render(),
            ]);
        }

        message()->success("O artigo <strong>{$article->title}</strong> foi atualizado com sucesso!")->float()->flash();
        return response()->json([
            "success" => true,
            "redirect" => route("admin.blog.articles.edit", ["article" => $article])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $slugs = $article->slugs()->first();

        if ($article->cover) {
            Thumb::clear($article->cover);
            Storage::disk("public")->delete($article->cover);
        }

        $article->delete();
        $slugs->delete();

        message()->success("O artigo foi excluído com sucesso!")->float()->flash();
        return response()->json([
            "success" => true,
            "redirect" => route("admin.blog.articles.index")
        ]);
    }
}
