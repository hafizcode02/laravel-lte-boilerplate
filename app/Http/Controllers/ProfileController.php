<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        if ($request->password) {
            $request->user()->fill([
                'name' => $request->name,
                'password' => Hash::make($request->password),
            ]);
        } else {
            $request->user()->fill([
                'name' => $request->name,
            ]);
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('success', 'Akun berhasil diperbaharui.');
    }
}
