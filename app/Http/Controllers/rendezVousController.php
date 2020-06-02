<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Vehicule;
use App\Model\RendezVous;
use App\Model\Maintenance;
use App\Model\Date;
use DB;
use Illuminate\Support\Facades\Validator;

class rendezVousController extends Controller
{
    public function modifierRapide(Request $req)
    {
        $maintenance=Maintenance::find($req->id);
        $maintenance->operations=$req->operations;
        $maintenance->save();
        $notif=array(
            'message'=>'Modification réussie',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notif);
    }
    public function effacer($id)
    {
        $user=Maintenance::find($id);
        $user->delete();
        $notif=array(
            'message'=>'Suppression réussie',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notif);
    }
    public function bloquer(Request $req)
    {
        $date=new Date();
        $date->datebloque=$req->date;
        $date->save();
        $notif=array(
            'message'=>' Date bloquée',
            'alert-type'=>'success'
                            );
        return redirect()->back()->with($notif);

    }
    public function debloquer($id)
    {
        $date=Date::find($id);
        $date->delete();
        $notif=array(
            'message'=>' Date débloquée',
            'alert-type'=>'success'
                            );
        return redirect()->back()->with($notif);

    }
    public function finished($id,Request $req)
    {
        $maintenance=Maintenance::where('rdv_id',$id)->get();
        $maintenance[0]->fin=date('y-m-d H:i:s');
        $maintenance[0]->operations=$req->operation;
        $maintenance[0]->observations=$req->observation;
        $maintenance[0]->save(); 
        $rdv=RendezVous::find($id);
        $rdv->finished=2;
        $rdv->save();
        $vehicule=Vehicule::find($rdv->vehicule_id);
        if($req->file!=null)
        {
            $path=$req->file->storeAs('public', $req->file->getClientOriginalName());
            $vehicule->imageV=$req->file->getClientOriginalName();
        }
        if($req->file2!=null)
        {
            $paths=$req->file2->storeAs('public', $req->file2->getClientOriginalName());
            $vehicule->imageV2=$req->file2->getClientOriginalName();
        }
        $vehicule->derniereMaintenance=date('Y-m-d');
        $vehicule->observations=$req->observation;
        $vehicule->save();
        return redirect()->route('historiques');
    }
    public function create()
    {

       $rdvdetails=DB::table('rendez_vous')
            ->join('vehicules','vehicules.id','rendez_vous.vehicule_id')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('date,heure,entreprise')
            ->where('accepted',2)
            ->get();
            $datebloquees=Date::All();
          $rdvs=RendezVous::
          selectRaw('count(date) as compte,date,accepted')
          ->groupByRaw('date,accepted')
          ->where('accepted',2)
          ->get();
                $rendezVous = DB::table('rendez_vous')
                ->join('vehicules','vehicules.id','rendez_vous.vehicule_id')
                ->join('users','users.id','vehicules.conducteur_id')
                ->selectRaw('accepted,commentaire,name,immatriculation,rendez_vous.date as daty,rendez_vous.id as id,heure')
                ->where('accepted',0)
                ->get();
                 $rendezVousAcc = DB::table('rendez_vous')
                 ->join('vehicules','vehicules.id','rendez_vous.vehicule_id')
                ->join('users','users.id','vehicules.conducteur_id')
                ->selectRaw('accepted,commentaire,name,immatriculation,rendez_vous.date as daty,rendez_vous.id as id,heure')
                ->where('accepted',2)
                ->get();
                 $rendezVousRef = DB::table('rendez_vous')
                ->join('vehicules','vehicules.id','rendez_vous.vehicule_id')
                ->join('users','users.id','vehicules.conducteur_id')
                ->selectRaw('accepted,commentaire,name,immatriculation,rendez_vous.date as daty,rendez_vous.id as id,heure')
                ->where('accepted',1)
                ->get();;
            $vehicules=DB::table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('immatriculation,vehicules.id as ide')
            ->where('entreprise',auth()->user()->entreprise)->get();
            return view('rendezVous.demander')->with('vehicules',$vehicules)
                ->with('rendezVous',$rendezVous)
                ->with('rendezVousRef',$rendezVousRef)
                ->with('rendezVousAcc',$rendezVousAcc)
                ->with('rdvs',$rdvs)
                ->with('rdvdetails',$rdvdetails)
                ->with('datebloquees',$datebloquees);
    }
    public function index()
    {
        if(auth()->user()->role=='superadmin')
        {
            $rdvdetails=DB::table('rendez_vous')
            ->join('vehicules','vehicules.id','rendez_vous.vehicule_id')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('date,heure,entreprise')
            ->where('accepted',2)
            ->get();
            $datebloquees=Date::All();
          $rdvs=RendezVous::
          selectRaw('count(date) as compte,date,accepted')
          ->groupByRaw('date,accepted')
          ->where('accepted',2)
          ->get();
                $rendezVous = DB::table('rendez_vous')
                ->join('vehicules','vehicules.id','rendez_vous.vehicule_id')
                ->join('users','users.id','vehicules.conducteur_id')
                ->selectRaw('accepted,commentaire,name,immatriculation,rendez_vous.date as daty,rendez_vous.id as id,heure')
                ->where('accepted',0)
                ->get();
                 $rendezVousAcc = DB::table('rendez_vous')
                 ->join('vehicules','vehicules.id','rendez_vous.vehicule_id')
                ->join('users','users.id','vehicules.conducteur_id')
                ->selectRaw('accepted,commentaire,name,immatriculation,rendez_vous.date as daty,rendez_vous.id as id,heure')
                ->where('accepted',2)
                ->get();
                 $rendezVousRef = DB::table('rendez_vous')
                ->join('vehicules','vehicules.id','rendez_vous.vehicule_id')
                ->join('users','users.id','vehicules.conducteur_id')
                ->selectRaw('accepted,commentaire,name,immatriculation,rendez_vous.date as daty,rendez_vous.id as id,heure')
                ->where('accepted',1)
                ->get();
                return view('rendezVous.rendezVous')
                ->with('rendezVous',$rendezVous)
                ->with('rendezVousRef',$rendezVousRef)
                ->with('rendezVousAcc',$rendezVousAcc)
                ->with('rdvs',$rdvs)
                ->with('rdvdetails',$rdvdetails)
                ->with('datebloquees',$datebloquees);
            }
        
    }
    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'date' => 'required',
            'heure' => 'required',
            'vehicule' => 'required',
            'comment' => 'required',
        ]);

        if ($validator->fails()) {
            $notif=array(
            'message'=>'Veuillez remplir tous les champs',
            'alert-type'=>'error'
        );
        return redirect()->back()->with($notif);
        }
    	$lesRdv=RendezVous::All();
    	foreach ($lesRdv as $lerdv) {
    		if($lerdv->vehicule_id==$req->vehicule and $lerdv->finished==0 and $lerdv->accepted!=1)
    		{
    		$notif=array(
    		'message'=>' Cette véhicule a déjà un rendez_vous',
    		'alert-type'=>'error'
    						);
    			return redirect()->back()->with($notif);
    		}
    	}
    	$rendezVous=new RendezVous();
    	$rendezVous->date=$req->date;
        $rendezVous->heure=$req->heure;
    	$rendezVous->vehicule_id=$req->vehicule;
    	$rendezVous->commentaire=$req->comment;
    	$rendezVous->save();
    	$notif=array(
    		'message'=>'Requête envoyée',
    		'alert-type'=>'success'
    	);
    	return redirect()->back()->with($notif);

    }
    public function accept($id)
    {
        $rdv=RendezVous::find($id);
        $rdv->accepted=2;
        $rdv->raison=null;
        $rdv->save();
        $notif=array(
            'message'=>'Rendez-vous accepté',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notif);
    }
    public function reject(Request $req)
    {
        $rdv=RendezVous::find($req->id);
        $rdv->accepted=1;
        $rdv->raison=$req->raison;
        $rdv->save();
        $notif=array(
            'message'=>'Rendez-vous rejeté',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notif);
    }
    public function liste()
    {
         $rendezVous = DB::table('rendez_vous')
            ->join('vehicules','vehicules.id','rendez_vous.vehicule_id')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('users.id as id,immatriculation,name,rendez_vous.date as daty,commentaire,accepted,finished,heure,raison')
            ->where('users.entreprise',auth()->user()->entreprise)
            ->get();
            return view('rendezVous.liste')->with('rendezVous',$rendezVous);
    }
    public function calendar()
    {
      /*  return auth()->user()->email;
    */
      $rendez_Vous=RendezVous::
      selectRaw('count(date) as compte,date,accepted')
      ->groupByRaw('date,accepted')
      ->where('accepted',2)
      ->get();
      $rdvdetails=RendezVous::
      selectRaw('date,heure')
      ->where('accepted',2)
      ->get();
    return view('rendezVous.calendar')->with('rdvs',$rendez_Vous)->with('rdvdetails',$rdvdetails);
    }
    public function maintenances()
    {
        if(auth()->user()->role=='superadmin' or auth()->user()->role=='operateur')
        {
        $rendez_Vous=DB::table('rendez_vous')
                ->join('vehicules','vehicules.id','rendez_vous.vehicule_id')
                ->join('users','users.id','vehicules.conducteur_id')
                ->selectRaw('users.*,vehicules.*,rendez_vous.*')
                ->where('date',date('y-m-d'))
                ->where('accepted',2)
                ->where('finished','!=',2)
                ->orderBy('heure','asc')
                ->get();
        
       
        return view('maintenances.rendezVousToday')
        ->with('rdvs',$rendez_Vous);
        }
    }
    public function maintenanceRapide()
    {
        if(auth()->user()->role=='superadmin' or auth()->user()->role=='operateur')
        {
        $rdvRapides=DB::table('vehicules')
                ->join('users','users.id','vehicules.conducteur_id')
                ->selectRaw('immatriculation,marque,model,entreprise,email,phone,vehicules.id as id')
                ->get();
       return view('maintenances.maintenanceRapide')->with('rdvRapides',$rdvRapides);
        } 
    }
    public function historique()
    {
        if(auth()->user()->role=='superadmin' or auth()->user()->role=='operateur')
        {
         $maintenanceEff=DB::table('maintenances')
                ->join('rendez_vous','rendez_vous.id','maintenances.rdv_id')
                ->join('vehicules','vehicules.id','rendez_vous.vehicule_id')
                ->join('users','users.id','vehicules.conducteur_id')
                ->selectRaw('immatriculation,marque,model,phone,email,entreprise,operations,debut,fin,maintenances.id as id,facture')
                ->where('finished','=',2)
                ->get();
        return view('maintenances.historique')->with('maintenanceEffs',$maintenanceEff);
        }
    }
    public function hvehicule($id)
    {
        if(auth()->user()->role=='superadmin' or auth()->user()->role=='operateur')
        {
         $maintenanceEff=DB::table('maintenances')
                ->join('rendez_vous','rendez_vous.id','maintenances.rdv_id')
                ->join('vehicules','vehicules.id','rendez_vous.vehicule_id')
                ->join('users','users.id','vehicules.conducteur_id')
                ->selectRaw('immatriculation,marque,model,phone,email,entreprise,operations,debut,fin,maintenances.id as id,facture')
                ->where('finished','=',2)
                ->where('vehicules.id',$id)
                ->get();
        return view('maintenances.historique')->with('maintenanceEffs',$maintenanceEff);
        }
    }
}
