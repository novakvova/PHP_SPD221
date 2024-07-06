<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProductController extends Controller
{
    protected string $upload;
    protected array $sizes = [50, 150, 300, 600, 1200];

    public function __construct()
    {
        $this->upload = env("UPLOAD_DIR");
    }

    public function getAll(Request $request): \Illuminate\Http\JsonResponse
    {
        $id = $request->query("categoryId");
        $items = Product::with(["category", "product_images"])
            ->where("category_id", "=", $id)->get();
        return response()->json($items)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id'
        ]);
        $product = Product::create($validatedData);

        if ($request->hasFile('images')) {
            $images = $request->file("images");
            $i = 0;
            foreach ($images as $file) {
                $fileName = $this->saveImage($file);
                ProductImage::create([
                    'name' => $fileName,
                    'priority' => $i++, // You can adjust this as needed
                    'product_id' => $product->id,
                ]);
            }
        }
        return response()->json($product, 201);
    }

    protected function saveImage(UploadedFile $file)
    {
        $fileName = uniqid() . ".webp";
        $manager = new ImageManager(new Driver());
        foreach ($this->sizes as $size) {
            $imageSave = $manager->read($file);
            $imageSave->scale(width: $size);
            $path = public_path($this->upload . $size . "_" . $fileName);
            $imageSave->toWebp()->save($path);
        }
        return $fileName;
    }
}
