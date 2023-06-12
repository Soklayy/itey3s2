<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response(Auth()->user()->product);//
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $request->validated();

        Product::create([
            'user_id' => Auth()->user()->id,
            'description' => $request->description,
            'price'       => $request->price, 
            'discount'    => $request->discount, 
            'quantity'    => $request->quantity, 
            'product_image_path' => $request->product_image_path
        ]);

        return response([
            'Message' => 'Create success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response($product);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $request->validated();
        $product->update($request->all());
        return response([
            'Message' => 'Update success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response([
            'Message' => 'delete success',
        ]);
    }
}
