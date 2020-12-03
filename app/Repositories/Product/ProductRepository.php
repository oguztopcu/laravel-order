<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class ProductRepository extends Repository
{
    protected $model = Product::class;

    /**
     * Şirkete göre tüm ürünleri listeler
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
     * Şirkete yeni ürün ekler
     *
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        return $this->model()->create([
            'company_id' => $request->input('company_id'),
            'name' => $request->input('name'),
            'stock' => $request->input('stock')
        ]);
    }

    /**
     * Şirkete kayıtlı varolan ürünü günceller
     *
     * @param Product $product
     * @param Request $request
     * @return Product
     */
    public function update(Product $product, Request $request)
    {
        $product->update([
            'name' => $request->input('name'),
            'stock' => $request->input('stock')
        ]);

        return $product;
    }

    /**
     * Şirkete kayıtlı varolan ürünü siler
     *
     * @param Product $product
     * @throws \Exception
     */
    public function delete(Product $product)
    {
        $product->delete();
    }
}
