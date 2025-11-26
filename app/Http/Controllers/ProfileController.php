<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
    public function update(Request $request)
    {
        // $user = Auth::user();
$user = User::find(Auth::id());

        $request->validate([
            'nom_utilisateur' => 'required|string|max:255',
            'prenom_utilisateur' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'contact_utilisateur' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->nom_utilisateur = $request->nom_utilisateur;
        $user->prenom_utilisateur = $request->prenom_utilisateur;
        $user->email = $request->email;
        $user->contact_utilisateur = $request->contact_utilisateur;

        if ($request->hasFile('image')) {
            // Supprimer ancienne image si existe
            if ($user->image && Storage::exists('public/' . $user->image)) {
                Storage::delete('public/' . $user->image);
            }
            $path = $request->file('image')->store('public/profile');
            $user->image = str_replace('public/', '', $path);
        }

        $user->save();

        return back()->with('success', 'Profil mis à jour avec succès !');
    }
}
