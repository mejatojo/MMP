<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Vehicule;
use App\Model\RendezVous;
use App\Model\Alerte;
use App\Model\Maintenance;
use App\Model\Statistique;
use App\Model\Stock;
use App\Model\Reference;
use DB;
use File;
use App\User;
class stockController extends Controller
{
    public function destroy($id)
    {
        $stocks=Stock::where('reference_id',$id)->get();
        foreach ($stocks as $stock) {
            $stock->delete();
        }
        $reference=Reference::find($id);
        $reference->delete();
        $notif=array(
            'message'=>'Suppression réussie',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notif);
    }
    public function cout(Request $req)
    {
        $stock1=Stock::find($req->id1);
        $stock1->cout=$req->cout1;
        $stock1->save();
        $stock0=Stock::find($req->id0);
        $stock0->cout=$req->cout0;
        $stock0->save();
        $stock2=Stock::find($req->id2);
        $stock2->cout=$req->cout2;
        $stock2->save();
        $stock3=Stock::find($req->id3);
        $stock3->cout=$req->cout3;
        $stock3->save();
        if(isset($req->cout4))
        {
            $stock4=Stock::find($req->id4);
            $stock4->cout=$req->cout4;
            $stock4->save();
            $stock5=Stock::find($req->id5);
            $stock5->cout=$req->cout5;
            $stock5->save();
        }
        $notif=array(
            'message'=>'Modification réussie',
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
    public function index()
    {
        if(auth()->user()->role=='superadmin')
        {
    	$stocks=DB::table('stocks')
            ->join('references','references.id','stocks.reference_id')
            ->selectRaw('sum(quantite) as qte,reference,reference_id,prix,indication,consommation')
            ->groupByRaw('reference,reference_id,prix,indication,consommation')
            ->get();
        $stockinitials=DB::table('stocks')
            ->join('references','references.id','stocks.reference_id')
            ->selectRaw('sum(quantite) as qte,reference,reference_id')
            ->where('quantite','>',0)
            ->groupByRaw('reference,reference_id')
            ->get();
        $stockperdus=DB::table('stocks')
            ->join('references','references.id','stocks.reference_id')
            ->selectRaw('count(quantite) as qte,reference,reference_id')
            ->where('quantite','<=',0)
            ->groupByRaw('reference,reference_id')
            ->get();
        $vehicules=Vehicule::where('active',0)->get();
        $Reference=DB::table('stocks')
            ->join('references','references.id','stocks.reference_id')
            ->selectRaw('reference,reference_id,stocks.id')
            ->get();
    	return view('stocks.liste')
            ->with('stocks',$stocks)
            ->with('stockinitials',$stockinitials)
            ->with('stockperdus',$stockperdus)
            ->with('vehicules',$vehicules)
            ->with('Reference',$Reference)
            ->with('nbRdv',$this->nombreRdv()); 
        }
    }
    public function modifier(Request $req)
    {
            $ref=Reference::find($req->reference);
            $ref->reference=$req->nvref;
            
            $ref->prix=$req->prix;
            $ref->indication=$req->indication;
            if($req->indication=='A')
            {
                $ref->consommation=0;
            }
            if($req->indication=='B')
            {
                $ref->consommation=0.14;
            }
            if($req->indication=='C')
            {
                $ref->consommation=0.28;
            }
            if($req->indication=='E')
            {
                $ref->consommation=0.45;
            }
            if($req->indication=='F')
            {
                $ref->consommation=0.62; 
            }
            if($req->indication=='G')
            {
                $ref->consommation=0.63;
            }
            $ref->save();
            return redirect()->back();
    }
    public function store(Request $req)
    {
        if(isset($req->referenceName))
        {
            $ref=new Reference();
            $ref->reference=$req->referenceName;
            $ref->prix=$req->prix;
            $ref->indication=$req->indication;
            if($req->indication=='A')
            {
                $ref->consommation=0;
            }
            if($req->indication=='B')
            {
                $ref->consommation=0.14;
            }
            if($req->indication=='C')
            {
                $ref->consommation=0.28;
            }
            if($req->indication=='E')
            {
                $ref->consommation=0.45;
            }
            if($req->indication=='F')
            {
                $ref->consommation=0.62; 
            }
            if($req->indication=='G')
            {
                $ref->consommation=0.63;
            }
            $ref->save();
            $stock=new Stock();
            $stock->reference_id=$ref->id;
            $stock->date=date('d/m/y H:i:s');
            $stock->quantite=$req->quantite;
            $stock->source=$req->source;
            $stock->save();
        }
        else
        {
            $nvStock=new Stock();
            $nvStock->reference_id=$req->reference;
        	$nvStock->quantite=$req->quantite;
            $nvStock->source=$req->source;
            $nvStock->date=date('d/m/y H:i:s');
        	$nvStock->save();
        }
    	return redirect()->back();
    }
    public function show($id)
    {
        $stockentres=DB::table('stocks')
            ->join('references','references.id','stocks.reference_id')
            ->selectRaw('reference_id,reference,stocks.id as ide,quantite,date,source,pose')
            ->where('reference_id',$id)
            ->where('quantite','>',0)
            ->get();
        $stocksorties=DB::table('stocks')
            ->join('references','references.id','stocks.reference_id')
            ->selectRaw('reference_id,reference,stocks.id as ide,quantite,date,source,pose')
            ->where('reference_id',$id)
            ->where('quantite','<',0)
            ->get();
        return view('stocks.detail')
            ->with('stocksorties',$stocksorties)
            ->with('stockentres',$stockentres)
            ->with('nbRdv',$this->nombreRdv());
    }
    public function update(Request $req,$id)
    {
        $stock=Stock::find($id);
        $stock->quantite=$req->quantite;
        $stock->source=$req->source;
        $stock->save();
        return redirect()->back();
    }
    public function remove($id)
    {
        $stock=Stock::find($id);
        $stock->delete();
        return redirect()->back();
    }
    public function sauvegarde()
    {
        File::put('mytextdocument'.date('d_m_Y').'.sql','delete from maintenances;delete from rendez_vous;delete from statistiques;delete from alertes;delete from vehicules;delete from stocks where hgFinal>0 and kFinal>0;delete from users where role!="superadmin" and role!="operateur";');
        $users=User::where('role','!=','superadmin')->where('role','!=','operateur')->get();
        foreach($users as $u)
        {
            File::append('mytextdocument'.date('d_m_Y').'.sql','insert into users (id,name,email,role,phone,entreprise,logo,password,active) values (
                '.$u->id.',"'.$u->name.'","'.$u->email.'","'.$u->role.'","'.$u->phone.'","'.$u->entreprise.'","'.$u->logo.'","'.$u->password.'","'.$u->active.'");');
        }
        $vehicules=Vehicule::All();
        foreach ($vehicules as $vehicule) {
            File::append("mytextdocument".date('d_m_Y').".sql","insert into vehicules(id,immatriculation,marque,model,pneu,derniereMaintenance,etatPneu,dpression,control,cConstant,refPneus,refPneuInit,t1,t2,tConstant,kilometrage,permutation,dpermutation,etatPneuInit,dernierePerte,hGomme,conducteur_id,alert,dateAlert,alertP,dateAlertP,dateC,serrage,type,active,nomH,emailH,phoneH,information,imageV,imageV2,observations,factureV,stationnement,carburant,limiteHg,limiteP,limitePression) 
                values (".$vehicule->id.",'".$vehicule->immatriculation."','".$vehicule->marque."','".$vehicule->model."','".$vehicule->pneu."','".$vehicule->derniereMaintenance."','".$vehicule->etatPneu."','".$vehicule->dpression."','".$vehicule->control."','".$vehicule->cConstant."','".$vehicule->refPneus."','".$vehicule->refPneuInit."','".$vehicule->t1."','".$vehicule->t2."','".$vehicule->tConstant."','".$vehicule->kilometrage."','".$vehicule->permutation."','".$vehicule->dpermutation."','".$vehicule->etatPneuInit."','".$vehicule->dernierePerte."','".$vehicule->hGomme."','".$vehicule->conducteur_id."','".$vehicule->alert."','".$vehicule->dateAlert."','".$vehicule->alertP."','".$vehicule->dateAlertP."','".$vehicule->dateC."','".$vehicule->serrage."','".$vehicule->type."','".$vehicule->active."','".$vehicule->nomH."','".$vehicule->emailH."','".$vehicule->phoneH."','".$vehicule->information."','".$vehicule->imageV."','".$vehicule->imageV2."','".$vehicule->observations."','".$vehicule->factureV."','".$vehicule->stationnement."','".$vehicule->carburant."','".$vehicule->limiteHg."','".$vehicule->limiteP."','".$vehicule->limitePression."');");
        }
        $rdvs=RendezVous::All();
        foreach($rdvs as $rdv)
        {
            File::append("mytextdocument".date('d_m_Y').".sql","insert into rendez_vous (id,date,heure,vehicule_id,commentaire,accepted,finished,raison,calendarId,created_at) values (
                ".$rdv->id.",'".$rdv->date."','".$rdv->heure."','".$rdv->vehicule_id."','".$rdv->commentaire."','".$rdv->accepted."','".$rdv->finished."','".$rdv->raison."','".$rdv->calendarId."','".$rdv->created_at."');");
        }
        $maintenances=Maintenance::where('debut','!=',null)->where('fin','!=',null)->where('kilometrageIn','!=',null)->get();
        foreach($maintenances as $main)
        {
            File::append("mytextdocument".date('d_m_Y').".sql","insert into maintenances (id,debut,fin,operations,observations,rdv_id,facture,imageIn1,imageIn2,hGommeIn,referenceIn,kilometrageIn,permutationIn,dControl) values (
                ".$main->id.",'".$main->debut."','".$main->fin."','".$main->operations."','".$main->observations."','".$main->rdv_id."','".$main->facture."','".$main->imageIn1."','".$main->imageIn2."','".$main->hGommeIn."','".$main->referenceIn."','".$main->kilometrageIn."','".$main->permutationIn."','".$main->dControl."');");
        }
        $references=Reference::all();
        foreach ($references as $reference) {
            File::append("mytextdocument".date('d_m_Y').".sql","insert into `references` (
                id,reference,prix,indication,consommation) values (
                ".$reference->id.",'".$reference->reference."',".$reference->prix.",'".$reference->indication."','".$reference->consommation."');");
        }
        $tstocks=Stock::where('hgInit',null);
        foreach ($tstocks as $stock) {
            File::append("mytextdocument".date('d_m_Y').".sql","insert into stocks (id,reference_id,quantite,date,source,created_at) values (
                    ".$stock->id.",'".$stock->reference_id."','".$stock->quantite."','".$stock->date."','".$stock->source."','".$stock->created_at.
                    "');");
        }
         $stocks=Stock::where('hgFinal','!=',null)->where('kFinal','!=',null)->get();
        foreach($stocks as $stock)
        {
            if($stock->cout!=null and $stock->gazole!=null)
            {
                File::append("mytextdocument".date('d_m_Y').".sql","insert into stocks (id,reference_id,quantite,date,source,hgInit,kInit,hgFinal,kFinal,id_vehicule,cout,gazole,pose,depose,created_at) values (
                    ".$stock->id.",'".$stock->reference_id."','".$stock->quantite."','".$stock->date."','".NULL."','".$stock->hgInit."','".$stock->kInit."','".$stock->hgFinal."','".$stock->kFinal."','".$stock->id_vehicule."','".$stock->cout."','".$stock->gazole."','".$stock->pose."','".$stock->depose."','".$stock->created_at.
                    "');");
            }
            elseif($stock->cout!=null and $stock->gazole==null)
            {
                File::append("mytextdocument".date('d_m_Y').".sql","insert into stocks (id,reference_id,quantite,date,source,hgInit,kInit,hgFinal,kFinal,id_vehicule,cout,pose,depose,created_at) values (
                    ".$stock->id.",'".$stock->reference_id."','".$stock->quantite."','".$stock->date."','".NULL."','".$stock->hgInit."','".$stock->kInit."','".$stock->hgFinal."','".$stock->kFinal."','".$stock->id_vehicule."','".$stock->cout."','".$stock->pose."','".$stock->depose."','".$stock->created_at.
                    "');");
            }
            elseif($stock->cout==null and $stock->gazole!=null)
            {
                File::append("mytextdocument".date('d_m_Y').".sql","insert into stocks (id,reference_id,quantite,date,source,hgInit,kInit,hgFinal,kFinal,id_vehicule,gazole,pose,depose,created_at) values (
                    ".$stock->id.",'".$stock->reference_id."','".$stock->quantite."','".$stock->date."','".NULL."','".$stock->hgInit."','".$stock->kInit."','".$stock->hgFinal."','".$stock->kFinal."','".$stock->id_vehicule."','".$stock->gazole."','".$stock->pose."','".$stock->depose."','".$stock->created_at.
                    "');");
            }
            elseif($stock->cout==null and $stock->gazole==null)
            {
                File::append("mytextdocument".date('d_m_Y').".sql","insert into stocks (id,reference_id,quantite,date,source,hgInit,kInit,hgFinal,kFinal,id_vehicule,pose,depose,created_at) values (
                    ".$stock->id.",'".$stock->reference_id."','".$stock->quantite."','".$stock->date."','".NULL."','".$stock->hgInit."','".$stock->kInit."','".$stock->hgFinal."','".$stock->kFinal."','".$stock->id_vehicule."','".$stock->pose."','".$stock->depose."','".$stock->created_at.
                    "');");
            }
        }
        $alertes=Alerte::All();
        foreach($alertes as $a)
        {
            File::append('mytextdocument'.date('d_m_Y').'.sql','insert into alertes (id,vehicule_id,message,created_at,updated_at) values (
                '.$a->id.',"'.$a->vehicule_id.'","'.$a->message.'","'.$a->created_at.'","'.$a->updated_at.'");');
        }

        
        // $statistiques=Statistique::All();
        // foreach($statistiques as $stat)
        // {
        //     File::append("mytextdocument".date('d_m_Y').".sql","insert into statistiques (id,nombre,reference_id,vehicules_id) values (
        //         ".$stat->id.",'".$stat->nombre."','".$stat->reference_id."','".$stat->vehicules_id."'
        // );");
        // }
        return view('sauvegarde.sauvegarde')
        ->with('nbRdv',$this->nombreRdv());
        // File::get("mytextdocument".date('d_m_Y')."sql");
        // $vehicules=User::All();
        // File::put('mytextdocument'.date('d_m_Y').'sql','delete from users;');
        // foreach ($users as $user) {
        //     File::append("mytextdocument".date('d_m_Y')."sql","insert into users(name,email,role,phone,entreprise,logo,password,active) 
        //         values ('".$user->name."','".$user->email."','".$user->role."','".$user->phone."','".$user->entreprise."','".$user->logo."','".$user->password."','".$user->active."');");
        // }
          // DB::unprepared('delete from dates;insert into dates (datebloque) values ("22/07/18");insert into dates (datebloque) values ("29/07/20")');
    }
    public function importer(Request $req)
    {
        $path=$req->file->storeAs('public', $req->file->getClientOriginalName());
        $all=File::get('storage/'.$req->file->getClientOriginalName());
        DB::unprepared($all);
        $notif=array(
            'message'=>'Importation réussie',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notif);
    }
}
