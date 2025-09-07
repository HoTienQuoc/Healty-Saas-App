<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    //
    /**
     * Find the product by id
     */
    public function findProductById(Product $product)
    {
        return ProductResource::make($product);
    }

    /**
     * Find the product by name
     */
    public function findProductByName($name)
    {
        $product = Product::whereName($name)->first();
        //check if the product exists in our database
        if($product) {
            return ProductResource::make($product);
        }else {
            abort(404);
        }
    }
}
