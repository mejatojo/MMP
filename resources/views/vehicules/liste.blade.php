@extends('dashboard.dashboard')
@section('style')
  <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <style type="text/css">
  	.tableau
  	{
		border: 1px solid black;
  	}
  	.ty {
  position: relative;
/*  display: inline-block;
 border-bottom: 1px dotted black;*/ 
}

.ty .tytext {
  visibility: hidden;
  background-color: white; 
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  position: absolute;
  z-index: 1;
  top: 125%;
  right: : 300%;
  margin-right: -60px;
  opacity: 0;
  transition: opacity 0.3s;
}

.ty .tytext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

.ty:hover .tytext {
  visibility: visible;
  opacity: 1;
}
  </style>

<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
@endsection
@section('content')


<div class="card col-12 ">
            <div class="card-header">

              <h3 class="card-title">
              	@if(Auth::user()->role=='responsable' or Auth::user()->role=='conducteur' or Auth::user()->role=='PDG')
              	Liste des véhicules dans l'entreprise "{{Auth::user()->entreprise}}"
              	@else
              	Liste de tous les véhicules
              	@endif
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Immatriculation:</th>
                  <th>Marque:</th>
                  <th>Modèle:</th>
                  @if(Auth::user()->role=="superadmin")
                  <th>Entreprise:</th>
                  @endif
                  <th>Etat pneumatique:</th>
                  <th>kilométrage reel:</th>
                  <th>Permutation:</th>
                  <th>Pressions:</th>
                  <th>Maintenance:</th>
                  @if(Auth::user()->role!="conducteur")
                  @if(Auth::user()->role=='superadmin')
                  <th>Stationnement:</th>
                  @endif
                  <th>Dernière maintenance:</th>
                  <th>Kilométrage moyen:</th>
                  <th>Estimation de kilométrage :</th>
                  <th>Observations:</th>
                  <th>Image:</th>
                  @endif
                  <th>Action:</th>
                </tr>
                </thead>
                <tbody>
                	@foreach($vehicules as $vehicule)
                  <div class="modal fade" id="suprimer{{$vehicule->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  Vous voulez vraiment supprimer ce véhicule?
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                                  <a href="/vehicules/delete/{{$vehicule->id}}" type="button" class="btn btn-primary">Oui</a>
                                </div>
                              </div>
                            </div>
                          </div>
                	<div class="modal fade" id="exampleModal{{$vehicule->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Choisir la facture</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form action="{{route('vehicules.facturer')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="text" name="id" value="{{$vehicule->id}}" hidden>
                                <input type="file" name="file" class="form-control">
                                <button class="btn btn-primary">Valider</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                	<div class="modal fade" id="alert{{$vehicule->id}}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title" id="exampleModalLabel">Message d'alerte</h5>
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						      </div>
						      <div class="modal-body">
						        <form method="post" action="{{route('vehicules.alert')}}">
						        	@csrf
						        	<input type="text" name="id" value="{{$vehicule->id}}" hidden>
						        	<textarea class="form-control" name="texte" placeholder="Si vous laisser ce champs vide,il enverra un message par défaut"></textarea>
						        	<button class="btn btn-primary">Alerter</button>
						        </form>
						      </div>
						    </div>
						  </div>
						</div>
                	<div class="modal fade" id="exa{{$vehicule->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modification</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                          @include('vehicules.modifier')
                              </div>
                            </div>
                          </div>
                        </div>
                		<span hidden>{{$permutation=false}}</span>
		                <tr style="">
		                  <td>{{$vehicule->immatriculation}} </td>
		                   <td>{{$vehicule->marque}} </td>
		                    <td>{{$vehicule->model}} </td>
		                    @if(Auth::user()->role=="superadmin")
		                  <td>{{$vehicule->entreprise}}</td>
		                  @endif
		                  <td>

						<div class="ty" style="width: 13cm;">
  							<span class="tytext">
  								@if($vehicule->etatPneu)
		                  	<div class="row" style="width: 100%;">
		                  		@if(unserialize($vehicule->hGomme)[0]<$vehicule->limiteHg+0.4)
		                  		<div class="col-3"></div>
		                  		<div class="col-3 tableau" style="background: red">				
		                  			{{unserialize($vehicule->hGomme)[0]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[0]}} bar<br>
		                  			@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[0])
		                  					{{$reference->reference}}
		                  					@if($reference->quantite==0)
		                  					<br>(hors du stock)
		                  					@else
		                  					<br>MMP
		                  					@endif
		                  				@endif
		                  			@endforeach
		                  		</div>
		                  		@elseif(unserialize($vehicule->hGomme)[0]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[0]>=$vehicule->limiteHg+0.4)
		                  		<div class="col-3"></div>
		                  		<div class="col-3 tableau" style="background: orange">				
		                  			{{unserialize($vehicule->hGomme)[0]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[0]}} bar<br>
		                  			@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[0])
		                  					{{$reference->reference}}
		                  					@if($reference->quantite==0)
		                  					<br>(hors du stock)
		                  					@else
		                  					<br>MMP
		                  					@endif
		                  				@endif
		                  			@endforeach
		                  		</div>
		                  		@else
		                  		<div class="col-3"></div>
		                  		<div class="col-3 tableau" style="background: green">
									{{unserialize($vehicule->hGomme)[0]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[0]}} bar<br>
		                  			@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[0])
		                  					{{$reference->reference}}
		                  					@if($reference->quantite==0)
		                  					<br>(hors du stock)
		                  					@else
		                  					<br>MMP
		                  					@endif
		                  				@endif
		                  			@endforeach
		                  		</div>
		                  		@endif
		                  		@if(unserialize($vehicule->hGomme)[1]<$vehicule->limiteHg+0.4)
		                  		<div class="col-3 tableau" style="background: red">				
		                  			{{unserialize($vehicule->hGomme)[1]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[1]}} bar<br>
		                  			@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[1])
		                  					{{$reference->reference}}
		                  					@if($reference->quantite==0)
		                  					<br>(hors du stock)
		                  					@else
		                  					<br>MMP
		                  					@endif
		                  				@endif
		                  			@endforeach
		                  		</div>
		                  		<div class="col-3"></div>
		                  		@elseif(unserialize($vehicule->hGomme)[1]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[1]>=$vehicule->limiteHg+0.4)
		                  		<div class="col-3 tableau" style="background: orange">				
		                  			{{unserialize($vehicule->hGomme)[1]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[1]}} bar<br>
		                  			@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[1])
		                  					{{$reference->reference}}
		                  					@if($reference->quantite==0)
		                  					<br>(hors du stock)
		                  					@else
		                  					<br>MMP
		                  					@endif
		                  				@endif
		                  			@endforeach
		                  		</div>
		                  		<div class="col-3"></div>
		                  		@else
		                  		<div class="col-3 tableau" style="background: green">										{{unserialize($vehicule->hGomme)[1]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[1]}} bar<br>
		                  			@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[1])
		                  					{{$reference->reference}}
		                  					@if($reference->quantite==0)
		                  					<br>(hors du stock)
		                  					@else
		                  					<br>MMP
		                  					@endif
		                  				@endif
		                  			@endforeach
		                  		</div>
		                  		<div class="col-3"></div>
		                  		@endif
		                  	</div>
		                  	<div class="row" style="width: 100%;">
		                  		@if(isset(unserialize($vehicule->etatPneu)[4]))
			                 		@if(unserialize($vehicule->hGomme)[4]<$vehicule->limiteHg+0.4)
			                  	<div class="col-3 tableau" style="background: red">				
			                  			{{unserialize($vehicule->hGomme)[4]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[4]}} bar<br>
		                  				@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[4])
		                  					{{$reference->reference}}
		                  					@if($reference->quantite==0)
		                  					<br>(hors du stock)
		                  					@else
		                  					<br>MMP
		                  					@endif
		                  				@endif
		                  			@endforeach
			                  	</div>
			                  		@elseif(unserialize($vehicule->hGomme)[4]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[4]>=$vehicule->limiteHg+0.4)
		                  		<div class="col-3 tableau" style="background: orange">				
		                  			{{unserialize($vehicule->hGomme)[4]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[4]}} bar<br>
		                  			@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[4])
		                  					{{$reference->reference}}
		                  					@if($reference->quantite==0)
		                  					<br>(hors du stock)
		                  					@else
		                  					<br>MMP
		                  					@endif
		                  				@endif
		                  			@endforeach
		                  		</div>
			                  		@else
			                  		<div class="col-3 tableau" style="background: green">									{{unserialize($vehicule->hGomme)[4]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[4]}}bar<br>
		                  				@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[4])
		                  					{{$reference->reference}}
		                  					@if($reference->quantite==0)
		                  					<br>(hors du stock)
		                  					@else
		                  					<br>MMP
		                  					@endif
		                  				@endif
		                  			@endforeach
			                  		</div>
			                  		@endif
			                  	@else
			                  		<div class="col-3"></div> 
		                  		@endif
		                  		@if(unserialize($vehicule->hGomme)[2]<$vehicule->limiteHg+0.4)
		                  		<div class="col-3 tableau" style="background: red">				
		                  			{{unserialize($vehicule->hGomme)[2]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[2]}} bar<br>
		                  			@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[2])
		                  					{{$reference->reference}}
		                  					@if($reference->quantite==0)
		                  					<br>(hors du stock)
		                  					@else
		                  					<br>MMP
		                  					@endif
		                  				@endif
		                  			@endforeach
		                  		</div>
		                  		@elseif(unserialize($vehicule->hGomme)[2]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[2]>=$vehicule->limiteHg+0.4)
		                  		<div class="col-3 tableau" style="background: orange">				
		                  			{{unserialize($vehicule->hGomme)[2]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[2]}} bar<br>
		                  			@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[2])
		                  					{{$reference->reference}}
		                  					@if($reference->quantite==0)
		                  					<br>(hors du stock)
		                  					@else
		                  					<br>MMP
		                  					@endif
		                  				@endif
		                  			@endforeach
		                  		</div>
		                  		@else
		                  		<div class="col-3 tableau" style="background: green">										{{unserialize($vehicule->hGomme)[2]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[2]}} bar<br>
		                  			@foreach($references as $reference)
		                  			@if($reference->id==unserialize($vehicule->refPneus)[2])
		                  				{{$reference->reference}}
		                  				@if($reference->quantite==0)
		                  					<br>(hors du stock)
		                  					@else
		                  					<br>MMP
		                  					@endif
		                  			@endif
		                  			@endforeach
		                  		</div>
		                  		@endif
		                  		@if(unserialize($vehicule->hGomme)[3]<$vehicule->limiteHg+0.4)
		                  		<div class="col-3 tableau" style="background: red">				
		                  			{{unserialize($vehicule->hGomme)[3]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[3]}} bar<br>
		                  			@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[3])
		                  					{{$reference->reference}}
		                  					@if($reference->quantite==0)
		                  					<br>(hors du stock)
		                  					@else
		                  					<br>MMP
		                  					@endif
		                  				@endif
		                  			@endforeach
		                  		</div>
		                  		@elseif(unserialize($vehicule->hGomme)[3]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[3]>=$vehicule->limiteHg+0.4)
		                  		<div class="col-3 tableau" style="background: orange">				
		                  			{{unserialize($vehicule->hGomme)[3]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[3]}} bar<br>
		                  			@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[3])
		                  					{{$reference->reference}}
		                  					@if($reference->quantite==0)
		                  					<br>(hors du stock)
		                  					@else
		                  					<br>MMP
		                  					@endif
		                  				@endif
		                  			@endforeach
		                  		</div>
		                  		@else
		                  		<div class="col-3 tableau" style="background: green">										{{unserialize($vehicule->hGomme)[3]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[3]}} bar<br>
		                  			@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[3])
		                  					{{$reference->reference}}
		                  					@if($reference->quantite==0)
		                  					<br>(hors du stock)
		                  					@else
		                  					<br>MMP
		                  					@endif
		                  				@endif
		                  			@endforeach
		                  		</div>
		                  		@endif
		                  		@if(isset(unserialize($vehicule->etatPneu)[5]))
			                 		@if(unserialize($vehicule->hGomme)[5]<$vehicule->limiteHg+0.4)
			                  		<div class="col-3 tableau" style="background: red">				
			                  			{{unserialize($vehicule->hGomme)[5]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[5]}} bar<br>
		                  				@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[5])
		                  					{{$reference->reference}}
		                  					@if($reference->quantite==0)
		                  					<br>(hors du stock)
		                  					@else
		                  					<br>MMP
		                  					@endif
		                  				@endif
		                  			@endforeach
			                  		</div>
			                  	@elseif(unserialize($vehicule->hGomme)[5]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[5]>=$vehicule->limiteHg+0.4)
		                  		<div class="col-3 tableau" style="background: orange">				
		                  			{{unserialize($vehicule->hGomme)[5]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[5]}} bar<br>
		                  			@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[5])
		                  					{{$reference->reference}}
		                  					@if($reference->quantite==0)
		                  					<br>(hors du stock)
		                  					@else
		                  					<br>MMP
		                  					@endif
		                  				@endif
		                  			@endforeach
		                  		</div>
			                  	@else
			                  		<div class="col-3 tableau" style="background: green">									{{unserialize($vehicule->hGomme)[5]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[5]}} bar<br>
		                  				@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[5])
		                  					{{$reference->reference}}
		                  					@if($reference->quantite==0)
		                  					<br>(hors du stock)
		                  					@else
		                  					<br>MMP
		                  					@endif
		                  				@endif
		                  			@endforeach
			                  		</div>
			                  		@endif
		                  		@endif
		                  	</div>
		                  	@endif
  							</span>
		                  	@if($vehicule->etatPneu)
		                  	<div class="row">
		                  		@if(unserialize($vehicule->hGomme)[0]<$vehicule->limiteHg+0.4)
		                  		<div class="col-3"></div>
		                  		<div class="col-3 tableau" style="background: red">				
		                  		{{unserialize($vehicule->hGomme)[0]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[0]}} bar
		                  		</div>
		                  		@elseif(unserialize($vehicule->hGomme)[0]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[0]>=$vehicule->limiteHg+0.4)
		                  		<div class="col-3"></div>
		                  		<div class="col-3 tableau" style="background: orange">				
		                  		{{unserialize($vehicule->hGomme)[0]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[0]}} bar
		                  		</div>
		                  		@else
		                  		<div class="col-3"></div>
		                  		<div class="col-3 tableau" style="background: green">	
		                  			{{unserialize($vehicule->hGomme)[0]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[0]}} bar
		                  		</div>
		                  		@endif
		                  		@if(unserialize($vehicule->hGomme)[1]<$vehicule->limiteHg+0.4)
		                  		<div class="col-3 tableau" style="background: red">				
		                  		{{unserialize($vehicule->hGomme)[1]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[1]}} bar
		                  		</div>
		                  		<div class="col-3"></div>
		                  		@elseif(unserialize($vehicule->hGomme)[1]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[1]>=$vehicule->limiteHg+0.4)
		                  		<div class="col-3 tableau" style="background: orange">				
		                  		{{unserialize($vehicule->hGomme)[1]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[1]}} bar
		                  		</div>
		                  		<div class="col-3"></div>
		                  		@else
		                  		<div class="col-3 tableau" style="background: green">									{{unserialize($vehicule->hGomme)[1]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[1]}} bar
		                  		</div>
		                  		<div class="col-3"></div>
		                  		@endif
		                  	</div>
		                  	<div class="row">
		                  		@if(isset(unserialize($vehicule->etatPneu)[4]))
			                 		@if(unserialize($vehicule->hGomme)[4]<$vehicule->limiteHg+0.4)
			                  		<div class="col-3 tableau" style="background: red">				
			                  		{{unserialize($vehicule->hGomme)[4]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[4]}} bar
			                  		</div>
			                  		@elseif(unserialize($vehicule->hGomme)[4]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[4]>=$vehicule->limiteHg+0.4)
			                  		<div class="col-3 tableau" style="background: orange">				
			                  		{{unserialize($vehicule->hGomme)[4]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[4]}} bar
			                  		</div>
			                  		@else
			                  		<div class="col-3 tableau" style="background: green">									{{unserialize($vehicule->hGomme)[4]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[4]}} bar
			                  		</div>
			                  		@endif
			                  	@else
			                  		<div class="col-3"></div> 
		                  		@endif
		                  		@if(unserialize($vehicule->hGomme)[2]<$vehicule->limiteHg+0.4)
		                  		<div class="col-3 tableau" style="background: red">				
		                  		{{unserialize($vehicule->hGomme)[2]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[2]}} bar
		                  		</div>
		                  		@elseif(unserialize($vehicule->hGomme)[2]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[2]>=$vehicule->limiteHg+0.4)
		                  		<div class="col-3 tableau" style="background: orange">				
		                  		{{unserialize($vehicule->hGomme)[2]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[2]}} bar
		                  		</div>
		                  		@else
		                  		<div class="col-3 tableau" style="background: green">									{{unserialize($vehicule->hGomme)[2]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[2]}} bar
		                  		</div>
		                  		@endif
		                  		@if(unserialize($vehicule->hGomme)[3]<$vehicule->limiteHg+0.4)
		                  		<div class="col-3 tableau" style="background: red">				
		                  		{{unserialize($vehicule->hGomme)[3]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[3]}} bar
		                  		</div>
		                  		@elseif(unserialize($vehicule->hGomme)[3]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[3]>=$vehicule->limiteHg+0.4)
		                  		<div class="col-3 tableau" style="background: orange">				
		                  		{{unserialize($vehicule->hGomme)[3]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[3]}} bar
		                  		</div>
		                  		@else
		                  		<div class="col-3 tableau" style="background: green">									{{unserialize($vehicule->hGomme)[3]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[3]}} bar
		                  		</div>
		                  		@endif
		                  		@if(isset(unserialize($vehicule->etatPneu)[5]))
			                 		@if(unserialize($vehicule->hGomme)[5]<$vehicule->limiteHg+0.4)
			                  		<div class="col-3 tableau" style="background: red">				
			                  		{{unserialize($vehicule->hGomme)[5]}} mm/
			                  			{{unserialize($vehicule->etatPneu)[5]}} bar
			                  		</div>
			                  		@elseif(unserialize($vehicule->hGomme)[5]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[5]>=$vehicule->limiteHg+0.4)
			                  		<div class="col-3 tableau" style="background: orange">				
			                  		{{unserialize($vehicule->hGomme)[5]}} mm/
			                  			{{unserialize($vehicule->etatPneu)[5]}} bar
			                  		</div>
			                  		@else
			                  		<div class="col-3 tableau" style="background: green">									{{unserialize($vehicule->hGomme)[5]}} mm/
			                  			{{unserialize($vehicule->etatPneu)[5]}} bar
			                  		</div>
			                  		@endif
		                  		@endif
		                  	</div>
		                  	@endif
		                </div>
		                  </td>
		                  <!-- <td>
  								@if($vehicule->etatPneu)
		                  	<div class="row" style="width: 8cm;">
		                  		@if(unserialize($vehicule->etatPneu)[0]<3)
		                  		<div class="col-3"></div>
		                  		<div class="col-3 tableau" style="background: red">				
		                  			{{unserialize($vehicule->etatPneu)[0]}} bar
		                  		</div>
		                  		@else
		                  		<div class="col-3"></div>
		                  		<div class="col-3 tableau" style="background: green">
		                  			{{unserialize($vehicule->etatPneu)[0]}} bar
		                  		</div>
		                  		@endif
		                  		@if(unserialize($vehicule->etatPneu)[1]<3)
		                  		<div class="col-3 tableau" style="background: red">				
		                  			{{unserialize($vehicule->etatPneu)[1]}} bar
		                  		</div>
		                  			<div class="col-3"></div>
		                  		@else
		                  		<div class="col-3 tableau" style="background: green">
		                  			{{unserialize($vehicule->etatPneu)[1]}} bar
		                  		</div>
		                  		<div class="col-3"></div>
		                  		@endif
		                  	</div>
		                  	<div class="row" style="width: 8cm;">
		                  		@if(isset(unserialize($vehicule->etatPneu)[4]))
			                 		@if(unserialize($vehicule->etatPneu)[4]<3)
			                  		<div class="col-3 tableau" style="background: red">				
		                  				{{unserialize($vehicule->etatPneu)[4]}} bar
			                  		</div>
			                  		@else
			                  		<div class="col-3 tableau" style="background: green">	
		                  				{{unserialize($vehicule->etatPneu)[4]}} bar
			                  		</div>
			                  		@endif
			                  	@else
			                  		<div class="col-3"></div> 
		                  		@endif
		                  		@if(unserialize($vehicule->etatPneu)[2]<3)
		                  		<div class="col-3 tableau" style="background: red">				
		                  			{{unserialize($vehicule->etatPneu)[2]}} bar
		                  		</div>
		                  		@else
		                  		<div class="col-3 tableau" style="background: green">		
		                  				{{unserialize($vehicule->etatPneu)[2]}} bar
		                  		</div>
		                  		@endif
		                  		@if(unserialize($vehicule->etatPneu)[3]<3)
		                  		<div class="col-3 tableau" style="background: red">	
		                  			{{unserialize($vehicule->etatPneu)[3]}} bar
		                  		</div>
		                  		@else
		                  		<div class="col-3 tableau" style="background: green">
		                  			{{unserialize($vehicule->etatPneu)[3]}} bar
		                  		</div>
		                  		@endif
		                  		@if(isset(unserialize($vehicule->etatPneu)[5]))
			                 		@if(unserialize($vehicule->etatPneu)[5]<3)
			                  		<div class="col-3 tableau" style="background: red">				
		                  				{{unserialize($vehicule->etatPneu)[5]}} bar
			                  		</div>
			                  		@else
			                  		<div class="col-3 tableau" style="background: green">	
		                  				{{unserialize($vehicule->etatPneu)[5]}} bar
			                  		</div>
			                  		@endif
		                  		@endif
		                  	</div>
		                  	@endif
		                  </td> -->
		                  <td><span hidden>{{$vehicule->kilometrage/1000000}}</span>
		                  	{{$vehicule->kilometrage}} km ({{date('d/m/Y',strtotime($vehicule->control))}})</td>
		                  <td>
		                  	<span hidden>
		                  	{{(((strtotime($vehicule->dpermutation)+365*84600)-strtotime(date('Y-m-d')))/84600)/100}}</span>
		                  	@if(count(unserialize($vehicule->hGomme))==4)
		                  @if($vehicule->permutation>0)
		                  	<span hidden>{{$permutation=0}}</span>
		                  	Dans 
		                  @if(isset(unserialize($vehicule->t1)[1]) and isset(unserialize($vehicule->t2)[1]))
                    		@if(count(unserialize($vehicule->t2))==8)
	                        <span hidden>
	                          {{$diff=(strtotime(unserialize($vehicule->t2)[7])-strtotime(unserialize($vehicule->t1)[7]))/86400}}
	                          @if($diff==0){{$diff=1}}@endif
	                        </span>
                       			{{ round($vehicule->permutation-((unserialize($vehicule->t2)[6]-unserialize($vehicule->t1)[6])/$diff*(strtotime(date('Y-m-d'))-strtotime(unserialize($vehicule->t2)[7]))/86400))}} km
                       		@else
		                       <span hidden>
		                          {{$diff=(strtotime(unserialize($vehicule->t2)[5])-strtotime(unserialize($vehicule->t1)[5]))/86400}}
		                          @if($diff==0){{$diff=1}}@endif
		                        </span>
                       			{{ round($vehicule->permutation-((unserialize($vehicule->t2)[4]-unserialize($vehicule->t1)[4])/$diff*(strtotime(date('Y-m-d'))-strtotime(unserialize($vehicule->t2)[5]))/86400))}} km
                       		@endif
                       	  @else
	                          <span hidden>
	                            @if(count(unserialize($vehicule->t1))==8)
	                            {{$diff=(strtotime(unserialize($vehicule->t1)[7])-strtotime($vehicule->dateC))/86400}}
	                            @if($diff==0)
	                            {{$diff=1}}
	                            @endif
	                            {{$kj=unserialize($vehicule->t1)[6]/$diff}}

	                            @elseif(count(unserialize($vehicule->t1))==6)
	                            {{$isa=(strtotime(unserialize($vehicule->t1)[5])-strtotime($vehicule->dateC))/86400}}
	                             @if($isa==0)
	                            {{$isa=1}}
	                            @endif
	                            {{$kj=unserialize($vehicule->t1)[4]/$isa}}
	                            @endif
	                          </span>
                          		{{round($vehicule->permutation-$kj*(strtotime(date('Y-m-d'))-strtotime($vehicule->control))/86400)}} km 
                      		 @endif
		                  	<!--Farany-->
		                  	 
		                  	@else
		                  	Dans 0 km
		                  	<span hidden>{{$permutation=1}}</span>
		                  @endif
		                  ou {{round(((strtotime($vehicule->dpermutation)+365*84600)-strtotime(date('Y-m-d')))/84600)}} jours
		                  @else
		                  aucune
		                  @endif
		                  </td>
		                  <td>
		                  	<span hidden>{{$countP=($vehicule->limitePression-(strtotime(date('Y-m-d'))-strtotime($vehicule->dpression))/86400)/100}}     </span>
		                  	@if($countP=$vehicule->limitePression-(strtotime(date('Y-m-d'))-strtotime($vehicule->dpression))/86400<0)
		                  	Passés de
		                  	@else
		                  	Dans
		                  	@endif
		                  	{{abs(round($countP=$vehicule->limitePression-(strtotime(date('Y-m-d'))-strtotime($vehicule->dpression))/86400))}} jours
		                  </td>
		                  <td style="text-align: center">
		                  	<span style="display: none;">{{$a=0}}{{$o=0}}{{$ok=0}}</span>
		                  	@foreach($RendezVous as $rdv)
		                  		@if($rdv->vehicule_id==$vehicule->id and $rdv->finished==0 and $rdv->accepted==2 and $rdv->date>=date('Y-m-d'))
		                  		<span style="display: none;">{{$rdvdate=$rdv->date}}
		                  		{{$rdvheure=$rdv->heure}}
		                  			{{$a=1}}{{$o=1}}{{$ok=1}}</span>
		                  		@endif
			                @endforeach
			                
		                  		@if($a==1)
		                  		<button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="right" title="Intervention prévue le {{date('d/m/Y',strtotime($rdvdate))}} à {{date('H:i',strtotime($rdvheure))}}">
									</button>
		                  		@endif
		                  	@if($a!=1 and $vehicule->etatPneu)
			                  	<span style="display: none;">{{$a=0}}</span>
			                  		@if(($vehicule->limitePression-(strtotime(date('Y-m-d'))-strtotime($vehicule->dpression))/86400)<15)
			                  			<button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="right" title="Intervention à faire">
										</button>
			                  			<span style="display: none;">{{$a=1}}{{$o=0}}</span>
										@endif
										@if($a!=1)
										@for($i=0;$i<count(unserialize($vehicule->hGomme));$i++)
											@if(unserialize($vehicule->hGomme)[$i]<$vehicule->limiteHg+0.4)
												
					                  			<span style="display: none;">{{$a=1}}{{$o=0}}</span>
											@endif
										@endfor
											@if($a==1)
											<button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="right" title="Intervention à faire">
												</button>
											@endif
										@endif
							@if($a==0 and $vehicule->etatPneu)
		                  			<button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="right" title="Tout ok">
									</button>
									<span hidden>{{$o=1}}</span>
							@endif
							@endif
		                  	</td>
		                  	@if(Auth::user()->role!="conducteur")
		                  	@if(Auth::user()->role=='superadmin')
		                  	<td>{{$vehicule->stationnement}}</td>
		                  	@endif
		                  	<!-- <TD>{{$vehicule->nomH}}</TD>
			                  <td>{{$vehicule->phoneH}} / {{$vehicule->emailH}}</td>
			                  <td>{{date('d/m/Y',strtotime($vehicule->dateC))}}</td> -->
		                  <td>{{date('d/m/Y',strtotime($vehicule->derniereMaintenance))}}</td>
		                  	<span hidden>@if(isset(unserialize($vehicule->t1)[1]) and isset(unserialize($vehicule->t2)[1]))
		                 
		                 @if(count(unserialize($vehicule->t2))==8)
                        <span hidden>
                          {{$diff=(strtotime(unserialize($vehicule->t2)[7])-strtotime(unserialize($vehicule->t1)[7]))/86400}}
                          @if($diff==0){{$diff=1}}@endif
                        </span>
                       {{ $result=round((unserialize($vehicule->t2)[6]-unserialize($vehicule->t1)[6])/$diff,2)}} km/jour
                       @else
                       <span hidden>
                          {{$diff=(strtotime(unserialize($vehicule->t2)[5])-strtotime(unserialize($vehicule->t1)[5]))/86400}}
                          @if($diff==0){{$diff=1}}@endif
                        </span>
                       {{ $result=round((unserialize($vehicule->t2)[4]-unserialize($vehicule->t1)[4])/$diff,2)}} km/jour
                       @endif
                       @else
                       		<span hidden>
                            @if(count(unserialize($vehicule->t1))==8)
                            {{$isa=(strtotime(unserialize($vehicule->t1)[7])-strtotime($vehicule->dateC))/86400}}
                            @if($isa==0)
	                            {{$isa=1}}
	                            @endif
                            {{$kj=unserialize($vehicule->t1)[6]/$isa}}

                            @elseif(count(unserialize($vehicule->t1))==6)
                            {{$isa=(strtotime(unserialize($vehicule->t1)[5])-strtotime($vehicule->dateC))/86400}}
                            @if($isa==0)
	                            {{$isa=1}}
	                            @endif
                            {{$kj=unserialize($vehicule->t1)[4]/$isa}}
                            @endif
                          </span>
                          {{$result=round($kj,2)}}
                       @endif
                   </span>
		                  <td>
		                  	<span hidden>{{$result/1000}}	</span>
		                  	{{$result}}		km / jour
		                  </td>
                        @if(isset(unserialize($vehicule->t1)[1]) and isset(unserialize($vehicule->t2)[1]))
                     
                     @if(count(unserialize($vehicule->t2))==8)
                        <span hidden>
                          {{$diff=(strtotime(unserialize($vehicule->t2)[7])-strtotime(unserialize($vehicule->t1)[7]))/86400}}
                          @if($diff==0){{$diff=1}}@endif
                       {{ $ek=round($vehicule->kilometrage+((unserialize($vehicule->t2)[6]-unserialize($vehicule->t1)[6])/$diff*(strtotime(date('Y-m-d'))-strtotime(unserialize($vehicule->t2)[7]))/86400))}} 
                        </span>
                       @else
                       <span hidden>
                          {{$diff=(strtotime(unserialize($vehicule->t2)[5])-strtotime(unserialize($vehicule->t1)[5]))/86400}}
                          @if($diff==0){{$diff=1}}@endif
                       {{ $ek=round($vehicule->kilometrage+((unserialize($vehicule->t2)[4]-unserialize($vehicule->t1)[4])/$diff*(strtotime(date('Y-m-d'))-strtotime(unserialize($vehicule->t2)[5]))/86400))}}
                        </span>
                       @endif
                       @else
                          <span hidden>
                            @if(count(unserialize($vehicule->t1))==8)
                            {{$diff=(strtotime(unserialize($vehicule->t1)[7])-strtotime($vehicule->dateC))/86400}}
                            @if($diff==0)
	                            {{$diff=1}}
	                            @endif
                            {{$kj=unserialize($vehicule->t1)[6]/$diff}}

                            @elseif(count(unserialize($vehicule->t1))==6)
                            {{$isa=(strtotime(unserialize($vehicule->t1)[5])-strtotime($vehicule->dateC))/86400}}
                            @if($isa==0)
	                            {{$isa=1}}
	                            @endif
                            {{$kj=unserialize($vehicule->t1)[4]/$isa}}
                            @endif
                          {{$ek=round($vehicule->kilometrage+$kj*(strtotime(date('Y-m-d'))-strtotime($vehicule->control))/86400)}}
                          </span>
                       @endif
                      <td>
                      	<span hidden>{{$ek/1000000}}</span>
                      	{{$ek}} km
                      </td>
		                  <td>{{$vehicule->observations}}</td>
		                  <td>
		                  	<a href="/storage/{{$vehicule->imageV}}">
		                  		<img src="/storage/{{$vehicule->imageV}}" width="200" height="100" alt="{{$vehicule->imageV}}">
		                  	</a>
		                  	<a href="/storage/{{$vehicule->imageV2}}">
		                  		<img src="/storage/{{$vehicule->imageV2}}" width="200" height="100" alt="{{$vehicule->imageV2}}">
		                  	</a>
		                  </td>
                   		@if(Auth::user()->role=="superadmin")
		                  <td>
		                  	 <a  type="button" class="btn btn-danger" data-toggle="modal" data-target="#alert{{$vehicule->id}}">
		                  	 	Alerter
							 </a>
		                  	<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exa{{$vehicule->id}}" data-toggle="tooltip" data-placement="bottom" title="Modifier">
	                          Modifier
	                        </button>
	                         <a type="button" class="btn btn-info" href="/historiques/{{$vehicule->id}}">
	                          Historiques des interventions
	                        </a>
	                        <a type="button" class="btn btn-secondary" href="/utilisateurs/{{$vehicule->id}}">
	                          Créer utilisateur
	                        </a>


                          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#suprimer{{$vehicule->id}}">
                            Supprimer
                          </button>

                         

		                      </td>
		                      @endif 
		                      @endif

		                      	@if(Auth::user()->role=="responsable" or Auth::user()->role=="conducteur" or Auth::user()->role=='PDG')
		                      <td>
		                      <a type="button" class="btn btn-info" href="/rendezVous/{{$vehicule->id}}">
	                          Prendre un rendez-vous
	                        </a>
		                      </td>
		                      @endif

		                </tr>	
		            @endforeach															
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
      </div>
@endsection
@section('script')
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    /*$('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });*/
  });
</script>
   

<script type="text/javascript">
  var init=document.querySelectorAll('.init')
  for(i=0;i<init.length;i++)
  {
    init[i].addEventListener('keyup',function(){
      this.previousElementSibling.value=this.value
    })
  }
</script>


@endsection
