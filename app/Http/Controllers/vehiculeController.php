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
use Carbon\Carbon;

use App\Mail\SendMail;
use Illuminate\Support\Facades\Validator;
use App\Model\Alerte;
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
            ->selectRaw('count(vehicules.id) as nombre,entreprise,finished')
            ->where('users.id',$id)
            ->where('vehicules.active','!=',1)
            ->where('rendez_vous.date',date('Y-m-d'))
            ->where('finished','!=',0)
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
            ->with('pRdvs',$pRdvs)
            ->with('nbRdv',$this->nombreRdv());
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
    public function index()
    {
        
        $entreprises=User::where('role','responsable')->get();
        $refPneus=Reference::All();
        $References=DB::table('references')
        ->join('stocks','stocks.reference_id','references.id')
        ->selectRaw('stocks.id,reference,reference_id,quantite')
        ->get();
        if(auth()->user()->role=='superadmin')
        {
        	$vehicules=DB::table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('model,marque,immatriculation,entreprise,hGomme,refPneus,etatPneu,kilometrage,derniereMaintenance,vehicules.id as id,alert,name,phone,email,dateC,t1,t2,serrage,type,vehicules.active,nomH,emailH,phoneH,observations,imageV,factureV,control,information,serrage,pneu,imageV2,stationnement,permutation,dpermutation,dpression,carburant,limitePression,limiteP,limiteHg')
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
                ->with('refPneus',$refPneus)
                ->with('nbRdv',$this->nombreRdv());
        }
        else
        {
            $refPneus=Reference::All();
            $vehicules=DB::table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('model,marque,immatriculation,entreprise,hGomme,refPneus,etatPneu,kilometrage,derniereMaintenance,vehicules.id as id,alert,name,phone,email,dateC,serrage,type,t1,t2,vehicules.active,nomH,emailH,phoneH,observations,imageV,factureV,control,information,serrage,pneu,imageV2,stationnement,permutation,dpermutation,dpression,carburant,limitePression,limiteP,limiteHg')
            ->where('entreprise',auth()->user()->entreprise)
            ->where('vehicules.active','!=',1)
            ->get();
            $RendezVous=RendezVous::All();
            $stocks=Reference::All();
            return view('vehicules.liste')->with('vehicules',$vehicules)->with('RendezVous',$RendezVous)->with('stocks',$stocks)->with('references',$References)
            ->with('entreprises',$entreprises)->with('refPneus',$refPneus)
            ->with('nbRdv',$this->nombreRdv());
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
        $entreprises=User::where('role','responsable')->where('active',0)->get();
    	return view('vehicules.ajouter')->with('entreprises',$entreprises)->with('references',$references)->with('stocks',$stocks)
        ->with('nbRdv',$this->nombreRdv());
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
        $vehicule->carburant=$req->carburant;
        $vehicule->emailH=$req->emailH;
        $vehicule->dpression=$req->dmaintenance;
        $vehicule->stationnement=$req->stationnement;
         $vehicule->information=$req->information;
        $vehicule->phoneH=$req->phoneH;
        $vehicule->active=0;
        $vehicule->dpermutation=$req->dmaintenance;
        $vehicule->derniereMaintenance=$req->dmaintenance;
            $vehicule->etatPneu=serialize($etatPneu);
            $vehicule->etatPneuInit=serialize($etatPneuI);
            $t=$hg;
            array_push($t,$req->kilometrage,$req->dmaintenance);
           
            // if($vehicule->t2!=null)
            // {
            //     $vehicule->t2=serialize($t);

            // }
            // else
            // {
            //     $vehicule->t2=serialize($t);
            // }
            for($in=0;$in<count($ref);$in++)
            {
                if($ref[$in]!=null)
                {
                    $stockCon=Stock::find(unserialize($vehicule->refPneus)[$in]);
                    if($stockCon->reference_id!=$ref[$in])
                    {
                        $oldst=Stock::find(unserialize($vehicule->refPneus)[$in]);
                        $oldst->delete();
                        $st=new Stock();
                        $st->reference_id=$ref[$in];
                        $st->quantite=0;
                        $st->hgInit=$hg[$in];
                        $st->kInit=$req->kilometrage;
                        $st->id_vehicule=$vehicule->id;
                        $st->source=$vehicule->immatriculation.' ('.$mail->entreprise.')';
                        $st->date=date('Y-m-d');
                        $st->pose=date('Y-m-d');
                        $st->save();
                        $tref[$in]=$st->id;
                    }
                    else
                    {
                        $tref[$in]=unserialize($vehicule->refPneus)[$in];
                    }
                }

            }
            $vehicule->refPneus=serialize($tref);
            $vehicule->refPneuInit=serialize($tref);
           $vehicule->cConstant=$req->dmaintenance;
         $vehicule->control=$req->dmaintenance;
        $vehicule->hGomme=serialize($hg);
        $vehicule->kilometrage=$req->kilometrage;
        $vehicule->limiteHg=$req->limiteHg;
        $vehicule->permutation=$vehicule->permutation+$req->limiteP-$vehicule->limiteP;
        $vehicule->limiteP=$req->limiteP;
        $vehicule->limitePression=$req->limitePression;
          $vehicule->dateC=$req->datec;
        $vehicule->dernierePerte=$req->dmaintenance;

        $vehicule->dateAlert='2020-01-01';
        $vehicule->dateAlertP='2020-01-01';
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
                    'message'=>'Veuillez remplir tous les champs 1',
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
                        'message'=>'Veuillez remplir tous les champs 2',
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
        $vehicule->permutation=$req->limiteP;
        $vehicule->dpermutation=$req->dmaintenance;
    	$vehicule->immatriculation=$req->immatriculation;
    	$vehicule->marque=$req->marque;
    	$vehicule->model=$req->model;
    	$vehicule->Pneu=$req->pne;
        $vehicule->dateC=$req->datec;
        $vehicule->serrage=$req->serrage;
        $vehicule->type=$req->type;
        $vehicule->nomH=$req->nomH;
        $vehicule->carburant=$req->carburant;
        $vehicule->emailH=$req->emailH;
        $vehicule->information=$req->information;
        $vehicule->phoneH=$req->phoneH;
        $vehicule->active=0;
        $vehicule->stationnement=$req->stationnement;
    	$vehicule->derniereMaintenance=$req->dmaintenance;
        $vehicule->dpression=$req->dmaintenance;
        $vehicule->limiteHg=$req->limiteHg;
        $vehicule->limiteP=$req->limiteP;
        $vehicule->limitePression=$req->limitePression;
            $vehicule->etatPneu=serialize($etatPneu);
            $vehicule->etatPneuInit=serialize($etatPneuI);
            $t=$hg;
            array_push($t,$req->kilometrage,$req->dmaintenance);
            $vehicule->t1=serialize($t);
            $vehicule->tConstant=serialize($t);
            $vehicule->save();
            $id=$vehicule->id;
            for($in=0;$in<count($ref);$in++)
            {
                if($ref[$in]!=null)
                {
                $st=new Stock();
                $st->reference_id=$ref[$in];
                $st->quantite=0;
                $st->hgInit=$hg[$in];
                $st->kInit=$req->kilometrage;
                $st->date=$req->dmaintenance;
                $st->id_vehicule=$id;
                $st->pose=$req->dmaintenance;
                $st->source=$vehicule->immatriculation.' ('.$mail->entreprise.')';
                $st->save();
                $tref[$in]=$st->id;
                }

            }
            $vehiculeUp=Vehicule::find($id);
            $vehiculeUp->refPneus=serialize($tref);
            $vehiculeUp->refPneuInit=serialize($tref);
           
         $vehiculeUp->control=$req->dmaintenance;
         $vehiculeUp->cConstant=$req->dmaintenance;
        $vehiculeUp->hGomme=serialize($hg);
        $vehiculeUp->dateAlert='2020-01-01';
        $vehiculeUp->dateAlertP='2020-01-01';
        $vehiculeUp->kilometrage=$req->kilometrage;
          $vehiculeUp->dateC=$req->datec;
        $vehiculeUp->dernierePerte=$req->dmaintenance;
        $vehiculeUp->save();
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
    public function show($id)
    {
        $entreprises=User::where('role','responsable')->get();
        $refPneus=Reference::All();
        $References=DB::table('references')
        ->join('stocks','stocks.reference_id','references.id')
        ->selectRaw('stocks.id,reference,reference_id,quantite')
        ->get();
        if(auth()->user()->role=='superadmin')
        {
            $vehicules=DB::table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('model,marque,immatriculation,entreprise,hGomme,refPneus,etatPneu,kilometrage,derniereMaintenance,vehicules.id as id,alert,name,phone,email,dateC,t1,t2,serrage,type,vehicules.active,nomH,emailH,phoneH,observations,imageV,factureV,control,information,serrage,pneu,imageV2,stationnement,permutation,dpermutation,dpression,carburant,limitePression,limiteP,limiteHg')
            ->where('vehicules.active','!=',1)
            ->where('vehicules.id',$id)
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
            ->selectRaw('model,marque,immatriculation,entreprise,hGomme,refPneus,etatPneu,kilometrage,derniereMaintenance,vehicules.id as id,alert,name,phone,email,dateC,serrage,type,t1,t2,vehicules.active,nomH,emailH,phoneH,observations,imageV,factureV,control,information,serrage,pneu,imageV2,stationnement,permutation,dpermutation,dpression,carburant,limitePression,limiteP,limiteHg')
            ->where('entreprise',auth()->user()->entreprise)
            ->where('vehicules.active','!=',1)
            ->where('vehicules.id',$id)
            ->get();
            $RendezVous=RendezVous::All();
            $stocks=Reference::All();
            return view('vehicules.liste')->with('vehicules',$vehicules)->with('RendezVous',$RendezVous)->with('stocks',$stocks)->with('references',$References)
            ->with('entreprises',$entreprises)->with('refPneus',$refPneus)
            ->with('nbRdv',$this->nombreRdv());
        }
    }
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
            
            for($i=0;$i<count(unserialize($vehicule->etatPneu));$i++)
            {
                $a=$tab[$i];
                        // $etatPneu[$i]=unserialize($vehicule->etatPneu)[$a];
                        // $etatPneuInit[$i]=unserialize($vehicule->etatPneuInit)[$a];
                        $hGomme[$i]=unserialize($vehicule->hGomme)[$a];
                        $ref[$i]=unserialize($vehicule->refPneus)[$a];
                        $t1[$i]=unserialize($vehicule->t1)[$a];
                        if($vehicule->t2!=null)
                        {
                            $t2[$i]=unserialize($vehicule->t2)[$a];
                        }

            }
            array_push($t1,unserialize($vehicule->t1)[4],unserialize($vehicule->t1)[5]);
            if($vehicule->t2!=null)
            {
                array_push($t2,unserialize($vehicule->t2)[4],unserialize($vehicule->t2)[5]);
            }
            $vehicule->t1=serialize($t1);
            if($vehicule->t2!=null)
            {
                $vehicule->t2=serialize($t2);
            }
            $vehicule->hGomme=serialize($hGomme);
            $vehicule->refPneus=serialize($ref);
            $vehicule->dpermutation=date('Y-m-d H:i:s',strtotime($req->date));
            $vehicule->permutation=$vehicule->limiteP;

            
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
                $st->quantite=-1;
                $st->date=date('Y-m-d');
                $st->save();
                $tref[$in]=$st->id;
            }
            $vehicule->refPneus=serialize($tref);
        }
        else
        {
            if(count($req->hg)==6)
             {
                $hg=array($req->hg[0],$req->hg[1],$req->hg[3],$req->hg[4],$req->hg[2],$req->hg[5]);
             }
             else
             {
                $hg=$req->hg;
             }
            $refused=0;
            for($i=0;$i<count($hg);$i++)
             {
                if($req->hg[$i]==null or $req->kilometrage==null)
                {
                    $notif=array(
                        'message'=>'Veuillez remplir tous les champs',
                        'alert-type'=>'error'
                    );
                    return redirect()->back()->with($notif);
                }
                if($hg[$i]>=unserialize($vehicule->hGomme)[$i] or  $req->kilometrage<=$vehicule->kilometrage)
                {
                    $notif=array(
                        'message'=>'Il faut changer les valeurs',
                        'alert-type'=>'error'
                    );
                    return redirect()->back()->with($notif);
                }
             }
             
            for($i=0;$i<count($hg);$i++)
            {
                $t1[$i]=unserialize($vehicule->hGomme)[$i];
                if($hg[$i]>unserialize($vehicule->hGomme)[$i] or $req->kilometrage<$vehicule->kilometrage)
                {
                    $refused=1;
                }
            }
            if($refused==0)
            {
                $t=$hg;
                    array_push($t1,$vehicule->kilometrage,$vehicule->control);
                    $vehicule->t1=serialize($t1);
                array_push($t,$req->kilometrage,$req->date);
                $vehicule->t2=serialize($t);
            }
        }
        $vehicule->derniereMaintenance=$req->date;
        $vehicule->hGomme=serialize($hg);
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
        $vehicule->dernierePerte=$req->date;
        $main=Maintenance::find($req->maintenance);
        $main->dControl=$vehicule->control;
        $main->kilometrageIn=$vehicule->kilometrage;
        $main->permutationIn=$vehicule->permutation;
        $main->save();
        $vehicule->control=$req->date;
        }
    	$vehicule->save();
    	$notif=array(
    		'message'=>'mise à jour réussi',
    		'alert-type'=>'success'
    	);
    	return redirect()->back()->with($notif);
    }
    public function reset(Request $req)
    {
        $vehicule=Vehicule::find($req->id);
        for($i=0;$i<count(unserialize($vehicule->etatPneuInit));$i++)
        {
            $count[$i]=unserialize($vehicule->etatPneuInit)[$i];
        }
        $vehicule->etatPneu=serialize($count);
         $vehicule->dpression=$req->date;
        $vehicule->save();
    $notif=array(
            'message'=>'Reinitialisation réussi',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notif);
    }
    public function entreprises()
    { 
           $References=DB::table('stocks')
                            ->join('references','references.id','stocks.reference_id')
                            ->selectRaw('stocks.id,hgInit,hgFinal,kInit,kFinal,reference,prix,gazole,cout,indication,consommation,id_vehicule,reference_id,pose,depose,quantite')
                            ->where('hgInit','!=',null)
                            ->where('hgFinal','!=',null)
                            ->where('kInit','!=',null)
                            ->where('kFinal','!=',null)
                            ->get();
            $entreprises=DB::table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('count(vehicules.id) as nombre,entreprise,name,users.id,vehicules.active')
            ->groupByRaw('entreprise,name,users.id,vehicules.active')
            ->where('vehicules.active',0)
            ->where('role','responsable')
            ->get();
            $vehicules=DB::table('vehicules')
            ->selectRaw('entreprise,vehicules.id,immatriculation,model,marque')
            ->join('users','users.id','vehicules.conducteur_id')
            ->where('vehicules.active',0)
            ->get();
            return view('vehicules.entreprises')->with('entreprises',$entreprises)->with('vehicules',$vehicules)
            ->with('References',$References)
            ->with('nbRdv',$this->nombreRdv());
        // }
        // else
        // {
        //     if(auth()->user()->role=='responsable')
        //     {
        //         $idE=auth()->user()->id;
        //     } 
        //     else
        //     {
        //         $user=User::where('role','responsable')->where('entreprise',auth()->user()->entreprise)->where('active',0)->first();
        //         $idE=$user->id;
        //     }
        //     $References=DB::table('stocks')
        //                     ->join('references','references.id','stocks.reference_id')
        //                     ->selectRaw('stocks.id,hgInit,hgFinal,kInit,kFinal,reference,prix,gazole,cout,indication,consommation,id_vehicule,reference_id,pose,depose,quantite')
        //                     ->where('hgInit','!=',null)
        //                     ->where('hgFinal','!=',null)
        //                     ->where('kInit','!=',null)
        //                     ->where('kFinal','!=',null)
        //                     ->get();
        //     $entreprises=DB::table('vehicules')
        //     ->join('users','users.id','vehicules.conducteur_id')
        //     ->selectRaw('count(vehicules.id) as nombre,entreprise,name,users.id,vehicules.active')
        //     ->groupByRaw('entreprise,name,users.id,vehicules.active')
        //     ->where('vehicules.active',0)
        //     ->where('users.id',$idE)
        //     ->get();
        //     $vehicules=DB::table('vehicules')
        //     ->selectRaw('entreprise,vehicules.id,immatriculation,model,marque')
        //     ->join('users','users.id','vehicules.conducteur_id')
        //     ->where('vehicules.active',0)
        //     ->where('users.id',$idE)
        //     ->get();
        //     return view('vehicules.entreprises')->with('entreprises',$entreprises)->with('vehicules',$vehicules)
        //     ->with('References',$References)
        //     ->with('nbRdv',$this->nombreRdv());
        // }
    }
    public function continue($id)
    {
        $pneuUses=DB::table('stocks')
                            ->join('references','references.id','stocks.reference_id')
                            ->selectRaw('stocks.id,hgInit,hgFinal,kInit,kFinal,reference,prix,gazole,cout,indication,consommation,id_vehicule,reference_id,pose,depose')
                            ->where('hgInit','!=',null)
                            ->where('hgFinal','!=',null)
                            ->where('kInit','!=',null)
                            ->where('kFinal','!=',null)
                            ->get();
        $maintenance=DB::table('maintenances')
                ->join('rendez_vous','rendez_vous.id','maintenances.rdv_id')
                ->selectRaw('commentaire,rendez_vous.id as id,debut,maintenances.id as ide,imageIn1,imageIn2,hGommeIn,rdv_id,referenceIn,kilometrageIn,permutationIn')
                ->where('maintenances.id',$id)
                ->get();
        $RendezVous=RendezVous::
        where('id',$maintenance[0]->rdv_id)
        ->get();
        $vehicule=Vehicule::find($RendezVous[0]->vehicule_id);
        $stocks=DB::table('references')
        ->join('stocks','stocks.reference_id','references.id')
        ->selectRaw('stocks.id,reference,hgInit')
        ->get();
        $references=Reference::All();
        return view('maintenances.interface')
        ->with('vehicule',$vehicule)
        ->with('stocks',$stocks)
        ->with('maintenance',$maintenance)
        ->with('references',$references)
        ->with('pneuUses',$pneuUses)
        ->with('nbRdv',$this->nombreRdv());
    }
    public function begin2(Request $req)
    {
        if(!$req->date){$daty=date('Y-m-d');}
        else{$date=$req->date;}
        $pneuUses=DB::table('stocks')
                            ->join('references','references.id','stocks.reference_id')
                            ->selectRaw('stocks.id,hgInit,hgFinal,kInit,kFinal,reference,prix,gazole,cout,indication,consommation,id_vehicule,reference_id,pose,depose')
                            ->where('hgInit','!=',null)
                            ->where('hgFinal','!=',null)
                            ->where('kInit','!=',null)
                            ->where('kFinal','!=',null)
                            ->get();
        $vehicule=Vehicule::find($req->id);
        $RendezVous=RendezVous::where('vehicule_id',$vehicule->id)->where('date',$date)->where('accepted',2)->get();
        if(!isset($RendezVous[0]))
        {
            $RendezVous=new RendezVous();
            $RendezVous->date=date('Y-m-d',strtotime($date));
            $RendezVous->heure=date('H:i:s');
            $RendezVous->vehicule_id=$req->id;
            $RendezVous->accepted=2;
            $RendezVous->finished=1;
            $RendezVous->save();
            $rdvId=$RendezVous->id;
            $maintenanceD=new Maintenance();
            $maintenanceD->debut=date('Y-m-d H:i:s',strtotime($date));
            $maintenanceD->fin=date('Y-m-d H:i:s',strtotime($date));
            $maintenanceD->rdv_id=$rdvId;
            $maintenanceD->save();
        }
        else
        {
            $RendezVous[0]->finished=1;
            $RendezVous[0]->save();
            $rdvId=$RendezVous[0]->id;
        }
                $maintenance=DB::table('maintenances')
                ->join('rendez_vous','rendez_vous.id','maintenances.rdv_id')
                ->selectRaw('commentaire,rendez_vous.id as id,debut,maintenances.id as ide,imageIn1,imageIn2,hGommeIn')
                ->where('vehicule_id',$req->id)
                ->where('debut',$date)
                ->where('accepted',2)
                ->where('finished','!=',2)
                ->get();
        $stocks=DB::table('references')
        ->join('stocks','stocks.reference_id','references.id')
        ->selectRaw('stocks.id,reference,hgInit')
        ->get();
        $references=Reference::All();
         return redirect()->route('begin',$rdvId);
        return view('maintenances.interface')
        ->with('vehicule',$vehicule)
        ->with('stocks',$stocks)
        ->with('maintenance',$maintenance)
        ->with('references',$references)
        ->with('pneuUses',$pneuUses)
        ->with('nbRdv',$this->nombreRdv());
    }
    public function begin($id)
    {
        $pneuUses=DB::table('stocks')
                            ->join('references','references.id','stocks.reference_id')
                            ->selectRaw('stocks.id,hgInit,hgFinal,kInit,kFinal,reference,prix,gazole,cout,indication,consommation,id_vehicule,reference_id,pose,depose')
                            ->where('hgInit','!=',null)
                            ->where('hgFinal','!=',null)
                            ->where('kInit','!=',null)
                            ->where('kFinal','!=',null)
                            ->get();
        $RendezVous=RendezVous::find($id);
        $vehicule=Vehicule::find($RendezVous->vehicule_id);
        // $RendezVous->finished=1;
        // $RendezVous->save();
        $rdvId=$RendezVous->id;
        $maintenance=DB::table('maintenances')
                ->join('rendez_vous','rendez_vous.id','maintenances.rdv_id')
                ->where('rdv_id',$rdvId)
                ->get();
        if(!isset($maintenance[0]))
        {
            $maintenanceD=new Maintenance();
            $maintenanceD->debut=date('Y-m-d H:i:s');
            $maintenanceD->fin=date('Y-m-d H:i:s');
            $maintenanceD->rdv_id=$rdvId;
            $maintenanceD->save();
        }
        $maintenance=DB::table('maintenances')
                ->join('rendez_vous','rendez_vous.id','maintenances.rdv_id')
                ->selectRaw('commentaire,rendez_vous.id as id,debut,maintenances.id as ide,imageIn1,imageIn2,hGommeIn,referenceIn,kilometrageIn,permutationIn')
                ->where('rdv_id',$rdvId)
                ->get();
        $stocks=DB::table('references')
        ->join('stocks','stocks.reference_id','references.id')
        ->selectRaw('stocks.id,reference,hgInit')
        ->get();
        $references=Reference::All();
        return view('maintenances.interface')
        ->with('vehicule',$vehicule)
        ->with('stocks',$stocks)
        ->with('maintenance',$maintenance)
        ->with('references',$references)
        ->with('pneuUses',$pneuUses)
        ->with('nbRdv',$this->nombreRdv());
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
                'header' => 'Bonjour ,',
                'p1'=>'votre véhicule immatriculée '.$vehiculeUpdate->immatriculation
                .' '.$vehiculeUpdate->model.'('.$vehiculeUpdate->marque.') a besoin d\'une maintenance ou d\'un contrôle. Merci de vous connecter sur le site de MMP  pour  prendre un Rendez-vous.',
            ];
            $alert=new Alerte();
            $alert->vehicule_id=$req->id;
            $alert->message='Bonjour , votre véhicule immatriculée '.$vehiculeUpdate->immatriculation
                    .' '.$vehiculeUpdate->model.'('.$vehiculeUpdate->marque.') a besoin d\'une maintenance ou d\'un contrôle. Merci de vous connecter sur le site  pour  prendre un Rendez-vous.';
            $alert->save();
        }
        else
        {
            $details = [
                'header' => 'Bonjour ,',
                'p1' => $req->texte,
            ];
            $alert=new Alerte();
            $alert->vehicule_id=$req->id;
            $alert->message=$req->texte;
            $alert->save();
        }
        \Mail::to($responsable->email)->send(new SendMail($details));
        \Mail::to($vehiculeUpdate->emailH)->send(new SendMail($details));
         $notif=array(
            'message'=>'Véhicule alertée',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notif);
    }
    public function changement(Request $req)
    {
        $stockDispo=DB::table('stocks')
        ->selectRaw('sum(quantite) as qte')
            ->where('reference_id',$req->ref)
            ->get();
            if($stockDispo[0]->qte<1)
            {
               $notif=array(
                'message'=>'Ce pneu n\'est pas disponible',
                'alert-type'=>'error'
                );
                return redirect()->back()->with($notif);
            }
        $vehicule=Vehicule::find($req->id);
        $old=Stock::find($req->idOld);
        if($req->hgOld==$old->hgInit)
        {
            $notif=array(
            'message'=>'Il faut faire une mise à jour avant le changement',
            'alert-type'=>'error'
        );
        return redirect()->back()->with($notif);
        }
        $old->hgFinal=$req->hgOld;
        $old->kFinal=$vehicule->kilometrage;
        $old->id_vehicule=$vehicule->id;
        $old->depose=$req->date;
        $old->save();
        $stat=new Statistique();
        $stat->nombre=1;
        $stat->vehicules_id=$req->id;
        $stat->reference_id=$req->ref;
        $stat->save(); 
        $entreprise=User::find($vehicule->conducteur_id);
        $stock=new Stock();
        $stock->reference_id=$req->ref;
        $stock->quantite=-1;
        $stock->date=date('d/m/y H:i:s',strtotime($req->date));
        $stock->pose=$req->date;
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
                $t1[$i]=$req->hg;
                $t2[$i]=$req->hg;
            }
            else
            {
                $hGomme[$i]=unserialize($vehicule->hGomme)[$i];
                $ref[$i]=unserialize($vehicule->refPneus)[$i];
                $t1[$i]=unserialize($vehicule->t1)[$i];
                $t2[$i]=unserialize($vehicule->t2)[$i];
            }
        }
        if(count(unserialize($vehicule->etatPneu))==6)
        {
            array_push($t1,unserialize($vehicule->t1)[6],unserialize($vehicule->t1)[7]);
            array_push($t2,unserialize($vehicule->t2)[6],unserialize($vehicule->t2)[7]);
        }
        else
        {
            array_push($t1,unserialize($vehicule->t1)[4],unserialize($vehicule->t1)[5]);
            array_push($t2,unserialize($vehicule->t2)[4],unserialize($vehicule->t2)[5]);
        }
        $vehicule->t1=serialize($t1);
        $vehicule->t2=serialize($t2);
        $vehicule->refPneus=serialize($ref);
        $vehicule->hGomme=serialize($hGomme);
        $vehicule->save();
        $maintenance=Maintenance::where('rdv_id',$req->idmain)->get();
        // $maintenance[0]->referenceIn=serialize($ref);
        $maintenance[0]->hGommeIn=serialize($hGomme);
        $maintenance[0]->save();
        $notif=array(
            'message'=>'changement réussi',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notif);
        
    }

}
