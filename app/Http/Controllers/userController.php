<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendMail;

class userController extends Controller
{
	public function index()
	{
		if(auth()->user()->role=='superadmin')
        {
		$entreprises=User::where('role','responsable')->get();
	    $usersAccepted=User::where('role','!=','superadmin')->where('active','!=',1)->where('role','!=','operateur')->get();
	    return view('users.liste')
	    ->with('usersAccepted',$usersAccepted)
	    ->with('entreprises',$entreprises);
	}
	}
	public function create()
	{
		if(auth()->user()->role=='superadmin')
        {
		$entreprises=User::where('role','responsable')->get();
		return view('users.create')->with('entreprises',$entreprises);
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
			$user->role='conducteur';
		}
		if($req->entrepri!=null)
		{
			$user->entreprise=$req->entrepri;
			$user->role='responsable';
		}
		$user->save();
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
		$path=$req->logo->storeAs('public', $req->logo->getClientOriginalName());
		$users=User::where('entreprise',auth()->user()->entreprise)->get();
		foreach($users as $user)
		{
			$user->logo=$req->logo->getClientOriginalName();
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
		$user->entreprise=$req->entreprise;
		$user->save();
		return redirect()->back();
	}
	public function destroy($id)
	{
		$user=User::find($id);
		$user->active=1;
		$user->save();
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
}
