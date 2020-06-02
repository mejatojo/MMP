<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\Model\Stock;
use App\Model\Reference;
use App\Model\Vehicule;
class statController extends Controller
{
	public function utiliser()
	{
	    $stats=DB::table('statistiques')
	    	->join('vehicules','vehicules.id','vehicules_id')
	    	->join('users','users.id','conducteur_id')
	    	->selectRaw('entreprise,sum(nombre) as nb')
	    	->groupBy('entreprise')
	    	->get();
	    return view('statistiques.utiliser')->with('stats',$stats);
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
	    return view('statistiques.utiliser')->with('stats',$stats)->with('date',$req->date)->with('users',$users);
	}
	public function couts()
	{
		$references=Reference::All();
		return view('statistiques.cout')->with('references',$references);
	}
	public function modifier(Request $req)
	{
		$reference=Reference::find($req->reference);
		$reference->prix=$req->prix;
		$reference->cout=$req->cout;
		$reference->gazole=$req->gazole;
		$reference->indication=$req->indication;
		if($req->indication=='A')
		{
			$reference->consommation=0;
		}
		if($req->indication=='B')
		{
			$reference->consommation=0.14;
		}
		if($req->indication=='C')
		{
			$reference->consommation=0.24;
		}
		if($req->indication=='E')
		{
			$reference->consommation=0.45;
		}
		if($req->indication=='F')
		{
			$reference->consommation=0.62;
		}
		if($req->indication=='G')
		{
			$reference->consommation=0.63;
		}
		$reference->save();
		return redirect()->back();
	}
	public function possession()
	{
		$vehicules=DB::table('vehicules')
			->join('users','users.id','vehicules.conducteur_id')
			->get();
		$References=DB::table('stocks')
							->join('references','references.id','stocks.reference_id')
							->selectRaw('stocks.id,hgInit,hgFinal,kInit,kFinal,reference,prix,gazole,cout,indication,consommation')
							->where('quantite','-1')
							->where('hgInit','!=',null)
							->where('hgFinal','!=',null)
							->where('kInit','!=',null)
							->where('kFinal','!=',null)
							->get();
		return view('statistiques.possession')
			->with('vehicules',$vehicules)
			->with('References',$References);
	}
}
