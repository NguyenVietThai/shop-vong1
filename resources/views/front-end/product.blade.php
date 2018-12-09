@extends('front-end.app_default')
@section('content')
	<!-- Product -->
	<div class="bg0">
		<div class="container" style="margin-top: 30px; min-height: 550px;">
			<div class="flex-w flex-sb-m">
				<div class="flex-w flex-l-m filter-tope-group m-tb-10">
					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1 category" data-filter="*">
						All Categories
					</button>
					@foreach($categories as $key => $item)
						<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 category" data-category_id ="{{$key}}" >
							{{$item}}
						</button>
					@endforeach
				</div>
				<div class="flex-r-m">
					<div class="panel-search">
						<div class="bor8 dis-flex p-l-15">
							<button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04" style="height: 40px;"> 
								<i class="zmdi zmdi-search"></i>
							</button>
							<input class="mtext-107 cl2 plh2 p-r-15" type="text" name="search-product" placeholder="Search" id="keyword">
						</div>	
					</div>
				</div>
			</div>
			<div class="p-r-15 p-b-27">
			    <style>.active{ color: #333; border-bottom: 1px solid #797979;}</style>
				<button class="stext-106 cl6 hov1 trans-04 m-r-32 m-tb-5 price p-r-30 active" data-start="{{current($prices)[0]}}" data-end="{{end($prices)[1]}}">All Prices</button>
			    @foreach($prices as $key => $item)
					<button class="stext-106 cl6 hov1 trans-04 m-r-32 m-tb-5 price p-r-30 target" data-start="{{$item[0]}}" data-end="{{$item[1]}}"> {{$item[0]}} - {{$item[1]}} </button>
			    @endforeach
			</div>
			<div class="row" id="product-list" style="min-height: 295px;">
						
			</div>

			<!-- Load more -->
			<div class="flex-c-m flex-w w-full p-t-15 p-b-15">
				<div class="flex-c-m stext-101 cl5 size-103 p-lr-15 trans-04" id="pages">
					
				</div>
			</div>
		</div>
	</div>
@stop

@section('script')
<!--===============================================================================================-->	
	<script type="text/javascript">
		var params = {};
		$('body').on('click', '.page-link', function (e) {
			e.preventDefault();
			params.page = $(this).data("page");
			filter_product();
			delete params.page;
		})		
		$('body').on('click', '.category', function (e) {
			e.preventDefault();
			params.category_id = $(this).data('category_id');
			filter_product();
		})
		$('body').on('click', '.price', function (e) {
			e.preventDefault();
			$('.price').removeClass('active');
			$(this).addClass('active');
			params.price_start = $(this).data('start');
			params.price_end = $(this).data('end')-1;
			filter_product();
		})
		$('#keyword').keyup(function(e){
		    if(e.keyCode == 13) {
		    	params.keyword = $(this).val();
				filter_product();    
		    }
		});

		
		filter_product();
		function filter_product() {
			console.log(params);
			$.ajax({
				url : '/product-filter',
				data : params,
				beforeSend: function () {
	                $('#product-list').waitMe({effect: 'bounce', text: '', bg: 'rgba(255,255,255,0.7)', color: '#000'});
	            },
				success: function (data) {
					data.html = (data.html != "") ? data.html : "<div class='alert'>Không tìm thấy sản phẩm phù hợp</div>";
                	$('#product-list').waitMe('hide');
					$('#product-list').html(data.html);
					$('#pages').html(data.pages);	
				}
			})
		}
	</script>
@stop
