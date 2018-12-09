<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
  public function getUsersManager()
  {
    return view('admin.users');
  }

  public function getUsersDatatables()
  {
    $users = User::select(['id', 'name', 'email']);

    return Datatables::of($users)
      ->addColumn('action', function ($users) {

        return
          "<button type='button' class='btn btn-sm btn-danger' data-toggle='modal' data-target='#delete-alert' onclick='deleteUser($users->id)'>Delete</button>" .
          "<button type='button' class='btn btn-sm btn-warning' data-toggle='modal' data-target='#userDetail' onclick='userDetail($users->id)'>Edit</button>" .
          "<button type='button' class='btn btn-sm btn-primary'><a href='/admin/users/$users->id' class='text-white'>View</a></button>";
      })
      ->make(true);
  }

  public function deleteManager($id)
  {
    User::destroy($id);

    return redirect(route('usersManager'));
  }

  public function editManager(UpdateUserRequest $request)
  {
    $validator = $request->validated();

    $product = User::find($request->id);

    $product->update($request->all());

    return redirect(route('usersManager'))->with('update_success', $request->name);
  }

  public function createManager(CreateUserRequest $request)
  {
    $validator = $request->validated();

    User::create($request->all());

    return redirect(route('usersManager'))->with('created_success', $request->name);
  }

  public function getUserAPI(Request $request)
  {
    $user = User::find($request->id);

    return response()->json([
      'data' => $user,
    ]);
  }

  public function userDetail ($id) {
    $user = User::find($id);

    return view('admin.user', ['user' => $user]);
  }
}
