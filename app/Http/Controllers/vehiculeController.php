<?php
 
namespace App\Http\Controllers;
use App\Model\Vehicule;
use Illuminate\Http\Request;
use App\Model\RendezVous;
use App\Model\Reference;
use App\Model\Maintenance;
use App\Model\Statistique;
use App\User;
use App\Model\Stock;
use DB;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Validator;

class vehiculeController extends Controller
{
    public function delete($id)
    {
        $Vehicule=Vehicule::find($id);
        $Vehicule->active=1;
        $Vehicule->save();
        $notif=array(
            'message'=>'Suppression réussi',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notif);
    }
    public function rechercher(Request $req)
    {
        $entreprises=User::where('role','responsable')->get();
        $References=DB::table('references')
        ->join('stocks','stocks.reference_id','references.id')
        ->selectRaw('stocks.id,reference')
        ->get();
        if(auth()->user()->role=='superadmin')
        {
            $vehicules=DB::table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('model,marque,immatriculation,entreprise,hGomme,refPneus,etatPneu,kilometrage,derniereMaintenance,vehicules.id as id,alert,name,phone,email,dateC,t1,t2,serrage,type,vehicules.active,nomH,emailH,phoneH')
            ->where('immatriculation',$req->immatriculation)
            ->where('vehicules.active','!=',1)
            ->get();
            $RendezVous=RendezVous::All();
            $stocks=Reference::All();
            return view('vehicules.liste') 
                ->with('vehicules',$vehicules)
                ->with('RendezVous',$RendezVous)
                ->with('stocks',$stocks)
                ->with('references',$References)
                ->with('entreprises',$entreprises);;
        }
        else
        {
            $vehicules=DB::table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('model,marque,immatriculation,entreprise,hGomme,refPneus,etatPneu,kilometrage,derniereMaintenance,vehicules.id as id,alert,name,phone,email,dateC,serrage,type,t1,t2,vehicules.active,nomH,emailH,phoneH')
            ->where('entreprise',auth()->user()->entreprise)
            ->where('immatriculation',$req->immatriculation)
            ->where('vehicules.active','!=',1)
            ->get();
            $RendezVous=RendezVous::All();
            $stocks=Reference::All();
            return view('vehicules.liste')->with('vehicules',$vehicules)->with('RendezVous',$RendezVous)->with('stocks',$stocks)->with('references',$References)
            ->with('entreprises',$entreprises);
        }
    }
    public function flotte($id)
    {
         $vehiculesInscrit=DB::Table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('count(vehicules.id) as nombre,entreprise,vehicules.active')
            ->where('users.id',$id)
            ->where('vehicules.active','!=',1)
            ->groupByRaw('entreprise,vehicules.active')
            ->get();
        $vehiculesM=DB::Table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->join('rendez_vous','rendez_vous.vehicule_id','vehicules.id')
            ->selectRaw('count(vehicules.id) as nombre,entreprise,finished,vehicules.active')
            ->where('users.id',$id)
            ->where('finished',1)
            ->where('vehicules.active','!=',1)
            ->groupByRaw('entreprise,finished,vehicules.active')
            ->get();
        $pRdvs=DB::Table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->join('rendez_vous','rendez_vous.vehicule_id','vehicules.id')
            ->selectRaw('date,entreprise,immatriculation,accepted,finished,marque,model,heure,vehicules.active')
            ->orderByRaw('date','desc')
            ->where('users.id',$id)
            ->where('accepted',2)
            ->where('vehicules.active','!=',1)
            ->where('finished',0)
            ->where('date','>=',date('Y-m-d'))
            ->get();
        return view('vehicules.flotte')
            ->with('vehiculesM',$vehiculesM)
            ->with('vehiculesInscrit',$vehiculesInscrit)
            ->with('pRdvs',$pRdvs);
    }
    public function index()
    {
        $entreprises=User::where('role','responsable')->get();
        $refPneus=Reference::All();
        $References=DB::table('references')
        ->join('stocks','stocks.reference_id','references.id')
        ->selectRaw('stocks.id,reference,reference_id')
        ->get();
        if(auth()->user()->role=='superadmin')
        {
        	$vehicules=DB::table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('model,marque,immatriculation,entreprise,hGomme,refPneus,etatPneu,kilometrage,derniereMaintenance,vehicules.id as id,alert,name,phone,email,dateC,t1,t2,serrage,type,vehicules.active,nomH,emailH,phoneH,observations,imageV,factureV,control,information,serrage,pneu,imageV2,stationnement,permutation')
            ->where('vehicules.active','!=',1)
            ->get();
            $RendezVous=RendezVous::All();
            $stocks=Reference::All();
        	return view('vehicules.liste') 
                ->with('vehicules',$vehicules)
                ->with('RendezVous',$RendezVous)
                ->with('stocks',$stocks)
                ->with('references',$References)
                ->with('entreprises',$entreprises)
                ->with('refPneus',$refPneus);
        }
        else
        {
            $refPneus=Reference::All();
            $vehicules=DB::table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('model,marque,immatriculation,entreprise,hGomme,refPneus,etatPneu,kilometrage,derniereMaintenance,vehicules.id as id,alert,name,phone,email,dateC,serrage,type,t1,t2,vehicules.active,nomH,emailH,phoneH,observations,imageV,factureV,control,information,serrage,pneu,imageV2,stationnement,permutation')
            ->where('entreprise',auth()->user()->entreprise)
            ->where('vehicules.active','!=',1)
            ->get();
            $RendezVous=RendezVous::All();
            $stocks=Reference::All();
            return view('vehicules.liste')->with('vehicules',$vehicules)->with('RendezVous',$RendezVous)->with('stocks',$stocks)->with('references',$References)
            ->with('entreprises',$entreprises)->with('refPneus',$refPneus);
        }
        // return '<iframe src="https://calendar.google.com/calendar/embed?src=fr.mg%23holiday%40group.v.calendar.google.com&ctz=Africa%2FNairobi" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>';
    }
    public function create()
    {
        $stocks=DB::table('references')
        ->join('stocks','stocks.reference_id','references.id')
        ->selectRaw('stocks.id,reference')
        ->get();
        $references=Reference::All();
        $entreprises=User::where('role','responsable')->get();
    	return view('vehicules.ajouter')->with('entreprises',$entreprises)->with('references',$references)->with('stocks',$stocks);
    }
    public function modifRapide(Request $req,$id)
    {
        $etatPneu=array();
        $etatPneuI=array();
        $hg=array();
        $ref=array();
        $tref=array();
        for($i=0;$i<4;$i++)
        {
                $etatPneu[$i]=$req->pneuI[$i];
                $etatPneuI[$i]=$req->pneuI[$i];
                $hg[$i]=$req->hg[$i];
                $ref[$i]=$req->ref[$i];
            if($req->pneuI[$i]==null or $req->hg[$i]==null or $req->ref[$i]==null)
            {
                $notif=array(
                    'message'=>'Veuillez remplir tous les champs',
                    'alert-type'=>'error'
                );
                return redirect()->back()->with($notif);
            }
        }
            if($req->pne==6)
            {
                for($i=0;$i<2;$i++)
                {
                    array_push($etatPneu,$req->pneuI2[$i]);
                    array_push($hg,$req->hg2[$i]);
                    array_push($ref,$req->ref2[$i]);
                    array_push($etatPneuI,$req->pneuI2[$i]);
                   if($req->pneuI2[$i]==null or $req->hg2[$i]==null or $req->ref2[$i]==null)
                    {
                    $notif=array(
                        'message'=>'Veuillez remplir tous les champs',
                        'alert-type'=>'error'
                    );
                    return redirect()->back()->with($notif);
                    } 
                }
            }
        
        // $validator = Validator::make($req->all(), [
        //     'immatriculation' => 'required',
        //     'marque' => 'required',
        //     'model' => 'required',
        //     'datec' => 'required',
        //     'dmaintenance' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     $notif=array(
        //     'message'=>'Veuillez remplir tous les champs zavatra hafa',
        //     'alert-type'=>'error'
        // );
        // return redirect()->back()->with($notif);
        // }
        $mail=User::find($req->conducteur);
         $vehicule=Vehicule::find($id);
        $vehicule->conducteur_id=$req->conducteur;
        $vehicule->immatriculation=$req->immatriculation;
        $vehicule->marque=$req->marque;
        $vehicule->model=$req->model;
        // $vehicule->Pneu=$req->pne;
        $vehicule->dateC=$req->datec;
        $vehicule->serrage=$req->serrage;
        $vehicule->type=$req->type;
        $vehicule->nomH=$req->nomH;
        $vehicule->emailH=$req->emailH;
        // $vehicule->information=$req->information;
        $vehicule->phoneH=$req->phoneH;
        $vehicule->active=0;
        $vehicule->derniereMaintenance=$req->dmaintenance;
            $vehicule->etatPneu=serialize($etatPneu);
            $vehicule->etatPneuInit=serialize($etatPneuI);
            $t=$hg;
            array_push($t,$req->kilometrage,date("Y/m/d"));
            $vehicule->t1=serialize($t);
            $vehicule->t2=null;
            for($in=0;$in<count($ref);$in++)
            {
                if($ref[$in]!=null)
                {
                $st=new Stock();
                $st->reference_id=$ref[$in];
                $st->quantite=0;
                $st->date=date('Y_m-d');
                $st->save();
                $tref[$in]=$st->id;
                }

            }
            $vehicule->refPneus=serialize($tref);
           
         $vehicule->control=date("Y/m/d");
        $vehicule->hGomme=serialize($hg);
        $vehicule->kilometrage=$req->kilometrage;
          $vehicule->dateC=$req->datec;
        $vehicule->dernierePerte=date("Y/m/d");
        $vehicule->save();
        /*$details = [
            'title' => 'Le véhicule '.$req->immatriculation.' a été inscris sur votre flotte',
            'body' => 'L\'equipe de MMP'
        ];

        \Mail::to($mail->email)->send(new SendMail($details));*/
        $notif=array(
            'message'=>'Modification réussi',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notif);
    }
    public function store(Request $req)
    {
        $etatPneu=array();
        $etatPneuI=array();
        $hg=array();
        $ref=array();
        $tref=array();
        for($i=0;$i<4;$i++)
        {
                $etatPneu[$i]=$req->pneuI[$i];
                $etatPneuI[$i]=$req->pneuI[$i];
                $hg[$i]=$req->hg[$i];
                $ref[$i]=$req->ref[$i];
            if($req->pneuI[$i]==null or $req->hg[$i]==null or $req->ref[$i]==null)
            {
                $notif=array(
                    'message'=>'Veuillez remplir tous les champs',
                    'alert-type'=>'error'
                );
                return redirect()->back()->with($notif);
            }
        }
            if($req->pne==6)
            {
                for($i=0;$i<2;$i++)
                {
                    array_push($etatPneu,$req->pneuI2[$i]);
                    array_push($hg,$req->hg2[$i]);
                    array_push($ref,$req->ref2[$i]);
                    array_push($etatPneuI,$req->pneuI2[$i]);
                   if($req->pneuI2[$i]==null or $req->hg2[$i]==null or $req->ref2[$i]==null)
                    {
                    $notif=array(
                        'message'=>'Veuillez remplir tous les champs',
                        'alert-type'=>'error'
                    );
                    return redirect()->back()->with($notif);
                    } 
                }
            }
        
        $validator = Validator::make($req->all(), [
            'immatriculation' => 'required',
            'marque' => 'required',
            'model' => 'required',
            'datec' => 'required',
            'dmaintenance' => 'required',
        ]);

        if ($validator->fails()) {
            $notif=array(
            'message'=>'Veuillez remplir tous les champs',
            'alert-type'=>'error'
        );
        return redirect()->back()->with($notif);
        }
        $mail=User::find($req->conducteur);
    	$vehicule=new Vehicule();
        $vehicule->conducteur_id=$req->conducteur;
        $vehicule->permutation=10000;
        $vehicule->dpermutation=date('Y-m-d');
    	$vehicule->immatriculation=$req->immatriculation;
    	$vehicule->marque=$req->marque;
    	$vehicule->model=$req->model;
    	$vehicule->Pneu=$req->pne;
        $vehicule->dateC=$req->datec;
        $vehicule->serrage=$req->serrage;
        $vehicule->type=$req->type;
        $vehicule->nomH=$req->nomH;
        $vehicule->emailH=$req->emailH;
        $vehicule->information=$req->information;
        $vehicule->phoneH=$req->phoneH;
        $vehicule->active=0;
        $vehicule->stationnement=$req->stationnement;
    	$vehicule->derniereMaintenance=$req->dmaintenance;
            $vehicule->etatPneu=serialize($etatPneu);
            $vehicule->etatPneuInit=serialize($etatPneuI);
            $t=$hg;
            array_push($t,$req->kilometrage,date("Y/m/d"));
            $vehicule->t1=serialize($t);
            for($in=0;$in<count($ref);$in++)
            {
                if($ref[$in]!=null)
                {
                $st=new Stock();
                $st->reference_id=$ref[$in];
                $st->quantite=0;
                $st->date=date('Y_m-d');
                $st->save();
                $tref[$in]=$st->id;
                }

            }
            $vehicule->refPneus=serialize($tref);
           
         $vehicule->control=date("Y/m/d");
        $vehicule->hGomme=serialize($hg);
        $vehicule->kilometrage=$req->kilometrage;
          $vehicule->dateC=$req->datec;
        $vehicule->dernierePerte=date("Y/m/d");
        $vehicule->save();
        /*$details = [
            'title' => 'Le véhicule '.$req->immatriculation.' a été inscris sur votre flotte',
            'body' => 'L\'equipe de MMP'
        ];

        \Mail::to($mail->email)->send(new SendMail($details));*/
    	$notif=array(
    		'message'=>'Ajout réussi',
    		'alert-type'=>'success'
    	);
    	return redirect()->back()->with($notif);
    }
    /*public function show($id)
    {
        if($id==auth()->user()->id)
        {

        $vehicules=Vehicule::where('conducteur_id',$id)->get();
        $RendezVous=RendezVous::All();
        return view('vehicules.liste')->with('vehicules',$vehicules)->with('RendezVous',$RendezVous);
        }
    }*/
    public function update($id,Request $req)
    {
        $tab=$req->place;
        
        if(isset($req->placeS))
        {
        array_push($tab,$req->placeS[0],$req->placeS[1]);
        }
    	$vehicule=Vehicule::find($id);
            /*if($req->pneu)
            {
                if($vehicule->etatPneu)
                {
                    for($i=0;$i<count(unserialize($vehicule->etatPneu));$i++)
                    {
                        if (unserialize($vehicule->etatPneu)[$i]!=$req->pneu[$i]) {
                            $date[$i]=date("Y/m/d");
                        }
                        else
                        {
                            $date[$i]=unserialize($vehicule->control)[$i];
                        }
                    }
                }
                else
                {
                    for($i=0;$i<count($req->pneu);$i++)
                    {
                        $date[$i]=date("Y/m/d");
                    }
                }
        $vehicule->control=serialize($date);
    	$vehicule->etatPneu=serialize($req->pneu);
        $vehicule->etatPneuInit=serialize($req->pneu);
            }*/
        if($tab)
        {   
             for($i=0;$i<count($tab);$i++)
             {
                if($tab[$i]=='undefined')
                {
                    $notif=array(
                        'message'=>'Veuillez refaire la permutation',
                        'alert-type'=>'error'
                    );
                    return redirect()->back()->with($notif);
                }
             }
            $vehicule->permutation=10000;
            for($i=0;$i<count(unserialize($vehicule->etatPneu));$i++)
            {
                $a=$tab[$i];
                        // $etatPneu[$i]=unserialize($vehicule->etatPneu)[$a];
                        // $etatPneuInit[$i]=unserialize($vehicule->etatPneuInit)[$a];
                        $hGomme[$i]=unserialize($vehicule->hGomme)[$a];
                        $ref[$i]=unserialize($vehicule->refPneus)[$a];
                        $t1[$i]=unserialize($vehicule->hGomme)[$a];
            }
            // $vehicule->etatPneu=serialize($etatPneu);
            array_push($t1,$vehicule->kilometrage,date("Y/m/d"));
            $vehicule->t1=serialize($t1);
            $vehicule->t2=null;
            // $vehicule->etatPneuInit=serialize($etatPneuInit);
            $vehicule->hGomme=serialize($hGomme);
            $vehicule->refPneus=serialize($ref);
            $maintenanceUpdates=DB::table('maintenances')
                ->join('rendez_vous','rendez_vous.id','maintenances.rdv_id')
                ->selectRaw('maintenances.id as ide')
                ->where('vehicule_id',$id)
                ->where('accepted',2)
                ->where('finished','!=',2)
                ->get();
        $maintenanceDef=Maintenance::find($maintenanceUpdates[0]->ide);
        $maintenanceDef->operations=$maintenanceDef->operations.' permutation';
        $maintenanceDef->save();
        }
        else
        {
        if($req->pneu)
        {
        for($i=0;$i<count($req->pneu);$i++)
             {
                if($req->pneu[$i]==null or $req->pneuI[$i]==null or $req->ref[$i]==null or $req->hg[$i]==null or $req->kilometrage==null)
                {
                    $notif=array(
                        'message'=>'Veuillez remplir tous les champs',
                        'alert-type'=>'error'
                    );
                    return redirect()->back()->with($notif);
                }
             }
            $vehicule->etatPneu=serialize($req->pneu);
            $vehicule->etatPneuInit=serialize($req->pneuI);
            $t=$req->hg;
            array_push($t,$req->kilometrage,date("Y/m/d"));
            $vehicule->t1=serialize($t);
            for($in=0;$in<count($req->ref);$in++)
            {
                $st=new Stock();
                $st->reference_id=$req->ref[$in];
                $st->quantite=0;
                $st->date=date('Y-m-d');
                $st->save();
                $tref[$in]=$st->id;
            }
            $vehicule->refPneus=serialize($tref);
        }
        else
        {
            $refused=0;
            for($i=0;$i<count($req->hg);$i++)
             {
                if($req->hg[$i]==null or $req->kilometrage==null)
                {
                    $notif=array(
                        'message'=>'Veuillez remplir tous les champs',
                        'alert-type'=>'error'
                    );
                    return redirect()->back()->with($notif);
                }
             }
            for($i=0;$i<count($req->hg);$i++)
            {
                $stock=Stock::find(unserialize($vehicule->refPneus)[$i]);
                if($stock->hgFinal==null and $stock->kFinal==null)
                {
                    $stock->hgFinal=$req->hg[$i];
                    $stock->kFinal=$req->kilometrage;
                    $stock->save();
                }
                $t1[$i]=unserialize($vehicule->hGomme)[$i];
                if($req->hg[$i]>unserialize($vehicule->hGomme)[$i] or $req->kilometrage<$vehicule->kilometrage)
                {
                    $refused=1;
                }
            }
            if($refused==0)
            {
                $t=$req->hg;
                    array_push($t1,$vehicule->kilometrage,$vehicule->control);
                    $vehicule->t1=serialize($t1);
                array_push($t,$req->kilometrage,date("Y/m/d"));
                $vehicule->t2=serialize($t);
            }
        }
        $vehicule->control=date("Y/m/d");
        $vehicule->hGomme=serialize($req->hg);
        $permutation=$req->kilometrage-$vehicule->kilometrage;
        if($vehicule->permutation-$permutation<=0)
        {
            $vehicule->permutation=0;
        }
        else
        {
            $vehicule->permutation=$vehicule->permutation-$permutation;
        }
    	$vehicule->kilometrage=$req->kilometrage;
        $vehicule->dernierePerte=date("Y/m/d");
        }
    	$vehicule->save();
    	$notif=array(
    		'message'=>'mise à jour réussi',
    		'alert-type'=>'success'
    	);
    	return redirect()->back()->with($notif);
    }
    public function reset($id)
    {
        $vehicule=Vehicule::find($id);
        for($i=0;$i<count(unserialize($vehicule->etatPneuInit));$i++)
        {
            $count[$i]=unserialize($vehicule->etatPneuInit)[$i];
        }
        $vehicule->etatPneu=serialize($count);
        $vehicule->derniereMaintenance=Date('y/m/d');
        $vehicule->save();
         $maintenanceUpdates=DB::table('maintenances')
                ->join('rendez_vous','rendez_vous.id','maintenances.rdv_id')
                ->selectRaw('maintenances.id as ide')
                ->where('vehicule_id',$id)
                ->where('accepted',2)
                ->where('finished','!=',2)
                ->get();
        $maintenanceDef=Maintenance::find($maintenanceUpdates[0]->ide);
        $maintenanceDef->operations=$maintenanceDef->operations.' pressions';
        $maintenanceDef->save();
    $notif=array(
            'message'=>'Reinitialisation réussi',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notif);
    }
    public function entreprises()
    {
        if(auth()->user()->role=='superadmin')
        {
            $entreprises=DB::table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('count(vehicules.id) as nombre,entreprise,name,users.id')
            ->groupByRaw('entreprise,name,users.id')
            ->get();
            $vehicules=DB::table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->get();
            return view('vehicules.entreprises')->with('entreprises',$entreprises)->with('vehicules',$vehicules);
        }
    }
    public function begin($id)
    {
        $vehicule=Vehicule::find($id);
        $RendezVous=RendezVous::
        where('vehicule_id',$id)
        ->where('accepted',2)
        ->where('finished','!=',2)
        ->get();
        if(!isset($RendezVous[0]))
        {
            $RendezVous=new RendezVous();
            $RendezVous->date=date('Y-m-d');
            $RendezVous->heure=date('H:i:s');
            $RendezVous->vehicule_id=$id;
            $RendezVous->accepted=2;
            $RendezVous->finished=1;
            $RendezVous->save();
            $rdvId=$RendezVous->id;
        }
        else
        {
            foreach($RendezVous as $rdv)
            {
                $rdv->finished=1;
                $rdv->save();
                $rdvId=$rdv->id;
            }
        }
        $maintenance=DB::table('maintenances')
                ->join('rendez_vous','rendez_vous.id','maintenances.rdv_id')
                ->where('vehicule_id',$id)
                ->where('accepted',2)
                ->where('finished','!=',2)
                ->get();
        if(!isset($maintenance[0]))
        {
            $maintenanceD=new Maintenance();
            $maintenanceD->debut=date('Y-m-d H:i:s');
            $maintenanceD->rdv_id=$rdvId;
            $maintenanceD->save();
        }
        $maintenance=DB::table('maintenances')
                ->join('rendez_vous','rendez_vous.id','maintenances.rdv_id')
                ->where('vehicule_id',$id)
                ->where('accepted',2)
                ->where('finished','!=',2)
                ->get();
        $stocks=DB::table('references')
        ->join('stocks','stocks.reference_id','references.id')
        ->selectRaw('stocks.id,reference')
        ->get();
        $references=Reference::All();
        return view('maintenances.interface')
        ->with('vehicule',$vehicule)
        ->with('stocks',$stocks)
        ->with('maintenance',$maintenance)
        ->with('references',$references);
    }
    public function alert(Request $req)
    {
        $vehiculeUpdate=Vehicule::find($req->id);
        $vehiculeUpdate->alert=1;
        $vehiculeUpdate->dateAlert=date("Y/m/d");
        $vehiculeUpdate->save();
        $responsable=User::find($vehiculeUpdate->conducteur_id);
        if($req->texte=='')
        {
            $details = [
                'title' => 'Votre véhicule immatriculée '.$vehiculeUpdate->immatriculation
                .' '.$vehiculeUpdate->model.'('.$vehiculeUpdate->marque.') a besoin d\'une maintenance ou d\'un control chez MMP06. Merci de prendre un Rendez-vous.',
                'body' => "L'équipe de MMP"
            ];
        }
        else
        {
            $details = [
                'title' => $req->texte,
                'body' => "L'équipe de MMP"
            ];
        }
        \Mail::to($responsable->email)->send(new SendMail($details));
         $notif=array(
            'message'=>'Véhicule alertée',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notif);
    }
    public function changement(Request $req)
    {
        $stat=new Statistique();
        $stat->nombre=1;
        $stat->vehicules_id=$req->id;
        $stat->reference_id=$req->ref;
        $stat->save();
        $vehicule=Vehicule::find($req->id);
        $entreprise=User::find($vehicule->conducteur_id);
        $vehicule->control=date("Y/m/d");
        $stock=new Stock();
        $stock->reference_id=$req->ref;
        $stock->quantite=-1;
        $stock->date=date('d/m/y H:i:s');
        $stock->hgInit=$req->hg;
        $stock->kInit=$req->kil;
        $stock->source=$vehicule->immatriculation.' ('.$entreprise->entreprise.')';
        $stock->save();
        for($i=0;$i<count(unserialize($vehicule->etatPneu));$i++)
        {
            if($i==$req->place) 
            {
                $hGomme[$i]=$req->hg;
                $ref[$i]=$stock->id;
                $etatPneu[$i]=$req->pression;
                $etatPneuInit[$i]=$req->pression;
            }
            else
            {
                $hGomme[$i]=unserialize($vehicule->hGomme)[$i];
                $ref[$i]=unserialize($vehicule->refPneus)[$i];
                $etatPneu[$i]=unserialize($vehicule->etatPneu)[$i];
                $etatPneuInit[$i]=unserialize($vehicule->etatPneuInit)[$i];
            }
        }
        $vehicule->etatPneuInit=serialize($etatPneuInit);
        $vehicule->etatPneu=serialize($etatPneu);
        $vehicule->refPneus=serialize($ref);
        $vehicule->hGomme=serialize($hGomme);
        $vehicule->save();
        $notif=array(
            'message'=>'changement réussi',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notif);
        
    }

}
