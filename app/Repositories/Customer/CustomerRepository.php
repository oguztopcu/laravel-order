<?php

namespace App\Repositories\Customer;

use App\Models\Customer;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class CustomerRepository extends Repository
{
    protected $model = Customer::class;

    /**
     * Şirkete ait tüm müşterileri listeler
     *
     * @param int $companyId
     * @param int $perPage
     * @return mixed
     */
    public function paginate($companyId, $perPage = 10)
    {
        return $this->model()->where('company_id', '=', $companyId)->paginate($perPage);
    }

    /**
     * Yeni müşteri ekler
     *
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $customer = $this->model()->create([
            'company_id' => $request->input('company_id'),
            'name' => $request->input('name')
        ]);

        return $customer;
    }

    /**
     * Varolan müşteriyi günceller
     *
     * @param Customer $customer
     * @param Request $request
     * @return Customer
     */
    public function update(Customer $customer, Request $request)
    {
        $customer->update([
            'name' => $request->input('name')
        ]);

        return $customer;
    }

    /**
     * Müşteriyi siler
     *
     * @param Customer $customer
     * @throws \Exception
     */
    public function delete(Customer $customer)
    {
        $customer->delete();
    }
}
