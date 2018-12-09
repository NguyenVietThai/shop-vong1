<?php 
namespace App\Lib\Product\Filter;

interface FilterInterface {
	public function execute($all_products);
}