<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminUserController extends Controller
{
public function index() {
    $users = \App\Models\User::all();
    return view('admin.users.index', compact('users'));
}

public function updateRole(Request $request, $id) {
    $user = \App\Models\User::findOrFail($id);
    $user->role = $request->role;
    $user->save();
    return back()->with('success', 'Status user berhasil diubah!');
}
}
