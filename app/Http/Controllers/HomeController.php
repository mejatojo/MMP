<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Vehicule;
use DB;
use App\Mail\SendMail;
use App\Model\Alerte;
use App\User;
use Artisan;
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
    public function accueil()
    {
        return view('app.content');
    }
    public function index()
    {
        //Creation de lien
        Artisan::call('storage:link');
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

        /*Mise à jour des alert et alerte automatique*/
        foreach($vehicules as $vehicule)
        {
            $stop=0;
            $count=0;
            if((strtotime(date('y-m-d'))-strtotime($vehicule->dateAlertP))/86400>15)
            {
                $vehicule->alertP=0;
                $vehicule->save();
            }
            if($vehicule->t1!=null and $vehicule->t2!=null and $vehicule->active==0 and $vehicule->alertP==0)
            {

                if(count(unserialize($vehicule->t2))==8)
                {
                    $diff=(strtotime(unserialize($vehicule->t2)[7])-strtotime(unserialize($vehicule->t1)[7]))/86400;
                }
                if(count(unserialize($vehicule->t2))==6)
                {
                    $diff=(strtotime(unserialize($vehicule->t2)[5])-strtotime(unserialize($vehicule->t1)[5]))/86400;
                }
                for($i=0;$i<count(unserialize($vehicule->hGomme));$i++)
                    {
                        $tab[$i]=unserialize($vehicule->hGomme)[$i];
                    }
                while($stop!=1)
                {
                    for($i=0;$i<count(unserialize($vehicule->hGomme));$i++)
                        {
                            if($diff==0)
                            {
                                $diff=1;
                            }
                            $tab[$i]=$tab[$i]-(unserialize($vehicule->t1)[$i]-unserialize($vehicule->t2)[$i])/$diff;
                            if($tab[$i]<$vehicule->limiteHg)
                            {
                                $stop=1;
                            }
                        }
                    $count++;
                    if($count>1000)
                    {
                        $stop=1;
                    }
                }
            $nbjour=(strtotime($vehicule->derniereMaintenance)+86400*$count-strtotime(date('y-m-d')))/86400;
               if($nbjour<=15)
               {
                $alert=new Alerte();
                $alert->vehicule_id=$vehicule->id;
                $alert->message='Bonjour, MMP vous informe que les pneus avant et/ou arrière du véhicule '.$vehicule->immatriculation
                .' '.$vehicule->model.'('.$vehicule->marque.') doivent être remplacés dans moins de 15 jours. Veuillez vous connecter sur le site de MMP (https://mmp06.fr) pour prendre un rendez_vous';
                $alert->save();

                $vehicule->alertP=1;
                $vehicule->dateAlertP=date("Y/m/d");
                $vehicule->save();
                $user=User::find($vehicule->conducteur_id);
                $details = [
                'header' => 'Bonjour ,',
                'p1' => 'MMP vous informe que les pneumatiques avants et/ou arrières du véhicule '.$vehicule->immatriculation
            .' '.$vehicule->model.'('.$vehicule->marque.') doivent être remplacés dans moins de 15 jours. Veuillez vous connecter sur le site de MMP (https://mmp06.fr) pour prendre un rendez_vous',
        ];
        \Mail::to($vehicule->emailH)->send(new SendMail($details));
        \Mail::to($user->email)->send(new SendMail($details));
               }
            }
        }
        /*Vérification si l'user est déja accepté*/
        if(auth()->user()->active==1)
            {
                Auth::logout(); 
                return view('auth.login');
            }
            $maintenanceEff=DB::table('maintenances')
                ->join('rendez_vous','rendez_vous.id','maintenances.rdv_id')
                ->join('vehicules','vehicules.id','rendez_vous.vehicule_id')
                ->selectRaw('immatriculation,operations,maintenances.id as id,facture,date')
                ->join('users','users.id','vehicules.conducteur_id')
                ->where('finished','=',2)
                ->where('entreprise',auth()->user()->entreprise)
                ->get();
            $vehiculesInscrit=DB::Table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('count(vehicules.id) as nombre,entreprise')
            ->where('vehicules.active',0)
            ->where('entreprise',auth()->user()->entreprise)
            ->groupBy('entreprise')
            ->get();
            $vehiculesM=DB::Table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->join('rendez_vous','rendez_vous.vehicule_id','vehicules.id')
            ->selectRaw('count(vehicules.id) as nombre,entreprise,finished')
            ->where('entreprise',auth()->user()->entreprise)
            ->where('rendez_vous.date',date('Y-m-d'))
            ->where('finished','!=',0)
            ->groupByRaw('entreprise,finished')
            ->get();
            $pRdvs=DB::Table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->join('rendez_vous','rendez_vous.vehicule_id','vehicules.id')
            ->selectRaw('date,entreprise,immatriculation,accepted,finished,marque,model,heure,commentaire')
            ->orderByRaw('date','desc')
            ->where('entreprise',auth()->user()->entreprise)
            ->where('accepted',2)
            ->where('finished',0)
            ->where('date','>=',date('Y-m-d'))
            ->get();
            if(auth()->user()->role=='superadmin' or auth()->user()->role=='conducteur')
            {
                return redirect('vehicules');
            }
            return view('home')
            ->with('vehiculesM',$vehiculesM)
            ->with('vehiculesInscrit',$vehiculesInscrit)
            ->with('pRdvs',$pRdvs)
            ->with('maintenanceEffs',$maintenanceEff)
            ->with('nbRdv',$this->nombreRdv());
            ;

        }     
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
    
}
