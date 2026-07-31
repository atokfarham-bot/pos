<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(searchRequest $request)
    {
        $keyword = $request->input('search');

        if ($keyword) {
            $users = User::whereRaw("MATCH(name, email) AGAINST(? IN BOOLEAN MODE)", [$keyword])
              ->paginate(10)
              ->withQueryString();
        } else {
           $users = User::query()->paginate(10)->withQueryString();
        }

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();

        return view('users.create', compact('roles'));
    }

    public function store(StoreRequest $request)
    {
        $dataReq = $request->validated();

        User::create([
            'name' => $dataReq['name'],
            'email' => $dataReq['email'],
            'password' => Hash::make($dataReq['password']),
            'role_id' => $dataReq['role_id'],
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dibuat');
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(UpdateRequest $request, User $user)
    {
        $dataReq = $request->validated();

        $user->name = $dataReq['name'];
        $user->email = $dataReq['email'];
        $user->role_id = $dataReq['role_id'];

        if (!empty($dataReq['password'])) {
            $user->password = Hash::make($dataReq['password']);
        }

        $user->save();

       return redirect()->route('admin.users')->with('success', 'User berhasil diupdate');
    }

   public function destroy(User $user)
{
    foreach ($user->penjualan as $penjualan) {
        $penjualan->itemPenjualan()->delete();
    }

    $user->penjualan()->delete();

    $user->delete();

    return back()->with('success', 'User deleted');
}
}