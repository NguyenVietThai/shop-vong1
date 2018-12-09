@extends('front-end.app_default')
@section('content')
	<style>
		.error {color: red; font-size: 12px;}
	</style>
		<!-- Product Detail -->
	<section class="sec-product-detail bg0 p-t-25 p-b-60">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-lg-7 p-b-30">
					<div class="p-l-25 p-r-30 p-lr-0-lg">
						<div class="wrap-slick3 flex-sb flex-w">
							<div class="wrap-slick3-dots"></div>
							<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

							<div class="slick3 gallery-lb">
								<div class="item-slick3" data-thumb="/images/products/{{$product->img1}}" style="height: 400px;">
									<div class="wrap-pic-w pos-relative">
										<img src="/images/products/{{$product->img1}}" alt="IMG-PRODUCT">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="/images/products/{{$product->img3}}">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>

								<div class="item-slick3" data-thumb="/images/products/{{$product->img2}}" style="height: 400px;">
									<div class="wrap-pic-w pos-relative">
										<img src="/images/products/{{$product->img2}}" alt="IMG-PRODUCT">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="/images/products{{$product->img2}}">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>

								<div class="item-slick3" data-thumb="/images/products/{{$product->img3}}" style="height: 400px;">
									<div class="wrap-pic-w pos-relative">
										<img src="/images/products/{{$product->img3}}" alt="IMG-PRODUCT">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="/images/products/{{$product->img3}}">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
					
				<div class="col-md-6 col-lg-5 p-b-30">
					<div class="p-r-50 p-t-5 p-lr-0-lg">
						<h4 class="mtext-105 cl2 js-name-detail p-b-14">
							{{$product->name}}
						</h4>

						<span class="mtext-106 cl2">
							{{$product->price}}
						</span>

						<p class="stext-102 cl3 p-t-23">
							{{$product->description}}
						</p>
						
						<!--  -->
						<div class="p-t-33">
							<div class="flex-w flex-r-m p-b-10">
								<div class="size-203 flex-c-m respon6">
									Size
								</div>

								<div class="size-204 respon6-next">
									<div class="rs1-select2 bor8 bg0">
										<select class="js-select2" name="time" id="size">
											<option value="">Choose an option</option>
											<option value="S">Size S</option>
											<option value="M">Size M</option>
											<option value="L">Size L</option>
											<option value="XL">Size XL</option>
										</select>
										<div class="dropDownSelect2"></div>
									</div>
									<span class="error err_size"></span>
								</div>
							</div>

							<div class="flex-w flex-r-m p-b-10">
								<div class="size-204 flex-w flex-m respon6-next">
									<div class="wrap-num-product flex-w m-r-20 m-tb-10">
										<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-minus"></i>
										</div>

										<input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product" value="1" min="1" id="qty">
										<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-plus"></i>
										</div>
									</div>
									<span class="error err_qty"></span>

									<button class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail" id="add_to_cart" data-id="{{$product->id}}" data-name="{{$product->name}}" data-price="{{$product->price}}">
										Add to cart
									</button>
								</div>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@stop
@section('script')
	<script type="text/javascript">
		$('#add_to_cart').click(function () {
			var item = {
				id 		: $(this).data("id"),
				name 	: $(this).data("name"),
				price 	: $(this).data("price"),
				qty 	: $('#qty').val(),
				options : {'size' : $('#size').val()}
			}
			$.ajax({
				url : '/cart/add',
				data : item,
				success: function (data) {
					var status = (data.errors) ? "error" : "success";
					swal(item.name, data.msg, status);
					
					$('.error').css("display", "none");
					if (data.errors) {
						// Throw error to input
						$.each(data.errors, function (key, value) {
							key = key.replace('options.', '');
							$('.err_'+key).css("display", "inline");
							$('.err_'+key).html(value);
						});
					} else {
						$('#total_quantity').html(data.total_quantity);	
					}
				}
			});
		})
	</script>
@stop
