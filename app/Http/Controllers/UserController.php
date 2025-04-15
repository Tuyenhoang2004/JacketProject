<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('users');

        if ($request->filled('name')) {
            $query->where('UserName', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        $users = $query->paginate(10);

        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'UserName' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6', // Sửa lại đây để phù hợp với tên trường "password"
        ]);

        DB::table('users')->insert([
            'UserName' => $request->UserName,
            'email' => $request->email,
            'UserPhone' => $request->UserPhone,
            'UserAddress' => $request->UserAddress,
            'role' => $request->role ?? 'user',
            'password' => bcrypt($request->password), // Sửa lại tên trường mật khẩu ở đây
        ]);

        return redirect()->route('user.index')->with('success', 'Thêm người dùng thành công!');
    }

    public function edit($id)
    {
        $user = DB::table('users')->where('UserID', $id)->first();
        return view('admin.user.form', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'UserName' => 'required',
            'email' => 'required|email|unique:users,email,' . $id . ',UserID',
        ]);

        DB::table('users')->where('UserID', $id)->update([
            'UserName' => $request->UserName,
            'email' => $request->email,
            'UserPhone' => $request->UserPhone,
            'UserAddress' => $request->UserAddress,
            'role' => $request->role,
        ]);

        return redirect()->route('user.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        DB::table('users')->where('UserID', $id)->delete();
        return redirect()->route('user.index')->with('success', 'Xóa người dùng thành công!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
