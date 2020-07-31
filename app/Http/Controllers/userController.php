<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Model\Vehicule;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendMail;
use DB;
class userController extends Controller
{
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
		$entreprises=User::select('entreprise')->where('active','!=',1)->where('entreprise','!=','undefined')->groupBy('entreprise')->get();
	    $usersAccepted=User::where('role','!=','superadmin')->where('active','!=',1)->where('role','!=','operateur')->get();
	    return view('users.liste')
	    ->with('usersAccepted',$usersAccepted)
	    ->with('entreprises',$entreprises)
	    ->with('nbRdv',$this->nombreRdv());
	}
	}
	public function create()
	{
		if(auth()->user()->role=='superadmin')
        {
		$entreprises=User::select('entreprise')->where('active','!=',1)->where('entreprise','!=','undefined')->groupBy('entreprise')->get();
		return view('users.create')->with('entreprises',$entreprises)->with('nbRdv',$this->nombreRdv());
	}
	}
	public function store(Request $req)
	{
		$user=new User();
		$user->name=$req->name;
		$user->email=$req->email;
		$user->password=Hash::make($req->password);
		$user->phone=$req->phone;
		/*if(auth()->user()->role=='responsable')
		{
			$user->role='conducteur';
			$user->entreprise=auth()->user()->entreprise;
		}
		if(auth()->user()->role=='superadmin')
		{
			$user->role='responsable';
			$user->entreprise=$req->entreprise;
		}*/
		if($req->entreprise!=null)
		{
			$user->entreprise=$req->entreprise;
		}
		if($req->entrepri!=null)
		{
			$user->entreprise=$req->entrepri;
		}
		$user->role=$req->role;
		if($user->role=='responsable')
		{
	        $utilisateurs=User::where('entreprise',$user->entreprise)->where('role','responsable')->where('active',0)->get();
	        
	        if(isset($utilisateurs[0]))
	        {
	        	$notif=array(
	    		'message'=>'Il existe déjà un responsable sur cette flotte',
	    		'alert-type'=>'error'
		    	);
				return redirect()->back()->with($notif);
	        }
	        else
	        { 
	        		$utilisateurs=User::where('entreprise',$user->entreprise)->where('role','responsable')->where('active',1)->get();
		        	
	        		if(isset($utilisateurs[0]))
	        		{
	        			$utilisateurs[0]->email='exemple@g.c';
	        			$utilisateurs[0]->save();
	        			$user->save();
		        		$vehicules=Vehicule::where('conducteur_id',$utilisateurs[0]->id)->get();
				        foreach ($vehicules as $vehicule) {
				        	$vehicule->conducteur_id=$user->id;
				        	$vehicule->save();
				        }
				        $utilisateurs[0]->delete();
	        		}
	        		else
	        		{
	        			$user->save();
	        		}

	        }
		}
		else
		{
			$user->save();
		}
		
		$details = [
            'title' => 'Votre compte MMP a été crée, vos identifiants :'.$req->email.'/'.$req->password.'',
            'body' => 'Vous pouvez tout de suite accéder à votre compte. Cordialement'
        ];
        \Mail::to($req->email)->send(new SendMail($details));
        $notif=array(
    		'message'=>'Ajout réussi',
    		'alert-type'=>'success'
    	);
		return redirect()->back()->with($notif);
	}
	public function modifier(Request $req)
	{
		if($req->passworde)
		{
			$user=User::find(auth()->user()->id);
			$user->password=Hash::make($req->passworde);
			$user->save();
		}
		else
		{
			if($req->logo!=null)
			{
				$path=$req->logo->storeAs('public', $req->logo->getClientOriginalName());
			}				
			$users=User::where('entreprise',auth()->user()->entreprise)->get();
			foreach($users as $user)
			{
				if($req->logo!=null)
				{
					$user->logo=$req->logo->getClientOriginalName();
				}
				$user->entreprise=$req->nom;
				$user->save();
			}
		}
		 $notif=array(
    		'message'=>'Modification réussi',
    		'alert-type'=>'success'
    	);
		return redirect()->back()->with($notif);
	}
	public function update(Request $req,$id)
	{
		$user=User::find($id);
		$user->name=$req->name;
		$user->email=$req->email;
		$user->phone=$req->phone;
		$user->role=$req->role;
		if($req->entreprise!=null)
		{
			$entreprise=$req->entreprise;
		}
		if($req->entrepri!=null)
		{
			$entreprise=$req->entrepri;
		}
		if($user->role=='responsable')
		{
	        $utilisateurs=User::where('entreprise',$entreprise)->where('role','responsable')->where('active',0)->where('id','!=',$id)->get();
	        if(isset($utilisateurs[0]))
	        {
	        	$notif=array(
	    		'message'=>'Il existe déjà un responsable sur cette flotte',
	    		'alert-type'=>'error'
		    	);
				return redirect()->back()->with($notif);
	        }
	        else
	        { 
	        	$flotte=User::where('entreprise',$entreprise)->where('id','!=',$id)->get();
	        	if (isset($flotte[0])) {
	        		$notif=array(
		    		'message'=>'Cette flotte existe déjà, vous devez en créer une autre',
		    		'alert-type'=>'error'
			    	);
				return redirect()->back()->with($notif);
	        	}
	        	$listUsers=User::where('entreprise',$user->entreprise)->get();
	        	foreach($listUsers as $lU)
	        	{
	        		$lU->entreprise=$entreprise;
	        		$lU->save();
	        	}
	        	$user->entreprise=$entreprise;
	        	$user->save();
	        		$utilisateurs=User::where('entreprise',$user->entreprise)->where('role','responsable')->where('active',1)->get();
	        		if(isset($utilisateurs[0]))
	        		{
		        		$vehicules=Vehicule::where('conducteur_id',$utilisateurs[0]->id)->get();
				        foreach ($vehicules as $vehicule) {
				        	$vehicule->conducteur_id=$user->id;
				        	$vehicule->save();
				        }
				        $utilisateurs[0]->delete();
	        		}
	        }
		}
		else
		{
			$user->save();
		}
		$notif=array(
    		'message'=>'Modification réussie',
    		'alert-type'=>'success'
    	);
		return redirect()->back()->with($notif);
	}
	public function find($id)
	{
		$user=User::find($id);
		$entreprises=User::select('entreprise')->where('active','!=',1)->where('entreprise','!=','undefined')->groupBy('entreprise')->get();
		return view('users.edit')->with('user',$user)->with('entreprises',$entreprises);
	}
	public function destroy($id)
	{
		$user=User::find($id);
		if($user->role=='responsable')
		{
			$user->active=1;
			$user->save();
		}
		else
		{
			$user->delete();
		}
		$notif=array(
    		'message'=>'Suppression réussie',
    		'alert-type'=>'success'
    	);
		return redirect()->back()->with($notif); 
	}
	public function reinitialiser($id)
	{
		$user=User::find($id);
		$user->password=Hash::make('12345678');
		$user->save();
		$notif=array(
    		'message'=>'Réinialisation réussi',
    		'alert-type'=>'success'
    	);
		return redirect()->back()->with($notif);
	}
	public function show($id)
	{
		
		if(auth()->user()->role=='superadmin')
        {
		$entreprises=User::where('role','responsable')->get();
		$vehicule=DB::table('vehicules')
            ->join('users','users.id','vehicules.conducteur_id')
            ->selectRaw('entreprise,emailH,phoneH,nomH')
            ->where('vehicules.id',$id)
            ->get();
		return view('users.createV')->with('entreprises',$entreprises)->with('nbRdv',$this->nombreRdv())->with('vehicule',$vehicule);
		}
	}
	public function nonactive()
	{
		$user=User::where('active',1)->get();
		foreach($user as $us)
		{
			$us->delete();
		}
		return 'zay';
	}
}
