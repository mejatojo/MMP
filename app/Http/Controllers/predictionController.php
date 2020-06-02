<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Model\Vehicule;
use App;
use App\Model\Maintenance;
use App\User;
use App\Mail\SendMail;
class predictionController extends Controller
{ 
    public function index()
    {
        if(auth()->user()->role=='responsable')
        {
            $vehicules=DB::table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('vehicules.*,entreprise,vehicules.active')
            ->where('conducteur_id',auth()->user()->id)->where('vehicules.active','!=',1)->get();
        }
        else{
    	   $vehicules=DB::table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('vehicules.*,entreprise,vehicules.active')
            ->where('vehicules.active','!=',1)
            ->get();
        }
    	return view('predictions.liste')
    		->with('vehicules',$vehicules);
    }
    public function store(Request $req)
    {
    	if(auth()->user()->role=='responsable')
        {
            $vehicules=DB::table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('vehicules.*,entreprise')
            ->where('conducteur_id',auth()->user()->id)
            ->get();
        }
        else{
          $vehicules=DB::table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('vehicules.*,entreprise')
            ->get();
        }
    	return view('predictions.liste')
    		->with('vehicules',$vehicules)
    		->with('datefin',$req->date);
    }
    /*public function facture($id)
    {
        $maintenance=DB::table('maintenances')
                ->join('rendez_vous','rendez_vous.id','maintenances.rdv_id')
                ->join('vehicules','vehicules.id','rendez_vous.vehicule_id')
                ->join('users','users.id','vehicules.conducteur_id')
                ->where('finished','=',2)
                ->where('maintenances.id',$id)
                ->get();
        return view('facture.fichier')->with('maintenance',$maintenance);
        $pdf=App::make('dompdf.wrapper');
        $pdf->loadView('facture.fichier',compact('maintenance'));
        return $pdf->stream();
    }*/
    public function facture(Request $req)
    {
        $maintenance=Maintenance::find($req->id);
        $maintenance->facture=$req->file->getClientOriginalName();
        $maintenance->save();
        $path=$req->file->storeAs('public', $req->file->getClientOriginalName());
        return redirect()->back();
    }
    public function factureV(Request $req)
    {
        $vehicule=Vehicule::find($req->id);
        $vehicule->factureV=$req->file->getClientOriginalName();
        $vehicule->save();
        $path=$req->file->storeAs('public', $req->file->getClientOriginalName());
        return redirect()->back();
    }
    public function alert(Request $req)
    {
        $id=$req->id;
        $vehicule=DB::table('vehicules')
        ->join('users','users.id','vehicules.conducteur_id')
        ->where('vehicules.id',$id)
        ->get();
        $vehiculeUpdate=Vehicule::find($id);
        $vehiculeUpdate->alertP=1;
        $vehiculeUpdate->dateAlertP=date("Y/m/d");
        $vehiculeUpdate->save();
        $responsable=User::where('role','responsable')->where('entreprise',$vehicule[0]->entreprise)->get();
        if($req->texte=='')
        { 
        $details = [
            'title' => 'Vous devez voir la prédiction de  '.$vehicule[0]->immatriculation
            .' '.$vehicule[0]->model.'('.$vehicule[0]->marque.') de l\'entreprise '.$vehicule[0]->entreprise.'.Merci de vous connecter sur MMP06.',
            'body' => "l'equipe de MMP06",
        ];
        }
        else
        {
            $details = [
                'title' => $req->texte,
                'body' => "L'équipe de MMP"
            ];
        }

        \Mail::to($responsable[0]->email)->send(new SendMail($details));
         $notif=array(
            'message'=>'Véhicule alertée',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notif);
    }
    
}
