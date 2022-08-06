<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Page;
use App\Models\Slug;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /** @var int $articlesLimit */
    private $articlesLimit = 16;

    /**
     * @return View
     */
    public function index(): View
    {
        $page = Page::findBySlug("home", config("app.locale"));

        return view($page->content->view_path ?? "front.home", [
            "pageTitle" => $page->title ?? "Home",
            "pageDescription" => $page->description ?? "",
            "pageFollow" => $page->follow ?? true,
            "pageCover" => ($page ?? null) ? m_page_cover_thumb($page, [800, 600]) : null,
            "pageUrl" => route("front.home"),

            "articles" => Article::where("status", Article::STATUS_PUBLISHED)->orderBy("published_at", "DESC")->paginate($this->articlesLimit)
        ]);
    }

    /**
     * @param string $slug
     * @return View|RedirectResponse
     */
    public function article(string $slug)
    {
        $slugs = Slug::where(app()->getLocale(), $slug)->first();
        if (!$slugs) {
            message()->warning("O artigo acessado foi excluído, ocultado ou talvez não existe!")->fixed()->time(12)->flash();
            return redirect()->route("front.home");
        }

        $article = Article::where("slug_id", $slugs->id)->first();

        if (!$article) {
            message()->warning("O artigo acessado foi excluído, ocultado ou talvez não existe!")->fixed()->time(12)->flash();
            return redirect()->route("front.home");
        }

        return view("front.blog-page", [
            "pageTitle" => $article->title ?? "Home",
            "pageDescription" => $article->description ?? "",
            "pageFollow" => $article->follow ?? true,
            "pageCover" => ($article ?? null) ? m_article_cover_thumb($article, [800, 600]) : null,
            "pageUrl" => route("front.article", ["slug" => $slug]),
            "article" => $article
        ]);
    }

    /**
     * @param string $slug
     * @return View|RedirectResponse
     */
    public function category(string $slug)
    {
        $slugs = Slug::where(app()->getLocale(), $slug)->first();
        if (!$slugs) {
            message()->warning("A categoria acessada foi excluída, ocultada ou talvez não exista!")->fixed()->time(12)->flash();
            return redirect()->route("front.home");
        }

        $category = Category::where("slug_id", $slugs->id)->first();

        if (!$category) {
            message()->warning("A categoria acessada foi excluída, ocultada ou talvez não exista!")->fixed()->time(12)->flash();
            return redirect()->route("front.home");
        }

        return view("front.blog-page", [
            "pageTitle" => $category->title ?? "Home",
            "pageDescription" => $category->description ?? "",
            "pageFollow" => true,
            "pageCover" => null,
            "pageUrl" => route("front.category", ["slug" => $slug]),
            "category" => $category,
            "articles" => $category->articles()->where("status", Article::STATUS_PUBLISHED)->orderBy("published_at", "DESC")->paginate($this->articlesLimit)->withQueryString()
        ]);
    }

    /**
     * @return View|RedirectResponse
     */
    public function search()
    {
        $search = filter_input(INPUT_GET, "s");

        if (empty($search))
            return redirect()->route("front.home");

        $articles = Article::whereNotNull("id")->whereRaw("MATCH(title, description) AGAINST('{$search}')");

        return view("front.blog-page", [
            "pageTitle" => "Resultados para a busca: " . $search,
            "pageDescription" => "Página de resultado de busca para " . $search,
            "pageFollow" => false,
            "pageCover" => null,
            "pageUrl" => route("front.search", ["s" => $search]),

            "articles" => $articles->orderBy("published_at", "DESC")->paginate($this->articlesLimit)->withQueryString()
        ]);
    }
}
