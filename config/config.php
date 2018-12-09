<?php 
	return [
		'categories' => [
			1	=> 'Áo thun',
			2	=> 'Áo sơ mi',
			3	=> 'Quàn short',
			4	=> 'Quần Jean',
			5	=> 'Đầm nữ',
			6	=> 'Chân váy'
		],
		'prices' => [
			1	=> array(0, 100000),
			2	=> array(100000, 300000),
			3	=> array(300000, 500000),
			4	=> array(500000, 1000000),
		],
		'cart' => [
			'validate'	=> [
				'qty.required'	=> 'Hãy nhập số lượng sản phẩm',
				'qty.min'		=> 'Số lượng sản phẩm phải lớn hơn 0',
				'options.size.required'	=> 'Hãy chọn size sản phẩm'
			],
			'success'	=> [
				'add' 		=> 'Thêm sản phẩm vào giỏ hàng thành công',
				'update' 		=> 'Cập nhật sản phẩm trong giỏ hàng thành công',
				'remove'	=> 'Gỡ sản phẩm khỏi giỏ hàng thành công',

			],
			'error'		=> [
				'add'    => 'Thêm sản phẩm vào giỏ hàng thất bại',
				'update' => 'Cập nhật sản phẩm trong giỏ hàng thất bại',
			]
		]
	]

 ?>