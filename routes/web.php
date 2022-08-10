<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\Blog\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\Blog\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\Media\ImageController as AdminImageController;
use App\Http\Controllers\Auth\ForgotController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Member\MemberController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Front\BlogController;

/**
 *
 * AUTH ROUTES
 *
 */
Route::get("/login", [LoginController::class, "login"])->middleware('guest')->name("auth.login");
Route::post("/authenticate", [LoginController::class, "authenticate"])->middleware('guest')->name("auth.authenticate");
Route::get("/logout", [LoginController::class, "logout"])->middleware('auth')->name("auth.logout");

Route::get("/register", [RegisterController::class, "register"])->middleware('guest')->name("auth.register");
Route::post("/store", [RegisterController::class, "store"])->middleware('guest')->name("auth.store");

// AVISO PARA USUÁRIO VERIFICAR O EMAIL
Route::get('/email/verify', [VerificationController::class, "notice"])->middleware('auth')->name('verification.notice');

// VERIFICA O EMAIL
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, "verify"])->middleware(['auth', 'signed'])->name('verification.verify');

// REENVIA O LINK DE VERIFICAÇÃO
Route::post('/email/verification-notification', [VerificationController::class, "sendLink"])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// VIEW DE ESQUECI A SENHA
Route::get('/forgot-password', [ForgotController::class, "forgotForm"])->middleware('guest')->name('password.request');

// ENVIO DE EMAIL COM LINK DE RECUPERAÇÃO DE SENHA
Route::post('/forgot-password', [ForgotController::class, "sendLink"])->middleware('guest')->name('password.email');

// VIEW DE RESET DE SENHA
Route::get('/reset-password/{token}', [ResetController::class, "resetForm"])->middleware('guest')->name('password.reset');

// RECUPERAÇÃO DE SENHA
Route::post('/reset-password', [ResetController::class, "updatePassword"])->middleware('guest')->name('password.update');

/**
 *
 * MEMBER ROUTES
 *
 */
Route::group([
    'prefix' => 'member',
    'middleware' => 'member',
], function () {

    Route::get("/", [MemberController::class, "home"])->name("member.home");
    Route::get("/example-1", [MemberController::class, "example"])->name("member.example");
    Route::get("/example-2", [MemberController::class, "exampleTwo"])->name("member.exampleTwo");

    Route::get("/perfil", [MemberController::class, "profile"])->name("member.profile");
    Route::post("/atualizar-perfil", [MemberController::class, "profileUpdate"])->name("member.profileUpdate");
});

/**
 *
 * ADMIN ROUTES
 *
 */
Route::group([
    'prefix' => 'admin',
    'middleware' => 'admin'
], function () {

    Route::get("/", [AdminController::class, "home"])->name("admin.home");

    // USUÁRIOS
    Route::get("/usuarios/lista", [AdminUserController::class, "index"])->name("admin.users.index");
    Route::get("/usuario/novo", [AdminUserController::class, "create"])->name("admin.users.create");
    Route::post("/usuario/salvar", [AdminUserController::class, "store"])->name("admin.users.store");
    Route::get("/usuario/ver/{user}", [AdminUserController::class, "show"])->name("admin.users.show");
    Route::get("/usuario/editar/{user}", [AdminUserController::class, "edit"])->name("admin.users.edit");
    Route::post("/usuario/atualizar/{user}", [AdminUserController::class, "update"])->name("admin.users.update");
    Route::post("/usuario/excluir-foto/{user}", [AdminUserController::class, "photoRemove"])->name("admin.users.photoRemove");
    Route::post("/usuario/excluir/{user}", [AdminUserController::class, "destroy"])->name("admin.users.destroy");

    // PÁGINAS
    Route::get("/paginas/list", [AdminPageController::class, "index"])->name("admin.pages.index");
    Route::get("/pagina/novo", [AdminPageController::class, "create"])->name("admin.pages.create");
    Route::post("/pagina/salvar", [AdminPageController::class, "store"])->name("admin.pages.store");
    Route::get("/pagina/editar/{page}", [AdminPageController::class, "edit"])->name("admin.pages.edit");
    Route::post("/pagina/update/{page}", [AdminPageController::class, "update"])->name("admin.pages.update");
    Route::post("/pagina/excluir/{page}", [AdminPageController::class, "destroy"])->name("admin.pages.destroy");
    Route::post("/pagina/excluir-capa/{page}", [AdminPageController::class, "coverRemove"])->name("admin.pages.coverRemove");

    // ARTICLES
    Route::get("/artigos/list", [AdminArticleController::class, "index"])->name("admin.blog.articles.index");
    Route::get("/artigo/novo", [AdminArticleController::class, "create"])->name("admin.blog.articles.create");
    Route::post("/artigo/salvar", [AdminArticleController::class, "store"])->name("admin.blog.articles.store");
    Route::get("/artigo/editar/{article}", [AdminArticleController::class, "edit"])->name("admin.blog.articles.edit");
    Route::post("/artigo/update/{article}", [AdminArticleController::class, "update"])->name("admin.blog.articles.update");
    Route::post("/artigo/excluir/{article}", [AdminArticleController::class, "destroy"])->name("admin.blog.articles.destroy");
    Route::post("/artigo/excluir-capa/{article}", [AdminArticleController::class, "coverRemove"])->name("admin.blog.articles.coverRemove");

    // BLOG: CATEGORIAS
    Route::get("/blog/categorias", [AdminCategoryController::class, "index"])->name("admin.blog.categories.index");
    Route::post("/blog/categoria/salvar", [AdminCategoryController::class, "store"])->name("admin.blog.categories.store");
    Route::get("/blog/categoria/editar/{category}", [AdminCategoryController::class, "edit"])->name("admin.blog.categories.edit");
    Route::post("/blog/categoria/atualizar/{category}", [AdminCategoryController::class, "update"])->name("admin.blog.categories.update");
    Route::post("/blog/categoria/excluir/{category}", [AdminCategoryController::class, "destroy"])->name("admin.blog.categories.destroy");

    // IMAGE
    Route::get("/images", [AdminImageController::class, "index"])->name("admin.images.index");
    Route::post("/get", [AdminImageController::class, "get"])->name("admin.images.get");
    Route::post("/image/salvar", [AdminImageController::class, "store"])->name("admin.images.store");
    Route::post("/image/atualizar/{image}", [AdminImageController::class, "update"])->name("admin.images.update");
    Route::post("/image/excluir/{image}", [AdminImageController::class, "destroy"])->name("admin.images.destroy");
});

/**
 *
 * FRONT ROUTES
 *
 */
Route::get("/", [BlogController::class, "index"])->name("front.home");
Route::get("/{slug}", [BlogController::class, "article"])->name("front.article");
Route::get("/categoria/{slug}", [BlogController::class, "category"])->name("front.category");
Route::get("/busca/resultados", [BlogController::class, "search"])->name("front.search");

Route::get("/home", function () {
    return redirect()->route("front.home");
});
Route::get("/termos-e-condicoes", [FrontController::class, "termsAndConditions"])->name("front.termsAndConditions");
Route::get("/p/{slug}", [FrontController::class, "dinamicPage"])->name("front.dinamicPage");
Route::get("/builder", [FrontController::class, "builder"]);
