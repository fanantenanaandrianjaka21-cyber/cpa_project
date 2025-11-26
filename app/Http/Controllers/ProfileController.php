<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function showForm()
    {
        return view('auth.complete-profile');
    }

    public function saveIncompleteProfile(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'pin' => 'required|digits:6',
        ]);
// dd($request->pin);
        // $user = Auth::user();
$user = User::find(Auth::id());
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->pin = Hash::make($request->pin);
        $user->save();

        return redirect('/mail-verifier-code')->with('success', 'Profil mis à jour !');
    }
}
