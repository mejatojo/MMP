<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Model\Vehicule;
use App;
use App\Model\Maintenance;
use App\User;
use App\Mail\SendMail;
use App\Model\Alerte;
class predictionController extends Controller
{ 
     public function nombreRdv()
    {
        $rendezVousNb = DB::table('rendez_vous')
                ->join('vehicules','vehicules.id','rendez_vous.vehicule_id')
                ->join('users','users.id','vehicules.conducteur_id')
                ->selectRaw('accepted,count(rendez_vous.id) as nb')
                ->groupBy('accepted')
                ->where('accepted',0)
                ->get();
        if(isset($rendezVousNb[0]))
                {
                    return $rendezVousNb[0]->nb;
                }
                else
                {
                    return 0;
                }
    }
    public function contact(Request $req)
    {
        $details = [
            'title' => $req->su.' : '.$req->body,
            'body' => 'Expéditeur : '.$req->name.'    ('.$req->email.')',
        ];
        \Mail::to('contactmmp06@gmail.com')->send(new SendMail($details));
        $notif=array(
            'message'=>'Message envoyé',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notif);
    }
    public function index()
    {
        $References=DB::table('references')
        ->join('stocks','stocks.reference_id','references.id')
        ->selectRaw('stocks.id,reference,reference_id,kInit')
        ->get();
        if(auth()->user()->role=='responsable')
        {
            $vehicules=DB::table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('vehicules.*,entreprise,vehicules.active,limitePression,limiteP,limiteHg')
            ->where('conducteur_id',auth()->user()->id)->where('vehicules.active','!=',1)->get();
        }
        elseif(auth()->user()->role=='superadmin'){
    	   $vehicules=DB::table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('vehicules.*,entreprise,vehicules.active,limitePression,limiteP,limiteHg')
            ->where('vehicules.active','!=',1)
            ->get();
        }
        else{
            $responsable=User::where('role','responsable')->where('entreprise',auth()->user()->entreprise)->first();
           $vehicules=DB::table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('vehicules.*,entreprise,vehicules.active,limitePression,limiteP,limiteHg')
            ->where('conducteur_id',$responsable->id)->where('vehicules.active','!=',1)->get();
        }
    	return view('predictions.liste')
    		->with('vehicules',$vehicules)
            ->with('references',$References)
            ->with('nbRdv',$this->nombreRdv());
    }
    public function store(Request $req)
    {
       $References=DB::table('references')
        ->join('stocks','stocks.reference_id','references.id')
        ->selectRaw('stocks.id,reference,reference_id,kInit')
        ->get();
        if(auth()->user()->role=='responsable')
        {
            $vehicules=DB::table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('vehicules.*,entreprise,vehicules.active,limitePression,limiteP,limiteHg')
            ->where('conducteur_id',auth()->user()->id)->where('vehicules.active','!=',1)->get();
        }
        elseif(auth()->user()->role=='superadmin'){
           $vehicules=DB::table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('vehicules.*,entreprise,vehicules.active,limitePression,limiteP,limiteHg')
            ->where('vehicules.active','!=',1)
            ->get();
        }
        else{
            $responsable=User::where('role','responsable')->where('entreprise',auth()->user()->entreprise)->first();
           $vehicules=DB::table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('vehicules.*,entreprise,vehicules.active,limitePression,limiteP,limiteHg')
            ->where('conducteur_id',$responsable->id)->where('vehicules.active','!=',1)->get();
        }
    	return view('predictions.liste')
    		->with('vehicules',$vehicules)
    		->with('datefin',$req->date)
            ->with('references',$References)
            ->with('nbRdv',$this->nombreRdv());
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
            'title' => 'Bonjour, MMP vous informe que les pneumatiques avants et/ou arrières du véhicule '.$vehicule[0]->immatriculation
            .' '.$vehicule[0]->model.'('.$vehicule[0]->marque.') doivent être remplacés dans moins de 15 jours. Veuillez vous connecter sur le site https://mmp06.fr pour prendre un rendez_vous',
            'body' => "l'equipe de MMP",
        ];
        $alert=new Alerte();
            $alert->vehicule_id=$req->id;
            $alert->message='Bonjour, MMP vous informe que les pneumatiques avants et/ou arrières du véhicule '.$vehicule[0]->immatriculation
            .' '.$vehicule[0]->model.'('.$vehicule[0]->marque.') doivent être remplacés dans moins de 15 jours. Veuillez vous connecter sur le site https://mmp06.fr pour prendre un rendez_vous';
            $alert->save();
        }
        else
        {
            $details = [
                'title' => $req->texte,
                'body' => "L'équipe de MMP"
            ];
            $alert=new Alerte();
            $alert->vehicule_id=$req->id;
            $alert->message=$req->texte;
            $alert->save();
        }

        \Mail::to($responsable[0]->email)->send(new SendMail($details));
        \Mail::to($vehiculeUpdate->emailH)->send(new SendMail($details));
         $notif=array(
            'message'=>'Véhicule alertée',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notif);
    }
    
}
