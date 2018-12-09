<?php
namespace App\Lib\Product\Filter;

class PriceFilter implements FilterInterface{
	private $price_start, $price_end;
	
	function __construct($price_start, $price_end)
	{
		$this->price_start = $price_start;
		$this->price_end = $price_end;
	} 

	public function execute($all_products)
	{
		$filter_products = array();
		foreach ($all_products as $key => $product) {
			if ($product->price >= $this->price_start && $product->price < $this->price_end)
				array_push($filter_products, $product);
		}
		return $filter_products;
	}
}