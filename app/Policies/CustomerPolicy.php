<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function checkCompany(User $user, Customer $customer)
    {
        return $user->company->id === $customer->company_id ? Response::allow() : Response::deny('Bu işlemi yapmaya yetkiniz bulunmamaktadır.');
    }
}
