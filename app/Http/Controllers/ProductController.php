<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Repositories\Product\ProductRepository;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    protected $product;

    /**
     * Product Controller Class
     *
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->middleware('auth');

        $this->product = $productRepository;
    }

    /**
     * Şirkete ait tüm ürünleri listeler
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'data' => $this->product->paginate(auth()->user()->company->id)
        ]);
    }

    /**
     * Yeni ürün ekler
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $request->merge([
            'company_id' => auth()->user()->company->id
        ]);

        $product = $this->product->create($request);

        return response()->json([
            'message' => 'Başarıyla ürün eklediniz.',
            'data' => $product
        ], Response::HTTP_CREATED);
    }

    /**
     * Ürünü getirir
     *
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product)
    {
        return response()->json([
            'data' => $product
        ]);
    }

    /**
     * Varolan ürünü günceller
     *
     * @param UpdateRequest $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Product $product)
    {
        $this->authorize('product-check-company', [$product]);

        $updatedProduct = $this->product->update($product, $request);

        return response()->json([
            'message' => 'Başarıyla ürünü güncellediniz.',
            'data' => $updatedProduct
        ]);
    }

    /**
     * Varolan ürünü siler
     *
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Product $product)
    {
        $this->authorize('product-check-company', [$product]);

        $this->product->delete($product);

        return response()->json([
            'message' => 'Başarıyla ürünü sildiniz.'
        ]);
    }
}
