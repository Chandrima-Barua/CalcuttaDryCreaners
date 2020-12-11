<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $role = Role::where('slug', '=', Str::slug($request->input('name'), '-'))->first();
        if ($role === null) {
            $request->validate([
            'name' => 'required',
        ]);
            $role = new Role();
            $role->name = $request->input('name');
            $role->slug = Str::slug($request->input('name'), '-');
            $role->save();

            return redirect('/roles')->with('success', 'Role created!');
        } else {
            return redirect('/roles')->with('error', 'Role already exists!');
        }
    }

    public function edit($id)
    {
        $role = Role::find($id);

        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->get('name');
        $role->slug = Str::slug($request->get('name'), '-');
        $role->save();

        return redirect('/roles')->with('success', 'Role updated!');
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();

        return redirect('/roles')->with('success', 'Role deleted!');
    }

    public function userlist()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function user_role_edit($id)
    {
        $user = User::find($id);
        $roles = $user->roles;
        $allroles = Role::all();
        $allbranches = Branch::all();
        $branches = $user->branches;

        return view('users.edit')->with(['user' => $user, 'roles' => $roles, 'allroles' => $allroles, 'allbranches' => $allbranches, 'branches' => $branches]);
    }

    public function user_role_update(Request $request, $id)
    {
        $request->validate([
            'roles' => 'required',
        ]);

        $user = User::find($id);
        $roles = $request->input('roles');
        $user->roles()->sync($roles);
        $branches = $request->input('branches');
        $user->branches()->sync($branches);

        return redirect('/users')->with('success', 'Role updated!');
    }

    public function user_role_destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('/users')->with('success', 'User deleted!');
    }
}
