@extends('admin.layouts.template')
@section('main')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Product Details</h4>
            </div>
            <div class="card-body">
              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif


              <form action="/admin/products/edit/{{ $product->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="bmd-label-floating">Name</label>
                      <input type="text" class="form-control" name="name" value="{{ $product->name }}" disabled>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="bmd-label-floating">Description</label>
                      <textarea class="form-control" name="description" disabled>{{ $product->description }}</textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">Price</label>
                      <input type="number" class="form-control" name = "price" value="{{ $product->price }}" disabled>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">Quantity</label>
                      <input type="number" class="form-control" name="quantity" value="{{ $product->quantity }}" disabled>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleFormControlFile1">Image file: </label>
                      <input type="file" class="form-control-file" id="exampleFormControlFile1" disabled>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleFormControlFile1">Image file: </label>
                      <input type="file" class="form-control-file" id="exampleFormControlFile1" disabled>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleFormControlFile1">Image file: </label>
                      <input type="file" class="form-control" id="exampleFormControlFile1" disabled>
                    </div>
                  </div>
                </div>
                <!-- <button type="submit" class="btn btn-primary pull-right" disabled>Update Product</button> -->
                <div class="clearfix"></div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-profile">
            <div class="card-avatar">
              <a href="#pablo">
                <img class="img" src="{{ $product->img1 }}"/>
              </a>
            </div>
            <div class="card-body">
              <h6 class="card-category text-gray">{{ $product->name }}</h6>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
