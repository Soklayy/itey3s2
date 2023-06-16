<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\User;

class CartPolicy
{
    
    //policy for delete and decrease
    public function update(User $user, Cart $cart): bool
    {
        return $user->id === $cart->user_id;
    }

}
