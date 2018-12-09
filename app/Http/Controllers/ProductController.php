<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use Config;
use View;
use Validator;
use Illuminate\Http\Request;
use App\Product;
// third party
use Yajra\DataTables\DataTables;
// handle Lib
use Illuminate\Pagination\LengthAwarePaginator;
use App\Lib\Product\Filter\PriceFilter;
use App\Lib\Product\Filter\NameFilter;
use App\Lib\Product\Filter\CategoryFilter;
use App\Lib\Product\Filter\AndFilter;
use App\Lib\Cart\Cart;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $config = Config::get('config');
        return view('front-end.product', [
            'categories' => $config['categories'],
            'prices'     => $config['prices'],
            'total_quantity' => Cart::totalQuantity()
        ]);
    }

    public function detail($id)
    {
        $product = Product::where('id', $id)->first();
        return view('front-end.product-detail', [
            'product' => $product,
            'total_quantity' => Cart::totalQuantity()
        ]);
    }

    public function filter(Request $request)
    {
        // Implement filter type
        $arr_filter = array();
        if (isset($request->keyword))
            array_push($arr_filter, new NameFilter($request->keyword));
        if (isset($request->category_id))
            array_push($arr_filter, new CategoryFilter($request->category_id));
        if (isset($request->price_start))
            array_push($arr_filter, new PriceFilter($request->price_start, $request->price_end));
        $and_filter = new AndFilter($arr_filter);

        // Execute filter
        $all_products = Product::all();
        $filter_products = $and_filter->execute($all_products);

        // Render to Html
        $paginatedItems = $this->array_paginate($request, $filter_products);
        return array(
            'html' => View::make('front-end.product-list')->with(['products' => $paginatedItems])
                ->render(),
            'pages' => View::make('front-end.pagination')->with(['paginator' => $paginatedItems])
                ->render()
        );
    }

    public function array_paginate($request, $filter_products)
    {
        // Laravel pagination support
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($filter_products);
        $perPage = 6;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginatedItems = new LengthAwarePaginator($currentPageItems, count($itemCollection), $perPage);
        $paginatedItems->setPath($request->url());
        return $paginatedItems;
    }

    public function getProductManagerPage()
    {
        return view('admin.products');
    }

    public function getProductsDatatables()
    {
        $products = Product::select(['id', 'category_id', 'name', 'description', 'price', 'quantity', 'img1', 'img2', 'img3']);

        return Datatables::of($products)
            ->addColumn('action', function ($product) {

                return
                    "<button type='button' class='btn btn-sm btn-danger' data-toggle='modal' data-target='#delete-alert' onclick='deleteProduct($product->id)'>Delete</button>" .
                    "<button type='button' class='btn btn-sm btn-warning' data-toggle='modal' data-target='#productDetail' onclick='productDetail($product->id)'>Edit</button>" .
                    "<button type='button' class='btn btn-sm btn-primary'><a href='/admin/products/$product->id' class='text-white'>View</a></button>";
            })
            ->make(true);
    }

    public function editProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect(route('productsManager'))
                ->withErrors($validator)
                ->withInput();
        }

        $product = Product::find($request->id);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->img1 = Product::createImage($request->img1, $product->img1);
        $product->img2 = Product::createImage($request->img2, $product->img2);
        $product->img3 = Product::createImage($request->img3, $product->img3);
        $product->save();

        return redirect(route('productsManager'))->with('update_success', $request->name);
    }

    public function getProductAPI(Request $request)
    {
        $product = Product::find($request->id);

        return response()->json([
            'data' => $product,
        ]);
    }

    public function createProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products,name',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect(route('productsManager'))
                ->withErrors($validator)
                ->withInput();
        }
        $product = new Product();

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->img1 = Product::createImage($request->img1);
        $product->img2 = Product::createImage($request->img2);
        $product->img3 = Product::createImage($request->img3);
        $product->save();

        return redirect(route('productsManager'))->with('created_success', $request->name);
    }
    
    public function deleteManager($id)
    {
        Product::destroy($id);
        return redirect(route('productsManager'));
    }


    public function productDetail(Request $request)
    {
        $id = $request->id;

        $product = Product::find($id);

        return view('admin.product-detail', ['product' => $product]);
    }
}

