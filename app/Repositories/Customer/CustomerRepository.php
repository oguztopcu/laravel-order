<?php

namespace App\Repositories\Customer;

use App\Models\Customer;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class CustomerRepository extends Repository
{
    protected $model = Customer::class;

    public function paginate($companyId, $perPage = 10)
    {
        return $this->model()->where('company_id', '=', $companyId)->paginate($perPage);
    }

    public function create(Request $request)
    {
        $customer = $this->model()->create([
            'company_id' => $request->input('company_id'),
            'name' => $request->input('name')
        ]);

        return $customer;
    }

    public function update(Customer $customer, Request $request)
    {
        $customer->update([
            'name' => $request->input('name')
        ]);

        return $customer;
    }

    public function delete(Customer $customer)
    {
        $customer->delete();
    }
}
