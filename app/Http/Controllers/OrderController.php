<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\Order\StoreRequest;
use App\Http\Requests\Order\UpdateRequest;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Product\ProductRepository;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    protected $order;

    protected $product;

    /**
     * Order Controller Class
     *
     * @param OrderRepository $orderRepository
     * @param ProductRepository $productRepository
     */
    public function __construct(OrderRepository $orderRepository, ProductRepository $productRepository)
    {
        $this->middleware('auth');

        $this->order = $orderRepository;
        $this->product = $productRepository;
    }

    /**
     * Şirkete ait tüm siparişleri listeler
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'data' => $this->order->paginate(auth()->user()->company->id)
        ]);
    }

    /**
     * Yeni sipariş oluşturur
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $products = [];
        foreach ($request->input('product') as $product) {
            $products[$product['product_id']] = $product['quantity'];
        }

        if (! $this->product->checkQuantity($products)) {
            return response()->json([
                'message' => 'Yeterli ürün stokta bulunmuyor'
            ], Response::HTTP_BAD_REQUEST);
        }

        $request->merge([
            'company_id' => auth()->user()->company->id
        ]);

        $order = $this->order->create($request);

        if ($order) {
            $this->product->decrementStock($products);
        }

        return response()->json([
            'message' => 'Başarıyla siparişiniz oluşturuldu.',
            'data' => $order
        ]);
    }

    public function show(Order $order)
    {
        $order->load('products');

        return response()->json([
            'data' => $order
        ]);
    }

    /**
     * Varolan siparişi günceller
     *
     * @param UpdateRequest $request
     * @param Order $order
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateRequest $request, Order $order)
    {
        $this->authorize('order-check-company', [$order]);
        $this->authorize('update-post', [$order]);

        $updatedOrder = $this->order->update($order, $request);

        return response()->json([
            'message' => 'Sipariş başarıyla güncellendi.',
            'data' => $updatedOrder
        ]);
    }

    /**
     * Varolan siparişi siler
     *
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Order $order)
    {
        $this->authorize('order-check-company', [$order]);

        $this->order->delete($order);

        return response()->json([
            'message' => 'Sipariş başarıyla silindi.'
        ]);
    }
}
