<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $data = User::latest()->get();
        return view('users.user-index', compact('data'));
    }

    public function create()
    {
        // $roles = Role::all();

        return view('users.user-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'role' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        // $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);

        return view('users.user-edit', compact('user'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'role' => 'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);


        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
