<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $product = Product::with('category');
        if ($search = $request->input('search')) {
            $product->where('name', 'LIKE', "%" . $search . "%")
                ->orWhere('sku', "LIKE", "%" . $search . "%");
        }
        $sort = $request->input('sort', 'DESC');
        $sortBy = $request->input('sort_by', 'created_at');

        $product->selectRaw('*, UNIX_TIMESTAMP(created_at) * 1000 AS created_at');

        $product->orderBy($sortBy, $sort);
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 1);

        return $this->response($product->paginate($perPage)->toArray(), 'Success Get Data');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $validatedData = $request->validated();

        // Create a new product with the validated data
        Product::create($validatedData);

        return $this->response(null, 'Product was sucessfully created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->response(Product::findOrFail($id)->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validate the incoming request data
        $validatedData = $request->validated();

        // Update the product with the validated data
        $product->update($validatedData);
        return $this->response(null, 'Product was sucessfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();
        return $this->response(null, 'Product was sucessfully Delete!');
    }

    public function search(Request $request)
    {
        // Log the received parameters
        \Log::info('Received parameters:', $request->all());

        $product = Product::query();

        // Filter by sku
        if ($request->has('sku')) {
            $product->whereIn('sku', (array) $request->input('sku'));
        }

        // Filter by name (LIKE)
        if ($request->has('name')) {
            $product->where(function (Builder $query) use ($request) {
                foreach ((array) $request->input('name') as $name) {
                    $query->orWhere('name', 'like', "%$name%");
                }
            });
        }

        // Filter by price range
        if ($request->has('price-start')) {
            $product->where('price', '>=', $request->input('price-start'));
        }
        if ($request->has('price-end')) {
            $product->where('price', '<=', $request->input('price-end'));
        }


        // Filter by stock range
        if ($request->has('stock-start')) {
            $product->where('stock', '>=', $request->input('stock-start'));
        }
        if ($request->has('stock-end')) {
            $product->where('stock', '<=', $request->input('stock-end'));
        }

        // Filter by category id
        if ($request->has('category.id')) {
            $product->whereIn('category_id', (array) $request->input('category.id'));
        }

        // Filter by category name
        if ($request->has('category.name')) {
            $product->whereHas('category', function (Builder $query) use ($request) {
                foreach ((array) $request->input('category.name') as $name) {
                    $query->orWhere('name', 'like', "%$name%");
                }
            });
        }

        $sort = $request->input('sort', 'DESC');
        $sortBy = $request->input('sort_by', 'created_at');

        $product->orderBy($sortBy, $sort);
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 1);


        \Log::info($product->toSql(), $product->getBindings());
        return $this->response($product->paginate($perPage)->toArray(), 'Success Get Data');
    }
}
