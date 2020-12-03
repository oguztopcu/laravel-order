<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Repositories\Repository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderRepository extends Repository
{
    protected $model = Order::class;

    /**
     * Şirkete ait tüm siparişleri getirir.
     *
     * @param $companyId
     * @param int $perPage
     * @return mixed
     */
    public function paginate($companyId, $perPage = 10)
    {
        return $this->model()->where('company_id', '=', $companyId)->paginate($perPage);
    }

    /**
     * Şirkete yeni sipariş oluşturur.
     *
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $arr = [
            'company_id' => $request->input('company_id'),
            'customer_id' => $request->input('customer_id'),
            'order_code' => Str::random(8),
            'address' => $request->input('address')
        ];

        if ($request->has('shipping_date')) {
            $arr['shipping_date'] = Carbon::createFromFormat('d/m/Y H:i', $request->input('shipping_date'))->format('Y-m-d H:i:s');
        }

        $order = $this->model()->create($arr);

        $products = [];
        foreach ($request->input('product') as $product) {
            $products[$product['product_id']] = [
                'quantity' => $product['quantity']
            ];
        }

        $order->products()->attach($products);

        return $order;
    }

    /**
     * Varolan siparişi günceller
     *
     * @param Order $order
     * @param Request $request
     * @return Order
     */
    public function update(Order $order, Request $request)
    {
        $arr = [];

        if ($request->has('address')) {
            $arr['address'] = $request->input('address');
        }

        if ($request->has('shipping_date')) {
            $arr['shipping_date'] = Carbon::createFromFormat('d/m/Y H:i', $request->input('shipping_date'))->format('Y-m-d H:i:s');
        }

        $order->update($arr);

        if ($request->has('product')) {
            $order->products()->sync($request->input('product'));
        }

        return $order;
    }

    /**
     * Siparişi siler
     *
     * @param Order $order
     * @throws \Exception
     */
    public function delete(Order $order)
    {
        $order->delete();
    }
}
