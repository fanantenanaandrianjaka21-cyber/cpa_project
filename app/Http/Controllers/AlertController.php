<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Alertes_destinataires;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AlertController extends Controller
{
    public function ConfigureAlert(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'email_destinataire' => 'required',
            'niveau_seuil' => 'required',
            'niveau_critique' => 'required',
            // 'type_materiel' => 'required',
            'par_jour' => 'nullable',
            'heure_envoie_par_jour' => 'required',
            'hebdomadaire' => 'nullable',
            'jour_du_semaine' => 'required',
            'heure_envoie_par_semaine' => 'required',
        ]);
        if(!empty($request['par_jour'])){
            $request['par_jour']=true;
        }else {
            $request['par_jour']=false;
        }
                if($request['hebdomadaire']=='on'){
            $request['hebdomadaire']=true;
        }else{
            $request['hebdomadaire']=false;
        }
            // dd($request);
        // Alert::create([
        //     'email_destinataire' => $request['email_destinataire'],
        //     'niveau_seuil' => $request['niveau_seuil'],
        //     'niveau_critique' => $request['niveau_critique'],
        //     'type_materiel' => $request['type_materiel'],
        //     'par_jour' => $request['par_jour'],
        //     'heure_envoie_par_jour' => $request['heure_envoie_par_jour'],
        //     'hebdomadaire' => $request['hebdomadaire'],
        //     'jour_du_semaine' => $request['jour_du_semaine'],
        //     'heure_envoie_par_semaine' => $request['heure_envoie_par_semaine'],
        // ]);
        // dd($request);
        $nouveauconfiguration = $request->all();
        Alert::find(1)->update($nouveauconfiguration);
        // $alert = Alert::all();
        $notification = 'Cofiguration enregistré  avec succès';
        $active_tab = 'dashbord';
            return redirect()->route('dashboard')->with('notification', $notification,'active_tab',$active_tab);
    }

    // Afficher la liste des alertes
    public function index()
    {
        $alerte = DB::table('alerts')->get()->first();
        $types=DB::table('alertes_types')->get();
        $destinataires=DB::table('alertes_destinataires')->get();
        // dd($destinataires);
        // $alertes = Alert::with(['types','destinataires']);
        // dd($alertes);
        $active_tab = 'dashbord';
        return view('alertes.index', compact('alerte','types','destinataires'))->with('active_tab',$active_tab);
    }



    // Mettre à jour une alerte
    public function updateAlerteTypes(Request $request, $id)
    {
        $request->validate([
            // 'email_destinataire' => 'required|email',
            'niveau_seuil' => 'required|integer|min:1',
            'niveau_critique' => 'required|integer|min:1',
            // 'par_jour' => 'boolean',
            // 'heure_envoie_par_jour' => 'nullable|string',
            // 'hebdomadaire' => 'boolean',
            // 'jour_du_semaine' => 'nullable|string',
            // 'heure_envoie_par_semaine' => 'nullable|string',
        ]);

        // DB::table('alerts')->where('id', $id)->update([
        //     'email_destinataire' => $request->email_destinataire,
        //     'niveau_seuil' => $request->niveau_seuil,
        //     'niveau_critique' => $request->niveau_critique,
        //     'par_jour' => $request->par_jour ?? false,
        //     'heure_envoie_par_jour' => $request->heure_envoie_par_jour,
        //     'hebdomadaire' => $request->hebdomadaire ?? false,
        //     'jour_du_semaine' => $request->jour_du_semaine,
        //     'heure_envoie_par_semaine' => $request->heure_envoie_par_semaine,
        // ]);
                DB::table('alertes_types')->where('id', $id)->update([
            'niveau_seuil' => $request->niveau_seuil,
            'niveau_critique' => $request->niveau_critique,
           
        ]);

        return redirect()->back()->with('success', 'Alerte mise à jour avec succès.');
    }
        public function update(Request $request, $id)
    {
        $request->validate([
            'par_jour' => 'boolean',
            'heure_envoie_par_jour' => 'nullable|string',
            'hebdomadaire' => 'boolean',
            'jour_du_semaine' => 'nullable|string',
            'heure_envoie_par_semaine' => 'nullable|string',
        ]);

        DB::table('alerts')->where('id', $id)->update([
            'par_jour' => $request->par_jour ?? false,
            'heure_envoie_par_jour' => $request->heure_envoie_par_jour,
            'hebdomadaire' => $request->hebdomadaire ?? false,
            'jour_du_semaine' => $request->jour_du_semaine,
            'heure_envoie_par_semaine' => $request->heure_envoie_par_semaine,
        ]);


        return redirect()->back()->with('success', 'Alerte mise à jour avec succès.');
    }

        public function updateDestinataire(Request $request, $id)
    {
        $request->validate([
            'email_destinataire' => 'required|email',
        ]);

        DB::table('alertes_destinataires')->where('id', $id)->update([
            'email_destinataire' => $request->email_destinataire,
        ]);
              

        return redirect()->back()->with('success', 'Destinataire mise à jour avec succès.');
    }

    public function insertionmailalert(Request $data)
    {
        $this->validate($data, [
            'email_destinataire' => 'required',
        ]);

        Alertes_destinataires::create([
            'alerte_id' => 1,
            'email_destinataire' => $data['email_destinataire'],
        ]);

        $active_tab = 'dashbord';

        return redirect()->route('alertes.index')->with('active_tab',$active_tab);
        // return view('alertes.index', compact('alerte', 'destinataires'));
    }

    public function deleteDestinataire($id)
    {
        Alertes_destinataires::destroy($id);
        $active_tab = 'dashbord';

        return back()->with('success', 'Email supprimé avec succès !')->with('active_tab',$active_tab);
    }

}
