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
  right: -20%;
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
	<div class="form-group col-12">
		<form method="POST" action="/rechercher">
			@csrf
			<input type="text" name="immatriculation" class="form-control" placeholder="Immatriculation">
			<button class="btn btn-primary">Rechercher</button>
		</form>
	</div>
        @foreach($vehicules as $vehicule)
            <div class="card col-6 ">
            	<div class="card-header">
	              <h3 class="card-title">
	              	{{$vehicule->immatriculation}}
	              </h3>
            	</div>
            <div class="card-body">
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
						        	<textarea class="form-control" name="texte" placeholder="Si vous mettez rien, on envoie un message par défaut"></textarea>
						        	<button class="btn btn-primary">Alerter</button>
						        </form>
						      </div>
						    </div>
						  </div>
						</div>
                	<div class="modal fade" id="exa{{$vehicule->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modification</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                          <form method="post" action="{{Route('vehicules.modifRapide',$vehicule->id)}}">
                                              @csrf
                                              @method('PUT')
                                              <div class="form-group row">
                                                  <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Immatriculation') }}</label>

                                                  <div class="col-md-6">
                                                      <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="immatriculation" value="{{$vehicule->immatriculation}}" required autocomplete="name" autofocus>

                                                      @error('name')
                                                          <span class="invalid-feedback" role="alert">
                                                              <strong>{{ $message }}</strong>
                                                          </span>
                                                      @enderror
                                                  </div>
                                              </div>

                                              <div class="form-group row">
                                                  <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Model') }}</label>

                                                  <div class="col-md-6">
                                                      <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="model" value="{{$vehicule->model}}" required autocomplete="email">

                                                      @error('email')
                                                          <span class="invalid-feedback" role="alert">
                                                              <strong>{{ $message }}</strong>
                                                          </span>
                                                      @enderror
                                                  </div>
                                              </div>

                                              <div class="form-group row">
                                                  <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Marque') }}</label>

                                                  <div class="col-md-6">
                                                      <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="marque" value="{{$vehicule->marque}}" required>

                                                      @error('phone')
                                                          <span class="invalid-feedback" role="alert">
                                                              <strong>{{ $message }}</strong>
                                                          </span>
                                                      @enderror
                                                  </div>
                                              </div>
                                              <div class="form-group row"  id="cConducteur">
                                                  <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Entreprise') }}</label>
                                                  <div class="col-md-6">
                                                      <select class="form-control" name="entreprise" id="choixE">
                                                          @foreach($entreprises as $entreprise)
                                                          @if($vehicule->entreprise==$entreprise->entreprise)
                                                          <option value="{{$entreprise->id}}" selected>{{$entreprise->entreprise}}</option>
                                                          @else
                                                          <option value="{{$entreprise->id}}">{{$entreprise->entreprise}}</option>
                                                          @endif
                                                          @endforeach
                                                      </select>
                                              </div>
                                              </div>
                                              <div class="form-group row mb-0">
                                                  <div class="col-md-2 offset-md-9">
                                                      <button type="submit" class="btn btn-primary">
                                                          {{ __('Modifier') }}
                                                      </button>
                                                  </div>
                                              </div>
                                          </form>
                              </div>
                            </div>
                          </div>
                        </div>
                    	<div>
	                		  <span hidden>{{$permutation=false}}</span>
			                  <b>Model : </b>{{$vehicule->model}}<br>
			                  <b>Marque : </b>{{$vehicule->marque}}<br>
			                  <b>Entreprise : </b>{{$vehicule->entreprise}}<br>
			                  <b>Responsable : </b>{{$vehicule->nomH}}<br>
			                  <b>Contact : </b>{{$vehicule->phoneH}} / {{$vehicule->emailH}}<br>
			                  <b>Date de mise en circulation : </b>  {{date('d/m/Y',strtotime($vehicule->dateC))}}<br>
			                  <b>Date de dernière maintenance : </b>  {{date('d/m/Y',strtotime($vehicule->derniereMaintenance))}}<br>
		                </div>
						<div class="ty" style="width: 12cm;">
							@if($vehicule->etatPneu)
		                  <b>Etat pneumatique :</b>
		                  @endif
  							<span class="tytext">
  								@if($vehicule->etatPneu)
		                  	<div class="row" style="width: 16cm;">
		                  		@if(unserialize($vehicule->etatPneu)[0]<3)
		                  		<div class="col-3"></div>
		                  		<div class="col-3 tableau" style="background: red">				
		                  			{{unserialize($vehicule->hGomme)[0]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[0]}} bar<br>
		                  			@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[0])
		                  					{{$reference->reference}}
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
		                  				@endif
		                  			@endforeach
		                  		</div>
		                  		@endif
		                  		@if(unserialize($vehicule->etatPneu)[1]<3)
		                  		<div class="col-3 tableau" style="background: red">				
		                  			{{unserialize($vehicule->hGomme)[1]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[1]}} bar<br>
		                  			@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[1])
		                  					{{$reference->reference}}
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
		                  				@endif
		                  			@endforeach
		                  		</div>
		                  		<div class="col-3"></div>
		                  		@endif
		                  	</div>
		                  	<div class="row" style="width: 16cm;">
		                  		@if(isset(unserialize($vehicule->etatPneu)[4]))
			                 		@if(unserialize($vehicule->etatPneu)[4]<3)
			                  		<div class="col-3 tableau" style="background: red">				
			                  			{{unserialize($vehicule->hGomme)[4]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[4]}} bar<br>
		                  				@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[4])
		                  					{{$reference->reference}}
		                  				@endif
		                  			@endforeach
			                  		</div>
			                  		@else
			                  		<div class="col-3 tableau" style="background: green">									{{unserialize($vehicule->hGomme)[4]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[4]}}bar<br>
		                  				@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[4])
		                  					{{$reference->reference}}
		                  				@endif
		                  			@endforeach
			                  		</div>
			                  		@endif
			                  	@else
			                  		<div class="col-3"></div> 
		                  		@endif
		                  		@if(unserialize($vehicule->etatPneu)[2]<3)
		                  		<div class="col-3 tableau" style="background: red">				
		                  			{{unserialize($vehicule->hGomme)[2]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[2]}} bar<br>
		                  			@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[2])
		                  					{{$reference->reference}}
		                  				@endif
		                  			@endforeach
		                  		</div>
		                  		@else
		                  		<div class="col-3 tableau" style="background: green">										{{unserialize($vehicule->hGomme)[2]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[2]}} bar<br>
		                  			@foreach($references as $reference)
		                  			@if($reference->id==unserialize($vehicule->refPneus)[2])
		                  				{{$reference->reference}}
		                  			@endif
		                  			@endforeach
		                  		</div>
		                  		@endif
		                  		@if(unserialize($vehicule->etatPneu)[3]<3)
		                  		<div class="col-3 tableau" style="background: red">				
		                  			{{unserialize($vehicule->hGomme)[3]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[3]}} bar<br>
		                  			@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[3])
		                  					{{$reference->reference}}
		                  				@endif
		                  			@endforeach
		                  		</div>
		                  		@else
		                  		<div class="col-3 tableau" style="background: green">										{{unserialize($vehicule->hGomme)[3]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[3]}} bar<br>
		                  			@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[3])
		                  					{{$reference->reference}}
		                  				@endif
		                  			@endforeach
		                  		</div>
		                  		@endif
		                  		@if(isset(unserialize($vehicule->etatPneu)[5]))
			                 		@if(unserialize($vehicule->etatPneu)[5]<3)
			                  		<div class="col-3 tableau" style="background: red">				
			                  			{{unserialize($vehicule->hGomme)[5]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[5]}} bar<br>
		                  				@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[5])
		                  					{{$reference->reference}}
		                  				@endif
		                  			@endforeach
			                  		</div>
			                  		@else
			                  		<div class="col-3 tableau" style="background: green">									{{unserialize($vehicule->hGomme)[5]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[5]}} bar<br>
		                  				@foreach($references as $reference)
		                  				@if($reference->id==unserialize($vehicule->refPneus)[5])
		                  					{{$reference->reference}}
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
		                  		@if(unserialize($vehicule->etatPneu)[0]<3)
		                  		<div class="col-3"></div>
		                  		<div class="col-3 tableau" style="background: red">				
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
		                  		@if(unserialize($vehicule->etatPneu)[1]<3)
		                  		<div class="col-3 tableau" style="background: red">				
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
			                 		@if(unserialize($vehicule->etatPneu)[4]<3)
			                  		<div class="col-3 tableau" style="background: red">				
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
		                  		@if(unserialize($vehicule->etatPneu)[2]<3)
		                  		<div class="col-3 tableau" style="background: red">				
		                  		{{unserialize($vehicule->hGomme)[2]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[2]}} bar
		                  		</div>
		                  		@else
		                  		<div class="col-3 tableau" style="background: green">									{{unserialize($vehicule->hGomme)[2]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[2]}} bar
		                  		</div>
		                  		@endif
		                  		@if(unserialize($vehicule->etatPneu)[3]<3)
		                  		<div class="col-3 tableau" style="background: red">				
		                  		{{unserialize($vehicule->hGomme)[3]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[3]}} bar
		                  		</div>
		                  		@else
		                  		<div class="col-3 tableau" style="background: green">									{{unserialize($vehicule->hGomme)[3]}} mm/
		                  			{{unserialize($vehicule->etatPneu)[3]}} bar
		                  		</div>
		                  		@endif
		                  		@if(isset(unserialize($vehicule->etatPneu)[5]))
			                 		@if(unserialize($vehicule->etatPneu)[5]<3)
			                  		<div class="col-3 tableau" style="background: red">				
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
		                  @if($vehicule->kilometrage!='')
		                  <b>Kilomètrage : {{$vehicule->kilometrage}} km</b>
		                  @if(10000-$vehicule->kilometrage>0) 
		                  	<span hidden>{{$permutation=0}}</span>
		                  	(permutation dans {{10000-$vehicule->kilometrage}} km)
		                  	@else
		                  	(permutation confirmée)
		                  	<span hidden>{{$permutation=1}}</span>
		                  @endif
		                  @endif

		                  <br><b>Kilomètrage moyen : </b> 
		                 @if(isset(unserialize($vehicule->t1)[1]) and isset(unserialize($vehicule->t2)[1]))
		                 
		                 @if(count(unserialize($vehicule->t2))==8)
                        <span hidden>
                          {{$diff=(strtotime(unserialize($vehicule->t2)[7])-strtotime(unserialize($vehicule->t1)[7]))/86400}}
                          @if($diff==0){{$diff=1}}@endif
                        </span>
                       {{ (unserialize($vehicule->t2)[6]-unserialize($vehicule->t1)[6])/$diff}} km/jour
                       @else
                       <span hidden>
                          {{$diff=(strtotime(unserialize($vehicule->t2)[5])-strtotime(unserialize($vehicule->t1)[5]))/86400}}
                          @if($diff==0){{$diff=1}}@endif
                        </span>
                       {{ (unserialize($vehicule->t2)[4]-unserialize($vehicule->t1)[4])/$diff}} km/jour
                       @endif
                       @else
                       		<span hidden>
                            @if(count(unserialize($vehicule->t1))==8)
                            {{$isa=(strtotime(unserialize($vehicule->t1)[7])-strtotime($vehicule->dateC))/86400}}
                            {{$kj=unserialize($vehicule->t1)[6]/$isa}}

                            @elseif(count(unserialize($vehicule->t1))==6)
                            {{$isa=(strtotime(unserialize($vehicule->t1)[5])-strtotime($vehicule->dateC))/86400}}
                            {{$kj=unserialize($vehicule->t1)[4]/$isa}}
                            @endif
                          </span>
                          {{round($kj)}} km / jour
                       @endif













		                  <br><b> Couple serrage : </b> {{$vehicule->serrage}}	 nm
		                  <br><b> Type de permutation : </b> {{$vehicule->type}}
		                 <br> 
		                  	<span style="display: none;">{{$a=0}}{{$o=0}}{{$ok=0}}</span>
		                  	@foreach($RendezVous as $rdv)
		                  		@if($rdv->vehicule_id==$vehicule->id and $rdv->finished!=2 and $rdv->accepted==2 and $rdv->date>=date('Y-m-d'))<b>Maintenance : </b>
		                  		<button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="right" title="Intervention prévu">
									</button>
		                  			<span style="display: none;">{{$a=1}}{{$o=1}}{{$ok=1}}</span>
		                  		@endif
			                @endforeach
		                  	@if($a!=1 and $vehicule->etatPneu)
			                  	<span style="display: none;">{{$a=0}}</span>
			                  	@for($i=0;$i<count(unserialize($vehicule->etatPneu));$i++)
			                  		@if(unserialize($vehicule->hGomme)[$i]<2.8)<b>Maintenance : </b>
			                  			<button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="right" title="Pas ok">
										</button>
			                  			<span style="display: none;">{{$a=1}}{{$o=0}}</span>
										@break 2
										@endif
								@endfor
							@if($a==0 and $vehicule->etatPneu)
							<b>Maintenance : </b>
		                  			<button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="right" title="Tout ok">
									</button>
									<span hidden>{{$o=1}}</span>
							@endif
							@endif
							<br>
                   		@if(Auth::user()->role=="superadmin")
		                  	@if($ok==1 or $vehicule->alert==1)
		                  	<button type="button" class="btn btn-danger" disabled="true">
		                  	 	Alerter
							 </button>
		                  	@else
		                  	 <a  type="button" class="btn btn-danger" data-toggle="modal" data-target="#alert{{$vehicule->id}}">
		                  	 	Alerter
							 </a>
		                  	@endif
		                  	<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exa{{$vehicule->id}}" data-toggle="tooltip" data-placement="bottom" title="Modifier">
	                          <i class="fa fa-edit"></i>
	                        </button>
	                        <a type="button" class="btn btn-info" href="historiques/{{$vehicule->id}}">
	                          Interventions
	                        </a>
	                        <a type="button" class="btn btn-success" href="vehicules/delete/{{$vehicule->id}}">
	                          Supprimer
	                        </a>
		                  @endif	
		                  </div>
		                  </div>
		            @endforeach		
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
   



@endsection