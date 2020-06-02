<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Vehicule;
use DB;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /*Mise à jour des pressions*/
        $vehicules=Vehicule::All();
        foreach ($vehicules as $vehicule) {
            if($vehicule->etatPneu)
            {
                $diff=round((strtotime(date("Y/m/d"))-strtotime($vehicule->dernierePerte))/2592000);
                for($i=0;$i<count(unserialize($vehicule->etatPneu));$i++)
                {
                    $etatPneu[$i]=unserialize($vehicule->etatPneu)[$i]-(0.1*$diff);
                }

                $vehicule->etatPneu=serialize($etatPneu);
                $vehicule->dernierePerte=date("y/m/d");
                $vehicule->save();
            }
            unset($etatPneu); 
            $etatPneu = array();
        }
        /*Mise à jour des alert*/
        foreach($vehicules as $vehicule)
        {
            if(strtotime(date('y-m-d'))-strtotime($vehicule->dateAlert)>30)
            {
                $vehicule->alert=0;
                $vehicule->save();
            }
            if(strtotime(date('y-m-d'))-strtotime($vehicule->dateAlertP)>30)
            {
                $vehicule->alertP=0;
                $vehicule->save();
            }
        }
        /*Vérification si l'user est déj accepté*/
   
            $maintenanceEff=DB::table('maintenances')
                ->join('rendez_vous','rendez_vous.id','maintenances.rdv_id')
                ->join('vehicules','vehicules.id','rendez_vous.vehicule_id')
                ->selectRaw('immatriculation,operations,maintenances.id as id,facture')
                ->join('users','users.id','vehicules.conducteur_id')
                ->where('finished','=',2)
                ->where('entreprise',auth()->user()->entreprise)
                ->get();
            $vehiculesInscrit=DB::Table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('count(vehicules.id) as nombre,entreprise')
            ->where('entreprise',auth()->user()->entreprise)
            ->groupBy('entreprise')
            ->get();
            $vehiculesM=DB::Table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->join('rendez_vous','rendez_vous.vehicule_id','vehicules.id')
            ->selectRaw('count(vehicules.id) as nombre,entreprise,finished')
            ->where('entreprise',auth()->user()->entreprise)
            ->where('finished',1)
            ->groupByRaw('entreprise,finished')
            ->get();
            $pRdvs=DB::Table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->join('rendez_vous','rendez_vous.vehicule_id','vehicules.id')
            ->selectRaw('date,entreprise,immatriculation,accepted,finished,marque,model,heure')
            ->orderByRaw('date','desc')
            ->where('entreprise',auth()->user()->entreprise)
            ->where('accepted',2)
            ->where('finished',0)
            ->where('date','>=',date('Y-m-d'))
            ->get();
            return view('home')
            ->with('vehiculesM',$vehiculesM)
            ->with('vehiculesInscrit',$vehiculesInscrit)
            ->with('pRdvs',$pRdvs)
            ->with('maintenanceEffs',$maintenanceEff);

        }                   
    
}
