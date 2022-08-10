<?php

namespace App\Http\Controllers\Admin\Media;

use App\Helpers\Thumb;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ImageRequest;
use App\Models\Media\Image;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * @var string
     */
    private $imagesPath = "images";

    /**
     * @return JsonResponse|View
     */
    public function index(Request $request)
    {
        $images = $this->filter($request);

        return view("admin.medias.images-list", [
            "pageTitle" => "Gerenciando imagens",
            "images" => $images->paginate(12)->withQueryString()
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function get(Request $request): JsonResponse
    {
        $images = $this->filter($request);

        $images = $images->paginate(9)->withQueryString();

        $imagesArr = [];
        foreach ($images as $image) {
            $imagesArr[] = [
                "id" => $image->id,
                "url" => Storage::url($image->path),
                "thumb" => thumb(Storage::path("public/{$image->path}"), 200, 100),
                "name" => $image->name,
                "tags" => $image->tags
            ];
        }

        return response()->json([
            "success" => true,
            "images" => $imagesArr,
            "pagination" => $images->links()->render()
        ]);
    }

    /**
     * @param Request $request
     * @return
     */
    private function filter(Request $request)
    {
        $search = $request->get("search");
        $filter = $request->get("filter");

        $images = Image::whereNotNull("id");
        if ($filter && !empty($search)) {
            $images->whereRaw("MATCH(name,tags) AGAINST('{$search}')");
        }

        return $images->orderBy("created_at", "DESC");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ImageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageRequest $request)
    {
        $redirect = filter_input(INPUT_GET, "redirect", FILTER_VALIDATE_BOOL);

        $validated = $request->validated();

        $image = new Image();
        $image->name = $validated["name"] ?? $validated["image"]->getClientOriginalName();
        $image->tags = $validated["tags"];
        $image->extension = $validated["image"]->getClientOriginalExtension();
        $image->size = $validated["image"]->getSize();
        $image->path = $validated["image"]->store($this->imagesPath, "public");

        $image->save();

        message()->success("Upload de nova image concluída com sucesso!")->float()->flash();

        $response = [
            "success" => true,
            "redirect" => route("admin.images.index"),
            "id" => $image->id,
            "url" => Storage::url($image->path),
            "thumb" => thumb(Storage::path("public/{$image->path}"), 200, 125),
            "name" => $image->name,
        ];

        if ($redirect === false)
            $response["redirect"] = false;

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        return response()->json([
            "success" => true,
            "image" => [
                "id" => $image->id,
                "name" => $image->name,
                "tags" => $image->tags,
            ],
            "action" => route("admin.images.update", ["image" => $image->id])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ImageRequest  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(ImageRequest $request, Image $image)
    {
        $validated = $request->validated();

        $image->name = $validated["name"];
        $image->tags = $validated["tags"];
        $image->save();

        message()->success("Informações de imagem atualizados com sucesso!")->float()->flash();
        return response()->json([
            "success" => true,
            "reload" => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        /**
         * remove os thumbnails
         */
        Thumb::clear($image->path);

        /**
         * remove a imagem
         */
        Storage::disk("public")->delete($image->path);

        $image->delete();

        message()->success("Imagem excluída com sucesso!")->float()->flash();
        return response()->json([
            "success" => false,
            "reload" => true
        ]);
    }
}
