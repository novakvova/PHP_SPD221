<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
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
            $fileName = $this->saveImage($file);
            $item = Category::create(['name'=>$request->input('name'), "image"=> $fileName]);
            return response()->json($item,201);
        }
        return response()->json("Bad request", 400);
    }

    public function update(Request $request, $id) {
        $item = Category::find($id);
        if($request->input("name")!="") {
            if($request->hasFile('image')) {
                $this->deleteImage($id);
                $file = $request->file("image");
                $item->image = $this->saveImage($file);
            }
            $item->name = $request->input("name");
            $item->save();
            return response()->json($item,200);
        }
        return response()->json("Bad request", 400);
    }

    public function delete(int $id) {
        $this->deleteImage($id);
        Category::destroy($id);
        return response()->json("Категорія покінула корабель!", 200);
    }

    protected function  deleteImage(int $id) {
        $item = Category::find($id);
        foreach ($this->sizes as $size) {
            $path = public_path($this->upload.$size."_".$item->image);
            if(file_exists($path))
                unlink($path);
        }
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
