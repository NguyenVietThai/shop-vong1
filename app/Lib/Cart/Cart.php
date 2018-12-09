<?php 

namespace App\Lib\Cart;
use Illuminate\Support\Facades\Session; 
use App\Lib\Cart\Item;

class Cart
{
	CONST SESSION_NAME = 'cart';	// name save in session

	public static function add($id = NULL, $name = NULL, $qty = NULL, $price = NULL, $options = array()) {
		$item = new Item($id, $name, $qty, $price, $options);
		$cartItems = self::content();

		if (!empty($exist = self::find($item->getRowId()))) {
			$item->setQty($qty + $exist->getQty());
		}

		$cartItems[$item->getRowId()] = $item;
		Session::put(self::SESSION_NAME, $cartItems);
		return $item;
	}		

	public static function find($rowId) {
		$cartItems = self::content();
		$item = isset($cartItems[$rowId])
			? $cartItems[$rowId]
			: NULL;
		return $item;
	}

	public static function remove($rowId) {
		$cartItems = self::content();
		unset($cartItems[$rowId]);
		Session::put(self::SESSION_NAME, $cartItems);	
	}

	public static function content()
	{
		$content = Session::has(self::SESSION_NAME)
            ? Session::get(self::SESSION_NAME)
            : [];
        return $content;
	}

	public static function update($rowId, $qty = NULL)
	{
		$cartItems = self::content();
		if (!empty($qty))
			$cartItems[$rowId]->setQty($qty);
		Session::put(self::SESSION_NAME, $cartItems);
	}

	public static function subTotal()
	{
		$cartItems = self::content();
		$total = 0;
		foreach ($cartItems as $key => $item) {
			$total += $item->getQty() * $item->getPrice();
		}
        return $total;
	}

	public static function total($tax = 10)
	{
        return self::subTotal() * (100+$tax)/100;
	}	

	public static function totalQuantity()
	{
		$cartItems = self::content();
		$total_quantity = 0;
		foreach ($cartItems as $key => $item) {
			$total_quantity += $item->getQty();
		}
        return $total_quantity;	
	}
}