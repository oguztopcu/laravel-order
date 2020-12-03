<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Order $order)
    {
        return is_null($order->shipping_date) ? Response::allow() : Response::deny('Siparişe gönderim tarihi girildiği için işlem yapmanız yasaklanmıştır.');
    }

    public function checkCompany(User $user, Order $order)
    {
        return $user->company->id === $order->company_id ? Response::allow() : Response::deny('Bu işlemi yapmaya yetkiniz bulunmamaktadır.');
    }
}
