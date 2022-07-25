<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
