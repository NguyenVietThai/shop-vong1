@extends('admin.layouts.template')
@section('main')
  <!-- Modal -->
  <div class="modal fade" id="productDetail" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Product Detail</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-3">
          <form action="" enctype="multipart/form-data" method="POST" id="product-form" enctype='multipart/form-data'>
            @csrf
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="name" placeholder="" name="name">
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <textarea class="form-control" id="description" placeholder="" name="description"></textarea>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col">
                  <label for="category_id">Category</label>
                  <select class="form-control" id="category_id" name="category_id">
                    @foreach(config('category') as $key => $item)
                      <option value="{{$key}}">{{$item}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col">
                  <label for="price">Price</label>
                  <input type="number" class="form-control" id="price" placeholder="Price" name="price">
                </div>
                <div class="col">
                  <label for="quantity">Quantity</label>
                  <input type="number" class="form-control" id="quantity" placeholder="Quantity" name="quantity">
                </div>
              </div>
            </div>
            <div>
              <div class="row" style="">
                <style>
                  .img_review {
                    width: 80px;
                    height: 80px;
                  }

                  .current {
                    opacity: 0.7
                  }
                </style>
                <div class="col">
                  <label for="img1">Img1</label>
                  <input class="form-control" type="file" name="img1" onchange="readURL(this);" value=""
                         id="img1_input">
                  <img src="" alt="" class="img_review" id="img1_review">
                </div>
                <div class="col">
                  <label for="img1">Img2</label>
                  <input class="form-control" type="file" name="img2" onchange="readURL(this);" value=""
                         id="img2_input">
                  <img src="" alt="" class="img_review" id="img2_review">
                </div>
                <div class="col">
                  <label for="img1">Img3</label>
                  <input class="form-control" type="file" name="img3" onchange="readURL(this);" value=""
                         id="img3_input">
                  <img src="" alt="" class="img_review" id="img3_review">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="delete-alert" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Product Detail</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-3">
          Delete. Are you sure?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger"><a href="/" class="text-white" id="delete-btn">Sure</a></button>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        @if(!empty($errors->first()))
          <div class="col-lg-12">
            <div class="alert alert-danger">
              <span>{{ $errors->first() }}</span>
            </div>
          </div>
        @endif @if(session('update_success'))
          <div class="col-md-12">
            <div class="alert alert-success">
              Product {{session('update_success')}} Updated.
            </div>
          </div>
        @endif @if(session('created_success'))
          <div class="col-md-12">
            <div class="alert alert-success">
              Product {{session('created_success')}} Created.
            </div>
          </div>
        @endif
        <div class="col-md-12">
          <button class="btn btn-primary" data-toggle="modal" id="btn-create-product" data-target="#productDetail">
            Create product
          </button>
        </div>
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">Products List</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table" id="products-table">
                  <thead class=" text-primary">
                  <th>
                    ID
                  </th>
                  <th>
                    CATEGORY ID
                  </th>
                  <th>
                    NAME
                  </th>
                  <th>
                    DESCRIPTION
                  </th>
                  <th>
                    PRICE
                  </th>
                  <th>
                    QUANTITY
                  </th>
                  <th>
                    ACTION
                  </th>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('javascript')
  <script>
    $(function () {
      $('#products-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('productsDatatables') !!}',
        columns: [{
          data: 'id',
          name: 'id'
        }, {
          data: 'category_id',
          name: 'category_id'
        }, {
          data: 'name',
          name: 'name'
        }, {
          data: 'description',
          name: 'description'
        }, {
          data: 'price',
          name: 'price'
        }, {
          data: 'quantity',
          name: 'quantity'
        }, {
          data: 'action',
          name: 'action',
          orderable: false,
          searchable: false
        },]
      });
    });

    $.fn.dataTable.ext.classes.sLengthSelect = 'border-0 background-none';
    $.fn.dataTable.ext.classes.sPageButton = 'btn btn-success';
    $.fn.dataTable.ext.classes.sFilterInput = 'filter';

    function deleteProduct(id) {
      $('#delete-btn').attr('href', '/admin/products/delete/' + id);
    }

    function productDetail(id) {
      $('#product-form').attr('action', '/admin/products/edit/' + id);
      $.ajax({
        url: '/admin/products/api/' + id,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
          let data = response.data;
          console.log(data);
          $('#name').val(data.name);
          $('#description').val(data.description);
          $('#price').val(data.price);
          $('#category_id').val(data.category_id);

          $('#img1_review').attr('src', '/images/products/' + data.img1);
          $('#img2_review').attr('src', '/images/products/' + data.img2);
          $('#img3_review').attr('src', '/images/products/' + data.img3);
          $('#quantity').val(data.quantity);
        },
      });
    }

    $('#btn-create-product').click(function () {
      //$('#productDetail').modal('toggle');
      $('#product-form').attr('action', '/admin/products/create');
      $('#name').val('');
      $('#description').val('');
      $('#price').val(0);
      $('#quantity').val(0);

      $('#img1_review').attr('src', '/images/products/default.png');
      $('#img2_review').attr('src', '/images/products/default.png');
      $('#img3_review').attr('src', '/images/products/default.png');
    });

    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        var img = input.getAttribute('id');
        reader.onload = function (e) {
          img = img.replace('input', 'review');
          $('#' + img)
            .attr('src', e.target.result)
            .width(80)
            .height(80);
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>
@endsection
