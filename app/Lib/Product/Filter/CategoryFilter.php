<?php
namespace App\Lib\Product\Filter;

class CategoryFilter implements FilterInterface{
	private $category_id;
	function __construct($category_id)
	{
		$this->category_id = $category_id;
	} 
	/**
	 * Filter product by category
	 * @param  $all_products
	 * @return \Illuminate\Database\Query\Builder : List all satisfying products
	 */
	public function execute($all_products)
	{
		$filter_products = array();
		foreach ($all_products as $key => $product) {
			if ($product->category_id == $this->category_id)
				array_push($filter_products, $product);
		}
		return $filter_products;
	}
}