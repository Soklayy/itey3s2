<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

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
                    'increase (post method)' => route('cart.increase',$cart->id),
                    'decrease (post method)' => route('cart.decrease',$cart->id),
                    'remove (delete method)' => route('cart.removeItem',$cart->id),
                ];

                $grandTotal += $total;
            }
            else  $cart->delete();//checkstock
            
        }
        
        
        return $this->sendReponce([
            'product' => $data,
            'grand_total($)'  => $grandTotal,   
        ],'Your cart');
    }


    /**
     * add and increase item to cart
     */
    public function addItem(Product $product)
    {   
        $cart=Auth()->user()->cart->where('product_id',$product->id)->first();

        //check if item is exist it will increase
        if($cart){ 
            $qua  =  $cart->quantity;
            $cart->quantity = $qua+1;
            $cart->save();
            
            return $this->sendMesssage('Increased item');
        }

        //add item to cart
        Cart::create([
            'user_id'   => Auth()->user()->id,
            'product_id'=> $product->id,
            'quantity'  => 1,
        ]);

        return $this->sendMesssage('Added item');

    }

    //increase
    public function increase(Cart $cart){

        if(Gate::authorize('cart-owner',$cart)){
            $cart->quantity += 1;
            $cart->save();
            return $this->sendMesssage('Item increased');
        }
    }

    //decrease item
    public function decrease(Cart $cart){
        
        Gate::authorize('cart-owner',$cart);//policy
        
        if($cart->quantity===1){
            $cart->delete();
            return $this->sendMesssage('Item deleted');
        }
        
        $cart->update([
            'quantity' => $cart->quantity-=1,
        ]);

        return $this->sendMesssage('Item decreased');
    }

    //deleted item from cart
    public function removeItem(Cart $cart){

        Gate::authorize('cart-owner',$cart);//policy
        $cart->delete();
        return $this->sendMesssage('Remove item succeed');
    }
}
