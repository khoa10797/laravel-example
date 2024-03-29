<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::query()->paginate(12);
        return view('admin.product.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create-product');
        $categories = Category::all();
        return view('admin.product.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create-product');
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required'
        ]);

        $imagePath = $this->uploadImage($request);
        $product = new Product([
            'category_id' => $request->get('category_id'),
            'name' => $request->get('name'),
            'image' => $imagePath,
            'price' => $request->get('price'),
            'note' => $request->get('note') == null ? '' : $request->get('note')
        ]);

        $product->save();
        return redirect('/admin/product');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($id)
    {
        $this->authorize('update-product');
        $categories = Category::all();
        $product = Product::query()->find($id);
        return view('admin.product.edit', ['categories' => $categories, 'product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, $id)
    {
        $this->authorize('update-product');
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'price' => 'required'
        ]);

        $product = Product::query()->find($id);
        $note = $request->get('note') == null ? '' : $request->get('note');
        $image = $product->image;
        if ($request->file('image')) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            $image = $this->uploadImage($request);
            unlink(public_path($product->image));
        }


        $product->category_id = $request->get('category_id');
        $product->name = $request->get('name');
        $product->price = $request->get('price');
        $product->note = $note;
        $product->image = $image;

        $product->save();
        return redirect('/admin/product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $this->authorize('delete-product');
        $product = Product::query()->find($id);
        $imagePath = $product->image;
        unlink(public_path($imagePath));
        $product->delete();
        return redirect('/admin/product');
    }

    /**
     * @param Request $request
     * @return string
     */
    private function uploadImage(Request $request)
    {
        $image = $request->file('image');
        $generateName = str_slug($request->get('name')) . '_' . time();
        $imageName = $generateName . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('/images'), $imageName);

        return '/images/' . $imageName;
    }
}
