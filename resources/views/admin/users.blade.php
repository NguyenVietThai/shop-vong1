@extends('admin.layouts.template')
@section('main')
  {{--Modal--}}
  <div class="modal fade" id="createUser" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">User Detail</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-3">
          <form class="register-form" id="register-form" method="POST" action="{{ route('createUserManager') }}">
            @csrf
            <div class="form-group">
              <input type="text" name="name" placeholder="Your Name"
                     class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}"
                     required autofocus/>
              @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif
            </div>
            <div class="form-group">
              <input type="email" name="email"
                     class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder=" Your Email"
                     value="{{ old('email') }}" required/>

              @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
              @endif
            </div>
            <div class="form-group">
              <input type="password" name="password" placeholder="Password"
                     class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                     required/>
              @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
              @endif
            </div>
            <div class="form-group">
              <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                     name="password_confirmation" placeholder="Repeat your password"
                     required/>
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
  <div class="modal fade" id="userDetail" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">User Detail</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-3">
          <form action="" enctype="multipart/form-data" method="POST" id="user-form">
            @csrf
            <div class="form-group">
              <label for="name">Your Name</label>
              <input type="text" class="form-control" id="name" placeholder="" name="name" required>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" placeholder="" name="email" required/>
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

  {{--Content--}}
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        @if(!empty($errors->first()))
          <div class="col-lg-12">
            <div class="alert alert-danger">
              <span>{{ $errors->first() }}</span>
            </div>
          </div>
        @endif
        @if(session('update_success'))
          <div class="col-md-12">
            <div class="alert alert-success">
              User {{session('update_success')}} Updated.
            </div>
          </div>
        @endif
        @if(session('created_success'))
          <div class="col-md-12">
            <div class="alert alert-success">
              User {{session('created_success')}} Created.
            </div>
          </div>
        @endif
        <div class="col-md-12">
          <button class="btn btn-primary" data-toggle="modal" id="btn-create-user" data-target="#createUser">Create
            user
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
                    NAME
                  </th>
                  <th>
                    EMAIL
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
        ajax: '{!! route('usersDatatables') !!}',
        columns: [
          {data: 'id', name: 'id'},
          {data: 'name', name: 'name'},
          {data: 'email', email: 'email'},
          {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
      });
    });

    $.fn.dataTable.ext.classes.sLengthSelect = 'border-0 background-none';
    $.fn.dataTable.ext.classes.sPageButton = 'btn btn-success';
    $.fn.dataTable.ext.classes.sFilterInput = 'filter';

    function deleteUser(id) {
      $('#delete-btn').attr('href', '/admin/users/delete/' + id);
    }

    function userDetail(id) {
      $('#user-form').attr('action', '/admin/users/edit/' + id);
      $.ajax({
        url: '/admin/users/api/' + id,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
          let data = response.data;

          $('#name').val(data.name);
          $('#email').val(data.email);
          $('#password').val(data.password);
        },
      });
    }

    $('#btn-create-user').click(function () {
      $('#create-user-form').attr('action', '/admin/users/create');

    });
  </script>
@endsection
