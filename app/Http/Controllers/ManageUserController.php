<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManageUser\StoreNewAkun;
use App\Http\Requests\ManageUser\UpdateAkun;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function App\Helpers\hashidDecode;

class ManageUserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users-management.index', ['users' => $users]);
    }

    public function create()
    {
        return view('users-management.add');
    }

    public function store(StoreNewAkun $request)
    {
        $user = new User();
        $user->fill([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->save();

        return redirect()->route('users-management.index')->with('success', 'Akun Baru berhasil dibuat!');
    }

    public function edit($id)
    {
        $user = User::findorFail(hashidDecode($id));

        return view('users-management.edit', ['user' => $user]);
    }

    public function update(UpdateAkun $request, $id)
    {
        $user = User::findorFail(hashidDecode($id));

        $user->name = $request->name;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users-management.index')->with('success', 'Akun berhasil diperbarui!');
    }

    public function disable($id)
    {
        $user = User::find(hashidDecode($id));

        if ($user) {
            $user->is_active = !$user->is_active;
            $user->save();
            if ($user->is_active) {
                return redirect()->route('users-management.index')->with('success', 'Akun berhasil diaktifkan!');
            }
            return redirect()->route('users-management.index')->with('success', 'Akun berhasil dinonaktifkan!');
        }

        return redirect()->route('users-management.index')->with('error', 'Terjadi kesalahan!');
    }

    public function destroy($id)
    {
        $user = User::find(hashidDecode($id));

        if ($user) {
            $user->delete();
            return redirect()->route('users-management.index')->with('success', 'Akun berhasil dihapus!');
        }

        return redirect()->route('users-management.index')->with('error', 'Terjadi kesalahan!');
    }
}
