<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProductController extends Controller
{
    protected string $upload;
    protected array $sizes = [50,150,300,600,1200];

    public function __construct()
    {
        $this->upload=env("UPLOAD_DIR");
    }
    public function getAll(Request $request): \Illuminate\Http\JsonResponse
    {
        $id=$request->query("categoryId");
        $items = Product::with(["category","product_images"])
            ->where("category_id", "=",$id)->get();
        return response()->json($items) ->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function store(Request $request) {
        $dir = public_path($this->upload);
        $images = $request->file("images");
//        if($request->hasFile('images') && $request->input("name")!="") {
//            $file = $request->file("image");
//            $fileName = $this->saveImage($file);
//            $item = Product::create(['name'=>$request->input('name'), "image"=> $fileName]);
//            return response()->json($item,201);
//        }
        return response()->json("Bad request", 400);
    }

    protected function saveImage(UploadedFile $file) {
        $fileName = uniqid(). ".webp";
        $manager = new ImageManager(new Driver());
        foreach ($this->sizes as $size) {
            $imageSave = $manager->read($file);
            $imageSave->scale(width: $size);
            $path = public_path($this->upload.$size."_".$fileName);
            $imageSave->toWebp()->save($path);
        }
        return $fileName;
    }
}
