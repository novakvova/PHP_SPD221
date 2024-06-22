<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class CategoryController extends Controller
{
    protected string $upload;
    protected array $sizes = [50,150,300,600,1200];

    public function __construct()
    {
        $this->upload=env("UPLOAD_DIR");
    }

    public function getList() {
        $data = Category::all();
        return response()->json($data)
            ->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function store(Request $request) {
        $dir = public_path($this->upload);
        if(!file_exists($dir)) {
            mkdir($dir,0777);
        }
        if($request->hasFile('image') && $request->input("name")!="") {
            $file = $request->file("image");
            $fileName = uniqid(). ".webp";
            $manager = new ImageManager(new Driver());
            foreach ($this->sizes as $size) {
                $imageSave = $manager->read($file);
                $imageSave->scale(width: $size);
                $path = public_path($this->upload.$size."_".$fileName);
                $imageSave->toWebp()->save($path);
            }
            $item = Category::create(['name'=>$request->input('name'), "image"=> $fileName]);
            return response()->json($item,201);
        }
        return response()->json("Bad request", 400);
    }
}
