<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getAll(Request $request): \Illuminate\Http\JsonResponse
    {
        $id=$request->query("categoryId");
        $items = Product::with(["category","product_images"])
            ->where("category_id", "=",$id)->get();
        return response()->json($items) ->header('Content-Type', 'application/json; charset=utf-8');
    }
}
