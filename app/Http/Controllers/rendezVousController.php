<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Vehicule;
use App\Model\RendezVous;
use App\Model\Maintenance;
use App\Model\Stock;
use App\Model\Date;
use App\User;
use DB;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class rendezVousController extends Controller
{
    public function destroy($id)
    {
        $rdv=RendezVous::find($id);
        $rdv->delete();
        $notif=array(
            'message'=>'Suppression réussie',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notif);
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
    public function modifier(Request $req)
    {
        $rdv=RendezVous::find($req->id);
        $rdv->commentaire=$req->commentaire;
        $rdv->date=$req->date;
        $rdv->heure=$req->time;
        $event = Event::find($rdv->calendarId);

        $event->startDateTime = new Carbon(date('Y-m-d',strtotime($rdv->date)).date('H:i:s',strtotime($rdv->heure)));
        $event->endDateTime =new Carbon(date('Y-m-d',strtotime($rdv->date)).date('H:i:s',strtotime($rdv->heure)));
        $event->description=$rdv->commentaire;
        $calendarEvent=$event->save();
        $rdv->calendarId=$calendarEvent->id;
        $rdv->save();
        $rdv->save();
        $notif=array(
            'message'=>'Modification réussie',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notif);
    }
    public function show($id)
    {
        if(auth()->user()->role=='responsable')
        {
            $vehicules=DB::table('vehicules')
                ->join('users','users.id','vehicules.conducteur_id')
                ->selectRaw('immatriculation,vehicules.id as ide')
                ->where('vehicules.active',0)
                ->where('vehicules.id',$id)
                ->where('users.id',auth()->user()->id)->get();
        }
        else
        {
            $responsable=User::where('role','responsable')->where('active',0)->where('entreprise',auth()->user()->entreprise)->first();
           $vehicules=DB::table('vehicules')
                ->join('users','users.id','vehicules.conducteur_id')
                ->selectRaw('immatriculation,vehicules.id as ide')
                ->where('vehicules.active',0)
                ->where('vehicules.id',$id)
                ->where('users.id',$responsable->id)->get();
        }
        return view('rendezVous.demander')->with('vehicules',$vehicules)
                    ->with('nbRdv',$this->nombreRdv());
    }
    public function effacer($id)
    {
        $main=Maintenance::find($id);
        $rdv=RendezVous::find($main->rdv_id);
        $vehicule=Vehicule::find($rdv->vehicule_id);
        $kilometrage=$main->kilometrageIn;
        $main->delete();
         $rdv->delete();
        $RendezVous=DB::table('rendez_vous')
            ->join('maintenances','maintenances.rdv_id','rendez_vous.id')
            ->where('finished',2)
            ->where('vehicule_id',$vehicule->id)
            ->orderBy('rendez_vous.date','desc')
            ->get();
        // for($i=0;$i<count(unserialize($vehicule->refPneus));$i++)
        // {
        //     $ref=Stock::find(unserialize($vehicule->refPneus)[$i]);
        //     $ref->kInit=$ref->kInit-($kilometrage-$ref->kInit);
        //     $ref->save();
        // }
        if(isset($RendezVous[0]) && isset($RendezVous[1]))
        {

            if($RendezVous[0]->kilometrageIn==$RendezVous[1]->kilometrageIn)
            {

                for($i=0;$i<count(unserialize($vehicule->hGomme));$i++)
                {
                    $tab[$i]=unserialize($RendezVous[0]->hGommeIn)[$i];
                    $tabRef[$i]=unserialize($RendezVous[0]->referenceIn)[$i];
                }
                $vehicule->hGomme=serialize($tab);
                $vehicule->refPneus=serialize($tabRef);
                array_push($tab,$RendezVous[0]->kilometrageIn,$RendezVous[0]->dControl);
                $vehicule->t2=serialize($tab);
                $vehicule->derniereMaintenance=$RendezVous[0]->date;
                $vehicule->kilometrage=$RendezVous[0]->kilometrageIn;
                $vehicule->permutation=$vehicule->permutation-($vehicule->kilometrage-$kilometrage);
                $vehicule->control=$RendezVous[0]->dControl;
                $t2=DB::table('rendez_vous')
                ->join('maintenances','maintenances.rdv_id','rendez_vous.id')
                ->where('finished',2)
                ->where('vehicule_id',$vehicule->id)
                ->where('fin',$RendezVous[0]->dControl)
                ->get();
                if(isset($t2[0]))
                {
                    $t1=DB::table('rendez_vous')
                    ->join('maintenances','maintenances.rdv_id','rendez_vous.id')
                    ->where('finished',2)
                    ->where('vehicule_id',$vehicule->id)
                    ->where('fin',$t2[0]->dControl)
                    ->get();
                    if(isset($t1[0]))
                    {

                        for($i=0;$i<count(unserialize($t1[0]->hGommeIn));$i++)
                        {
                            $tab1[$i]=unserialize($t1[0]->hGommeIn)[$i];
                        }
                        array_push($tab1,$t1[0]->kilometrageIn,$t1[0]->date);
                        $vehicule->t1=serialize($tab1);
                    }
                    else
                    {
                        $vehicule->t1=$vehicule->tConstant;
                    }
                }
                else
                    {
                        $vehicule->t1=$vehicule->tConstant;
                    }
            }
            else
            {
                for($i=0;$i<count(unserialize($vehicule->hGomme));$i++)
                {
                    $tab[$i]=unserialize($RendezVous[0]->hGommeIn)[$i];
                    $tabRef[$i]=unserialize($RendezVous[0]->referenceIn)[$i];
                }
                $vehicule->hGomme=serialize($tab);
                $vehicule->refPneus=serialize($tabRef);
                array_push($tab,$RendezVous[0]->kilometrageIn,$RendezVous[0]->date);
                $vehicule->t2=serialize($tab);
                $vehicule->derniereMaintenance=$RendezVous[0]->date;
                $vehicule->kilometrage=$RendezVous[0]->kilometrageIn;
                $vehicule->permutation=$vehicule->permutation-($vehicule->kilometrage-$kilometrage);
                $vehicule->control=$RendezVous[0]->date;
                $t1=DB::table('rendez_vous')
                ->join('maintenances','maintenances.rdv_id','rendez_vous.id')
                ->where('finished',2)
                ->where('vehicule_id',$vehicule->id)
                ->where('fin',$RendezVous[0]->dControl)
                ->get();
                if(isset($t1[0]))
                {
                    for($i=0;$i<count(unserialize($t1[0]->hGommeIn));$i++)
                    {
                        $tab1[$i]=unserialize($t1[0]->hGommeIn)[$i];
                    }
                    array_push($tab1,$t1[0]->kilometrageIn,$t1[0]->date);
                    $vehicule->t1=serialize($tab1);
                }
                else
                {
                    $vehicule->t1=$vehicule->tConstant;
                }
            }
        }
        elseif(isset($RendezVous[0]) && !isset($RendezVous[1]))
        {
            if($vehicule->control==$RendezVous[0]->fin)
            {
             
                for($i=0;$i<count(unserialize($vehicule->hGomme));$i++)
                    {
                        $tab[$i]=unserialize($RendezVous[0]->hGommeIn)[$i];
                        $tabRef[$i]=unserialize($RendezVous[0]->referenceIn)[$i];
                    }
                    $vehicule->hGomme=serialize($tab);
                    $vehicule->refPneus=serialize($tabRef);
                    $vehicule->kilometrage=$RendezVous[0]->kilometrageIn;
                     array_push($tab,$RendezVous[0]->kilometrageIn,$vehicule->cConstant);
                     $vehicule->t2=serialize($tab);
                $vehicule->derniereMaintenance=$RendezVous[0]->date;
                $vehicule->control=$vehicule->cConstant;
                $t1=DB::table('rendez_vous')
                ->join('maintenances','maintenances.rdv_id','rendez_vous.id')
                ->where('finished',2)
                ->where('vehicule_id',$vehicule->id)
                ->where('fin',$RendezVous[0]->dControl)
                ->get();
                if(isset($t1[0]))
                {
                    for($i=0;$i<count(unserialize($t1[0]->hGommeIn));$i++)
                    {
                        $tab1[$i]=unserialize($t1[0]->hGommeIn)[$i];
                    }
                    array_push($tab1,$t1[0]->kilometrageIn,$t1[0]->date);
                    $vehicule->t1=serialize($tab1);
                }
                else
                {
                    $vehicule->t1=$vehicule->tConstant;
                }
            }
            else
            {

                for($i=0;$i<count(unserialize($vehicule->hGomme));$i++)
                    {
                        $tab[$i]=unserialize($RendezVous[0]->hGommeIn)[$i];
                        $tabRef[$i]=unserialize($RendezVous[0]->referenceIn)[$i];
                    }
                    $vehicule->hGomme=serialize($tab);
                    $vehicule->refPneus=serialize($tabRef);
                     array_push($tab,$RendezVous[0]->kilometrageIn,$RendezVous[0]->date);
                     $vehicule->t2=serialize($tab);
                $vehicule->derniereMaintenance=$RendezVous[0]->date;
                $vehicule->control=$RendezVous[0]->date;
                $vehicule->kilometrage=$RendezVous[0]->kilometrageIn;
                $t1=DB::table('rendez_vous')
                ->join('maintenances','maintenances.rdv_id','rendez_vous.id')
                ->where('finished',2)
                ->where('vehicule_id',$vehicule->id)
                ->where('fin',$RendezVous[0]->dControl)
                ->get();
                if(isset($t1[0]))
                {
                    for($i=0;$i<count(unserialize($t1[0]->hGommeIn));$i++)
                    {
                        $tab1[$i]=unserialize($t1[0]->hGommeIn)[$i];
                    }
                    array_push($tab1,$t1[0]->kilometrageIn,$t1[0]->date);
                    $vehicule->t1=serialize($tab1);
                }
                else
                {
                    $vehicule->t1=$vehicule->tConstant;
                }
            }
        }
        else
        {
            $vehicule->t2=null;
            $vehicule->t1=$vehicule->tConstant;
            for($i=0;$i<count(unserialize($vehicule->hGomme));$i++)
            {
                $tab1[$i]=unserialize($vehicule->tConstant)[$i];
            }
            $vehicule->hGomme=serialize($tab1);
            $vehicule->refPneus=$vehicule->refPneuInit;
            for($i=0;$i<count(unserialize($vehicule->refPneus));$i++)
            {
                $st=Stock::find(unserialize($vehicule->refPneus)[$i]);
                $st->hgFinal=null;
                $st->kFinal=null;
                $st->save();
            }
            $vehicule->control=$vehicule->cConstant;
            $vehicule->kilometrage=unserialize($vehicule->tConstant)[count(unserialize($vehicule->tConstant))-2];
            $vehicule->derniereMaintenance=unserialize($vehicule->tConstant)[count(unserialize($vehicule->tConstant))-1];
            $vehicule->permutation=$vehicule->limiteP;
        }
        // if(isset($RendezVous[1]))
        // {

        //     for($i=0;$i<count(unserialize($vehicule->hGomme));$i++)
        //     {
        //         $tableau[$i]=unserialize($RendezVous[1]->hGommeIn)[$i];
        //     }
        //     array_push($tableau,$RendezVous[1]->kilometrageIn,$RendezVous[1]->date);
        //     $vehicule->t1=serialize($tableau);
        // }
        // else
        // {
        //      $vehicule->t1=$vehicule->tConstant;
        // }
        $vehicule->save();
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
        $maintenance[0]->fin=date('y-m-d H:i:s',strtotime($req->date));
        $maintenance[0]->operations=$req->operation;
        $maintenance[0]->observations=$req->observation;
        $rdv=RendezVous::find($id);
        $rdv->finished=2;
        $rdv->commentaire=$req->operation;
        $rdv->save();
        $vehicule=Vehicule::find($rdv->vehicule_id);
        if($req->file!=null)
        {
            $path=$req->file->storeAs('public', $req->file->getClientOriginalName());
            $vehicule->imageV=$req->file->getClientOriginalName();
            $maintenance[0]->imageIn1=$req->file->getClientOriginalName();
        }
        if($req->file2!=null)
        {
            $paths=$req->file2->storeAs('public', $req->file2->getClientOriginalName());
            $vehicule->imageV2=$req->file2->getClientOriginalName();
            $maintenance[0]->imageIn2=$req->file2->getClientOriginalName();
        }
        $vehicule->derniereMaintenance=$req->date;
        $vehicule->observations=$req->observation;
        $vehicule->save();
        if($maintenance[0]->referenceIn==null)
        {
            $maintenance[0]->referenceIn=$vehicule->refPneus;
        }
        $maintenance[0]->hGommeIn=$vehicule->hGomme;
        $maintenance[0]->kilometrageIn=$vehicule->kilometrage;
        $maintenance[0]->permutationIn=$vehicule->permutation;
        if($maintenance[0]->dControl==null)
        {
            $maintenance[0]->dControl=$vehicule->control;
        }
        $maintenance[0]->save(); 
        return redirect()->route('historiques');
    }
    public function create()
    {
        if(auth()->user()->role=='responsable')
        {
            $vehicules=DB::table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('immatriculation,vehicules.id as ide')
            ->where('vehicules.active',0)
            ->where('conducteur_id',auth()->user()->id)->get();
        }
        if(auth()->user()->role=='conducteur' or auth()->user()->role=='PDG')
        {
             $responsable=User::where('role','responsable')->where('active',0)->where('entreprise',auth()->user()->entreprise)->first();
            $vehicules=DB::table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('immatriculation,vehicules.id as ide')
            ->where('vehicules.active',0)
            ->where('conducteur_id',$responsable->id)->get();
        }
            return view('rendezVous.demander')->with('vehicules',$vehicules)
                ->with('nbRdv',$this->nombreRdv());
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
                ->selectRaw('accepted,commentaire,name,immatriculation,rendez_vous.date as daty,rendez_vous.id as id,heure,vehicules.id as ide,rendez_vous.created_at,entreprise')
                ->where('accepted',0)
                ->where('finished','!=',1)
                ->orderBy('rendez_vous.created_at','desc')
                ->get();
                $rendezVousNb = DB::table('rendez_vous')
                ->join('vehicules','vehicules.id','rendez_vous.vehicule_id')
                ->join('users','users.id','vehicules.conducteur_id')
                ->selectRaw('accepted,count(rendez_vous.id) as nb')
                ->groupBy('accepted')
                ->where('accepted',0)
                ->get();
                 $rendezVousAcc = DB::table('rendez_vous')
                 ->join('vehicules','vehicules.id','rendez_vous.vehicule_id')
                ->join('users','users.id','vehicules.conducteur_id')
                ->selectRaw('accepted,commentaire,name,immatriculation,rendez_vous.date as daty,rendez_vous.id as id,heure,vehicules.id as ide,finished,rendez_vous.created_at,entreprise')
                ->orderBy('rendez_vous.created_at','desc')
                ->where('accepted',2)
                ->where('finished','!=',1)
                ->get();
                 $rendezVousRef = DB::table('rendez_vous')
                ->join('vehicules','vehicules.id','rendez_vous.vehicule_id')
                ->join('users','users.id','vehicules.conducteur_id')
                ->selectRaw('accepted,commentaire,name,immatriculation,rendez_vous.date as daty,rendez_vous.id as id,heure,raison,vehicules.id as ide,rendez_vous.created_at,entreprise')
                ->orderBy('rendez_vous.created_at','desc')
                ->where('accepted',1)
                ->where('finished',0)
                ->get();
                return view('rendezVous.rendezVous')
                ->with('rendezVous',$rendezVous)
                ->with('rendezVousRef',$rendezVousRef)
                ->with('rendezVousAcc',$rendezVousAcc)
                ->with('rdvs',$rdvs)
                ->with('rdvdetails',$rdvdetails)
                ->with('datebloquees',$datebloquees)
                ->with('rendezVousNb',$rendezVousNb)
                ->with('nbRdv',$this->nombreRdv());
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
    		if($lerdv->vehicule_id==$req->vehicule and $lerdv->date==$req->date and $lerdv->accepted!=1)
    		{
    		$notif=array(
    		'message'=>' Cette véhicule a déjà un rendez_vous ce jour là',
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
        $events = Event::get();
        $rendezVous = DB::table('rendez_vous')
                ->join('vehicules','vehicules.id','rendez_vous.vehicule_id')
                ->join('users','users.id','vehicules.conducteur_id')
                ->where('rendez_vous.id',$rdv->id)
                ->orderBy('rendez_vous.created_at','desc')
                ->get();
        $event = new Event;

        $event->name = $rendezVous[0]->immatriculation.' ('.$rendezVous[0]->entreprise.')';
        $event->startDateTime = new Carbon(date('Y-m-d',strtotime($rdv->date)).date('H:i:s',strtotime($rdv->heure)));
        $event->endDateTime =new Carbon(date('Y-m-d',strtotime($rdv->date)).date('H:i:s',strtotime($rdv->heure)));
        $event->description=$rdv->commentaire;
        $calendarEvent=$event->save();
        $rdv->calendarId=$calendarEvent->id;
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
        if($rdv->calendarId!=null)
        {
            $event=Event::find($rdv->calendarId);
            $event->delete();
        }
        $rdv->calendarId=null;
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
            ->selectRaw('users.id as id,immatriculation,name,rendez_vous.date as daty,commentaire,accepted,finished,heure,raison,vehicules.id as idV,rendez_vous.created_at')
            ->orderBy('rendez_vous.date','desc')
            ->where('users.entreprise',auth()->user()->entreprise)
            ->where('finished','!=',1)
            ->get();
            return view('rendezVous.liste')->with('rendezVous',$rendezVous)->with('nbRdv',$this->nombreRdv());
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
    return view('rendezVous.calendar')->with('rdvs',$rendez_Vous)->with('rdvdetails',$rdvdetails)->with('nbRdv',$this->nombreRdv());
    }
    public function maintenances()
    {
        if(auth()->user()->role=='superadmin' or auth()->user()->role=='operateur')
        {
        $rendez_Vous=DB::table('rendez_vous')
                ->join('vehicules','vehicules.id','rendez_vous.vehicule_id')
                ->join('users','users.id','vehicules.conducteur_id')
                ->selectRaw('email,phone,entreprise,immatriculation,model,marque,rendez_vous.*,vehicules.active,rendez_vous.id')
                ->where('date',date('y-m-d'))
                ->where('vehicules.active',0)
                ->where('accepted',2)
                ->where('finished','=',0)
                ->orderBy('heure','asc')
                ->get();
        
       
        return view('maintenances.rendezVousToday')
        ->with('rdvs',$rendez_Vous)
        ->with('nbRdv',$this->nombreRdv());
        }
    }
    public function maintenanceRapide()
    {
        if(auth()->user()->role=='superadmin' or auth()->user()->role=='operateur')
        {
        $rdvRapides=DB::table('vehicules')
                ->join('users','users.id','vehicules.conducteur_id')
                ->selectRaw('immatriculation,marque,model,entreprise,email,phone,vehicules.id as id,vehicules.active')
                ->where('vehicules.active',0)
                ->get();
       return view('maintenances.maintenanceRapide')->with('rdvRapides',$rdvRapides)->with('nbRdv',$this->nombreRdv());
        } 
    }
    public function historique()
    {
        if(auth()->user()->role=='superadmin' or auth()->user()->role=='operateur')
        {
            $References=DB::table('stocks')
                            ->join('references','references.id','stocks.reference_id')
                            ->selectRaw('stocks.id,hgInit,hgFinal,kInit,kFinal,reference,prix,gazole,cout,indication,consommation,id_vehicule,reference_id,pose,depose,quantite')
                            ->get();
            $entreprises=User::where('role','responsable')->get();
         $maintenanceEff=DB::table('maintenances')
                ->join('rendez_vous','rendez_vous.id','maintenances.rdv_id')
                ->join('vehicules','vehicules.id','rendez_vous.vehicule_id')
                ->join('users','users.id','vehicules.conducteur_id')
                ->selectRaw('immatriculation,marque,model,phone,email,entreprise,operations,debut,fin,maintenances.id as id,facture,maintenances.observations,vehicules.id as ide,rendez_vous.date,refPneus,imageIn1,imageIn2,hGommeIn,etatPneu')
                ->where('finished','!=',0)
                ->get();
        return view('maintenances.historique')->with('maintenanceEffs',$maintenanceEff)->with('entreprises',$entreprises)->with('References',$References)->with('nbRdv',$this->nombreRdv());
        }
    }
    public function hvehicule($id)
    {
            
       if(auth()->user()->role=='superadmin' or auth()->user()->role=='operateur')
        {
           $References=DB::table('stocks')
                            ->join('references','references.id','stocks.reference_id')
                            ->selectRaw('stocks.id,hgInit,hgFinal,kInit,kFinal,reference,prix,gazole,cout,indication,consommation,id_vehicule,reference_id,pose,depose,quantite')
                            ->get();
            $entreprises=User::where('role','responsable')->get();
         $maintenanceEff=DB::table('maintenances')
                ->join('rendez_vous','rendez_vous.id','maintenances.rdv_id')
                ->join('vehicules','vehicules.id','rendez_vous.vehicule_id')
                ->join('users','users.id','vehicules.conducteur_id')
                ->selectRaw('immatriculation,marque,model,phone,email,entreprise,operations,debut,fin,maintenances.id as id,facture,maintenances.observations,vehicules.id as ide,rendez_vous.date,refPneus,imageIn1,imageIn2,hGommeIn,etatPneu')
                ->where('finished','!=',0)
                ->where('vehicules.id',$id)
                ->get();
        return view('maintenances.historique')->with('maintenanceEffs',$maintenanceEff)->with('entreprises',$entreprises)->with('References',$References)->with('nbRdv',$this->nombreRdv());
        }
        
    }
}
