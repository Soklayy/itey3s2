<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\Cart;

class CartController extends Controller
{
    /**
     * Display buyer's cart
     */
    public function index()
    {
        $data = [];
        $grandTotal=0;
        foreach(Auth()->user()->cart as $cart){
            if($cart->product){//IF PRODUCT EXIST
                $fullPrice = $cart->product->price;      // price that not discount
                $dis = $cart->product->discount;         // percent of discount
                $qua = $cart->quantity;                  // quantity of product that in same category
                $total = $fullPrice*$qua*(100-$dis)/100; // total price for each category

                $data[] = [
                    'id'                 => $cart->id,
                    'product_id'         => $cart->product->id,
                    'price'              => $fullPrice,
                    'discount(%)'        => $dis,
                    'product_image_path' => $cart->product->product_image_path,
                    'quantity'           => $qua,
                    'Total($)'           => $total,
                    'increase (get method)'       => PHP_URL_HOST .route('cart.show',$cart->id),
                    'decrease (PUT|PATCH method)' => PHP_URL_HOST .route('cart.update',$cart->id),
                    'delete (delete method)'      => PHP_URL_HOST .route('cart.destroy',$cart->id)
                ];

                $grandTotal += $total;
            }
            else  $cart->delete();
            
        }
        
        return response([
            'Product in cart' => $data,
            'Grand Total($)'  => '$grandTotal',   
        ]);
    }


    /**
     * add and increase item to cart
     */
    public function store(CartRequest $request)
    {   
        $request->validated();
        $cart=Auth()->user()->cart->where('product_id',$request->product_id)->first();

        //check if item is exist it will increase
        if($cart){ 
            $qua  =  $cart->quantity;
            $cart->quantity = $qua+$request->quantity;
            $cart->save();
            
            return response([
                'message' => 'item increased'
            ]);
        }

        //add item to cart
        Cart::create([
            'user_id'   => Auth()->user()->id,
            'product_id'=> $request->product_id,
            'quantity'  => $request->quantity,
        ]);

        return response([
            'message' => 'Added item to cart'
        ]);

    }

    //increase
    public function show(Cart $cart){
        $this->authorize('update',$cart);//policy
        $cart->quantity += 1;
        $cart->save();
    }

    //decrease item
    public function update(Cart $cart){
        
        $this->authorize('update',$cart);//policy
        
        if($cart->quantity===1){
            $cart->delete();
            return [
                'message' => 'item deleted'
            ];
        }
        
        $cart->update([
            'quantity' => $cart->quantity-=1,
        ]);

        return [
            'message' => 'item decreased'
        ];
    }

    //deleted item from cart
    public function destroy(Cart $cart){

        $this->authorize('update',$cart);//policy
        $cart->delete();
        return [
            'message' => 'item deleted'
        ];
    }
}
