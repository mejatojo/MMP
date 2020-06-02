<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Vehicule;
use App\Model\RendezVous;

use App\Model\Maintenance;
use App\Model\Statistique;
use App\Model\Stock;

use App\Model\Reference;
use DB;
use File;
use App\User;
class stockController extends Controller
{
    public function index()
    {
        if(auth()->user()->role=='superadmin')
        {
    	$stocks=DB::table('stocks')
            ->join('references','references.id','stocks.reference_id')
            ->selectRaw('sum(quantite) as qte,reference,reference_id')
            ->groupByRaw('reference,reference_id')
            ->get();
        $stockinitials=DB::table('stocks')
            ->join('references','references.id','stocks.reference_id')
            ->selectRaw('sum(quantite) as qte,reference,reference_id')
            ->where('quantite','>',0)
            ->groupByRaw('reference,reference_id')
            ->get();
        $stockperdus=DB::table('stocks')
            ->join('references','references.id','stocks.reference_id')
            ->selectRaw('sum(quantite) as qte,reference,reference_id')
            ->where('quantite','<',0)
            ->groupByRaw('reference,reference_id')
            ->get();
    	return view('stocks.liste')
            ->with('stocks',$stocks)
            ->with('stockinitials',$stockinitials)
            ->with('stockperdus',$stockperdus);
        }
    }
    public function store(Request $req)
    {
        if(isset($req->referenceName))
        {
            $ref=new Reference();
            $ref->reference=$req->referenceName;
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
            ->selectRaw('reference_id,reference,stocks.id as ide,quantite,date,source')
            ->where('reference_id',$id)
            ->where('quantite','>',0)
            ->get();
        $stocksorties=DB::table('stocks')
            ->join('references','references.id','stocks.reference_id')
            ->selectRaw('reference_id,reference,stocks.id as ide,quantite,date,source')
            ->where('reference_id',$id)
            ->where('quantite','<',0)
            ->get();
        return view('stocks.detail')
            ->with('stocksorties',$stocksorties)
            ->with('stockentres',$stockentres);
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
        File::put('mytextdocument'.date('d_m_Y').'.sql','delete from maintenances;delete from rendez_vous;delete from statistiques;delete from vehicules;');
        $vehicules=Vehicule::All();
        foreach ($vehicules as $vehicule) {
            File::append("mytextdocument".date('d_m_Y').".sql","insert into vehicules(id,immatriculation,marque,model,pneu,derniereMaintenance,etatPneu,control,refPneus,t1,t2,kilometrage,etatPneuInit,dernierePerte,hGomme,conducteur_id,dateC,serrage,type,active,nomH,emailH,phoneH,information,imageV,imageV2,observations,factureV) 
                values (".$vehicule->id.",'".$vehicule->immatriculation."','".$vehicule->marque."','".$vehicule->model."','".$vehicule->pneu."','".$vehicule->derniereMaintenance."','".$vehicule->etatPneu."','".$vehicule->control."','".$vehicule->refPneus."','".$vehicule->t1."','".$vehicule->t2."','".$vehicule->kilometrage."','".$vehicule->etatPneuInit."','".$vehicule->dernierePerte."','".$vehicule->hGomme."','".$vehicule->conducteur_id."','".$vehicule->dateC."','".$vehicule->serrage."','".$vehicule->type."','".$vehicule->active."','".$vehicule->nomH."','".$vehicule->emailH."','".$vehicule->phoneH."','".$vehicule->information."','".$vehicule->imageV."','".$vehicule->imageV2."','".$vehicule->observations."','".$vehicule->factureV."');");
        }
        $rdvs=RendezVous::All();
        foreach($rdvs as $rdv)
        {
            File::append("mytextdocument".date('d_m_Y').".sql","insert into rendez_vous (id,date,heure,vehicule_id,commentaire,accepted,finished,raison) values (
                ".$rdv->id.",'".$rdv->date."','".$rdv->heure."','".$rdv->vehicule_id."','".$rdv->commentaire."','".$rdv->accepted."','".$rdv->finished."','".$rdv->raison."'
        );");
        }
        $maintenances=Maintenance::where('debut','!=',null)->where('fin','!=',null)->get();
        foreach($maintenances as $main)
        {
            File::append("mytextdocument".date('d_m_Y').".sql","insert into maintenances (id,debut,fin,operations,rdv_id,facture) values (
                ".$main->id.",'".$main->debut."','".$main->fin."','".$main->operations."','".$main->rdv_id."','".$main->facture."'
        );");
        }
        $statistiques=Statistique::All();
        foreach($statistiques as $stat)
        {
            File::append("mytextdocument".date('d_m_Y').".sql","insert into statistiques (id,nombre,reference_id,vehicules_id) values (
                ".$stat->id.",'".$stat->nombre."','".$stat->reference_id."','".$stat->vehicules_id."'
        );");
        }
        return view('sauvegarde.sauvegarde');
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
