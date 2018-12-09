<?php

namespace App\Http\Controllers;
use Config;
use Validator;
use Illuminate\Http\Request;
use App\Product;
// handle lib
use App\Lib\Cart\Cart;

class CartController extends Controller
{
    public function index()
    {
        return view('front-end.shopping-cart', [
            'cartItems' => Cart::content(),
            'subTotal'     => Cart::subTotal(),
            'total'     => Cart::total(10),
            'total_quantity' => Cart::totalQuantity()
        ]);
    }
    public function add(Request $request)
    {
        $cart_msg = Config::get('config')['cart'];
        $validator = Validator::make($request->all(), [
            'qty'   => 'required|numeric|min:1',
            'options.size'  => 'required'
        ], $cart_msg['validate']);

        if ($validator->fails()) {
            return response()->json([
                'msg'    => $cart_msg['error']['add'],
                'errors' => $validator->errors()
            ]);
        }

        $item = Cart::add($request->id, $request->name, $request->qty, $request->price, $request->options);
        return response()->json([
            'msg'    => $cart_msg['success']['add'],
            'item'   => $item,
            'total_quantity'    => Cart::totalQuantity()
        ]);
    }

    public function remove(Request $request)
    {
        $cart_msg = Config::get('config')['cart'];
        $item = Cart::remove($request->rowId);

        return response()->json([
            'msg'    => $cart_msg['success']['remove'],
            'total'  => Cart::total(),
            'subtotal' => Cart::subTotal(),
            'total_quantity'    => Cart::totalQuantity()
        ]);
    }

    public function update(Request $request)
    {
        $cart_msg = Config::get('config')['cart'];
        $errors = array();
        // arr [{rowId: ..., qty: ....}, {rowId: ..., qty: ....}]
        foreach ($request->update as $key => $item) {
            $validator = Validator::make($item, [
                'qty'   => 'required|numeric|min:1',
            ], $cart_msg['validate']);

            if ($validator->fails()) {
                $errors[$item['rowId']] = $validator->errors()->first();
                continue;
            }    
            $item = Cart::update($item['rowId'], $item['qty']);
        }

        if (!empty($errors))
            return response()->json([
                'msg'    => $cart_msg['error']['update'],
                'errors' => $errors
            ]);

        return response()->json([
            'msg'    => $cart_msg['success']['update'],
            'update' => $request->update,
            'total'  => Cart::total(),
            'subtotal' => Cart::subTotal(),
            'total_quantity'    => Cart::totalQuantity()
        ]);
    }
}
