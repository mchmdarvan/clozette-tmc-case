<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category = Category::with('products');
        if ($search = $request->input('search')) {
            $category->where('name', 'LIKE', "%" . $search . "%");
        }
        $sort = $request->input('sort', 'DESC');
        $sortBy = $request->input('sort_by', 'created_at');

        $category->selectRaw('*, UNIX_TIMESTAMP(created_at) * 1000 AS created_at_millis');

        $category->orderBy($sortBy, $sort);
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 1);

        return $this->response($category->paginate($perPage)->toArray(), 'Success Get Data');
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
    public function store(CategoryRequest $request)
    {
        $validatedData = $request->validated();

        // Create a new product with the validated data
        Category::create($validatedData);

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
        return $this->response(Category::findOrFail($id)->toArray());
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
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);

        // Validate the incoming request data
        $validatedData = $request->validated();

        // Update the product with the validated data
        $category->update($validatedData);
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
        $category = Category::findOrFail($id);

        $category->delete();

        return $this->response(null, 'Category was sucessfully Delete!');
    }
}
