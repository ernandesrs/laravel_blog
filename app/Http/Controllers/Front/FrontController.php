<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Page;
use App\Models\Slug;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class FrontController extends Controller
{
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

            "articles" => Article::where("status", Article::STATUS_PUBLISHED)->orderBy("published_at", "DESC")->paginate(12)
        ]);
    }

    /**
     * @param string $slug
     * @return void
     */
    public function article(string $slug)
    {
        $slugs = Slug::where(app()->getLocale(), $slug)->first();
        if (!$slugs) {
            return;
        }

        $article = Article::where("slug_id", $slugs->id)->first();

        if (!$article) {
            return;
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
     * @return void
     */
    public function category(string $slug)
    {
        $slugs = Slug::where(app()->getLocale(), $slug)->first();
        if (!$slugs) {
            return;
        }

        $category = Category::where("slug_id", $slugs->id)->first();

        if (!$category) {
            return;
        }

        return view("front.blog-page", [
            "pageTitle" => $category->title ?? "Home",
            "pageDescription" => $category->description ?? "",
            "pageFollow" => true,
            "pageCover" => null,
            "pageUrl" => route("front.category", ["slug" => $slug]),
            "category" => $category,
            "articles" => $category->articles()->where("status", Article::STATUS_PUBLISHED)->orderBy("published_at", "DESC")->paginate(12)->withQueryString()
        ]);
    }

    /**
     * @return View
     */
    public function termsAndConditions(): View
    {
        $page = Page::findBySlug("termos-e-condicoes", config("app.locale"));

        return view($page->content->view_path ?? "front.terms-and-conditions", [
            "pageTitle" => $page->title ?? "Terms & Conditions",
            "pageDescription" => $page->description ?? "",
            "pageFollow" => $page->follow ?? true,
            "pageCover" => ($page ?? null) ? m_page_cover_thumb($page, [800, 600]) : null,
            "pageUrl" => route("front.home"),
        ]);
    }

    /**
     * @param string $slug
     * @return View|RedirectResponse
     */
    public function dinamicPage(string $slug)
    {
        $page = Page::findBySlug($slug, config("app.locale"));
        if (!$page || $page->status != Page::STATUS_PUBLISHED) {
            message()->default("Página não encontrada!", "Erro!")->time(10)->flash();
            return redirect()->route("front.home");
        }

        $view = "front.page";
        if ($page->content_type == Page::CONTENT_TYPE_VIEW)
            $view = $page->content->view_path;

        // IMPLEMENTAR
        return view($view, [
            "pageTitle" => $page->title ?? "Page",
            "pageDescription" => $page->description ?? "",
            "pageFollow" => $page->follow,
            "pageCover" => m_page_cover_thumb($page, [800, 600]),
            "pageUrl" => route("front.home"),
        ]);
    }

    /**
     * @return void
     */
    public function builder(): void
    {
        if (env("APP_ENV") !== "local")
            return;

        if (User::where("level", User::LEVEL_9)->count())
            return;

        $user = new User();
        $user->first_name = "User";
        $user->last_name = "Admin";
        $user->name = $user->first_name . " " . $user->last_name;
        $user->level = User::LEVEL_9;
        $user->gender = "m";
        $user->email = "admin@admin.com";
        $user->password = Hash::make("admin");
        $user->email_verified_at = date("Y-m-d H:i:s");
        $user->save();

        echo "Builded";
        return;
    }
}
