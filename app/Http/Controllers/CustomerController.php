<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\Customer\StoreRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Repositories\Customer\CustomerRepository;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    protected $customer;

    /**
     * Customer Controller Class
     *
     * @param CustomerRepository $customerRepository
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->middleware('auth');

        $this->customer = $customerRepository;
    }

    /**
     * Şirkete ait tüm müşterileri listeler
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'data' => $this->customer->paginate(auth()->user()->company->id)
        ]);
    }

    /**
     * Şirkete yeni müşteri ekler
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $request->merge([
            'company_id' => auth()->user()->company->id
        ]);

        $customer = $this->customer->create($request);

        return response()->json([
            'message' => 'Müşteri başarıyla oluşturuldu.',
            'data' => $customer
        ], Response::HTTP_CREATED);
    }

    /**
     * Müşteriye ait detay bilgileri verir
     *
     * @param Customer $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Customer $customer)
    {
        return response()->json([
            'data' => $customer
        ]);
    }

    /**
     * Şirkete ait müşteri bilgisini günceller
     *
     * @param UpdateRequest $request
     * @param Customer $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Customer $customer)
    {
        $this->authorize('customer-check-company', [$customer]);

        $updatedCustomer = $this->customer->update($customer, $request);

        return response()->json([
            'message' => 'Müşteri bilgileri başarıyla güncellendi.',
            'data' => $updatedCustomer
        ]);
    }

    /**
     * Şirkete ait müşteriyi siler
     *
     * @param Customer $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Customer $customer)
    {
        $this->authorize('customer-check-company', [$customer]);

        $this->customer->delete($customer);

        return response()->json([
            'message' => 'Müşteri bilgileri başarıyla silindi.'
        ]);
    }
}
