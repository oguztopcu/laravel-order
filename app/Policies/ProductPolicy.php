<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    use HandlesAuthorization;

    public function checkCompany(User $user, Product $product)
    {
        return $user->company->id === $product->company_id ? Response::allow() : Response::deny('Bu işlemi yapmaya yetkiniz bulunmamaktadır.');
    }
}
