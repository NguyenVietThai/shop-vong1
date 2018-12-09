<?php 
namespace App\Lib\Cart;

class Item
{
	private $rowId;
	private $id;
	private $name;
	private $qty;
	private $price;	
	private $options;

	function __construct($id, $name, $qty, $price, $options = array())
	{
		$this->id = $id;
		$this->name = $name;
		$this->qty = $qty;
		$this->price = $price;
		$this->options = $options;
		
		$this->rowId = hash("md5", $name.serialize($options));
	}

	public function getId()
	{
		return $this->id;
	}

	public function getRowId()
	{
		return $this->rowId;
	}

	public function getQty()
	{
		return $this->qty;
	}

	public function getName()
	{
		return $this->name;
	}
	
	public function getPrice()
	{
		return $this->price;
	}

	public function getOptions()
	{
		return $this->options;
	}

	public function setQty($qty)
	{
		$this->qty = $qty;
	}


}
