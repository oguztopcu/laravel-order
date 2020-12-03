<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;
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
     * Ürünlerin stok durumunu kontrol eder
     *
     * @param array $products
     * @return bool
     */
    public function checkQuantity(array $products = [])
    {
        $prods = $this->model()->select(['id', 'stock'])->whereIn('id', collect($products)->keys()->toArray())->get();

        foreach ($prods as $product) {
            if ($products[$product->id] > $product->stock) {
                return false;
            }
        }

        return true;
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

    /**
     * Ürünlerin stoklarını düşürür.
     *
     * @param array $products
     * @return bool
     */
    public function decrementStock(array $products)
    {
        $prods = $this->model()->select(['id', 'stock'])->whereIn('id', collect($products)->keys()->toArray())->get();

        foreach ($prods as $product) {
            $product->decrement('stock', (int) $products[$product->id]);
        }

        return true;
    }
}
