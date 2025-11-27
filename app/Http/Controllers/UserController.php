<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Emplacement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $emplacement = Emplacement::all();
     $utilisateur = User::orderBy('id', 'desc')->first();

         $active_tab='utilisateur';
        return view('users.ajout', compact('emplacement','active_tab','utilisateur'));
    }
    public function ajoutUser(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'id' => 'required',
            'id_emplacement' => 'required',
            'nom_utilisateur' => 'required',
            'prenom_utilisateur' => 'required',
            // 'email' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|min:8|confirmed',
            'equipe' => 'required',
            'societe' => 'required',
            'contact_utilisateur' => 'required',
            'role' => 'required',
        ]);
        User::create([
            'id' => $request['id'],
            'id_emplacement' => $request['id_emplacement'],
            'nom_utilisateur' => $request['nom_utilisateur'],
            'prenom_utilisateur' => $request['prenom_utilisateur'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'equipe' => $request['equipe'],
            'societe' => $request['societe'],
            'contact_utilisateur' => $request['contact_utilisateur'],
            'role' => $request['role'],
        ]);

        $user = User::all();
        $notification = 'Utilisateur ajouté  avec succès';
        $emplacement = Emplacement::all();
         $active_tab='utilisateur';
        return view('users.liste', compact('user', 'notification', 'emplacement','active_tab'));
    }
    public function listUser($id_emplacement,$role)
    {
        if($role=='Super Admin'OR $role=='Admin IT'){
        $user = User::all();
        }else{
            $user = User::where('id_emplacement',$id_emplacement)->get();
        }
        $emplacement = Emplacement::all();
        // $user=User::where('name','jack')->where('id',1)->get();
         $active_tab='utilisateur';
        return view('users.liste', compact('user', 'emplacement','active_tab'));
    }
    public function detailsUtilisateur($id)
    {
        $utilisateur = User::where('id', $id)->get()->first();
        $emplacement = Emplacement::where('id', $utilisateur->id_emplacement)->get()->first();
        $utilisateur['emplacement'] = $emplacement->emplacement;
        $active_tab='utilisateur';
        return view('users.details', compact('utilisateur','active_tab', 'emplacement'));
    }
    public function editUtilisateur($id)
    {
        $utilisateur = User::where('id', $id)->get()->first();
        $emplacement = Emplacement::where('id', $utilisateur->id_emplacement)->get()->first();
        $utilisateur['emplacement'] = $emplacement->emplacement;
        $emplacement = Emplacement::all();
         $active_tab='utilisateur';
        return view('users.modifier', compact('utilisateur', 'emplacement','active_tab'));
    }
    public function modifierUtilisateur(Request $request)
    {
        $this->validate($request, [
            'idutilisateur' => 'required',
            'id_emplacement' => 'required',
            'nom_utilisateur' => 'required',
            'prenom_utilisateur' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->idutilisateur,
            'password' => 'nullable|min:8|confirmed',
            'equipe' => 'required',
            'societe' => 'required',
            'contact_utilisateur' => 'required',
        ]);
        $id = $request['idutilisateur'];
        $utilisateurData = $request->all();
        $utilisateurData['password'] = Hash::make($request['password']);
        //update post data
        User::find($id)->update($utilisateurData);
        $notification = 'Utilisateur modifié avec succès';
        $user = User::all();
         $active_tab='utilisateur';
        return view('users.liste', compact('user', 'notification','active_tab'));
    }
    // protected function delete(User $id)
    // {
    //     //dd($pub)
    //     $id->delete();
    //     $notification = 'Utilisateur supprimé avec succès';
    //     $user = User::all();
    //      $active_tab='utilisateur';
    //     return view('users.liste', compact('user', 'notification','active_tab'));
    // }
    public function delete(Request $request, User $id)
    {
        if ($request->ajax()) {
            try {
                $id->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Utilisateur supprimé avec succès.',
                    'id' => $id->id
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la suppression.',
                    'error' => $e->getMessage()
                ], 500);
            }
        }

        // Si ce n'est pas une requête AJAX
        abort(403, 'Requête non autorisée.');
    }
}
