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
              	@if(Auth::user()->role=='responsable')
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
                  <th>Immatriculation</th>
                  <th>Marque</th>
                  <th>Model</th>
                  <th>Entreprise</th>
                  <th>Etat pneumatique</th>
                  <th>Permutation</th>
                  <th>Maintenance</th>
                  <th>Stationnement</th>
                  <th>Dernière maintenance</th>
                  <th>Kilomètrage moyen</th>
                  <th>Estimation de kilomètrage :</th>
                  <th>Observations</th>
                  <th>Image</th>
                   @if(Auth::user()->role=="superadmin" or Auth::user()->role=="operateur")
                  <th>Action</th>
                  @else
                  <th>Facture</th>
                  @endif
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
                                  <a href="vehicules/delete/{{$vehicule->id}}" type="button" class="btn btn-primary">Oui</a>
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
						        	<textarea class="form-control" name="texte" placeholder="Si vous mettez rien, on envoie un message par défaut"></textarea>
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
		                  <td>{{$vehicule->entreprise}}</td>
		                  <td>

						<div class="ty" style="width: 13cm;">
  							<span class="tytext">
  								@if($vehicule->etatPneu)
		                  	<div class="row" style="width: 100%;">
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
		                  	<div class="row" style="width: 100%;">
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
		                  <td>
		                  @if(10000-$vehicule->kilometrage>0)
		                  	<span hidden>{{$permutation=0}}</span>
		                  	Dans {{10000-$vehicule->kilometrage}} km
		                  	@else
		                  	Dans 0 km
		                  	<span hidden>{{$permutation=1}}</span>
		                  @endif
		                  </td>
		                  <td style="text-align: center">
		                  	<span style="display: none;">{{$a=0}}{{$o=0}}{{$ok=0}}</span>
		                  	@foreach($RendezVous as $rdv)
		                  		@if($rdv->vehicule_id==$vehicule->id and $rdv->finished!=2 and $rdv->accepted==2 and $rdv->date>=date('Y-m-d'))
		                  		<button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="right" title="Intervention prévu">
									</button>
		                  			<span style="display: none;">{{$a=1}}{{$o=1}}{{$ok=1}}</span>
		                  		@endif
			                @endforeach
		                  	@if($a!=1 and $vehicule->etatPneu)
			                  	<span style="display: none;">{{$a=0}}</span>
			                  	@for($i=0;$i<count(unserialize($vehicule->etatPneu));$i++)
			                  		@if(unserialize($vehicule->hGomme)[$i]<2.8)
			                  			<button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="right" title="Intervention à faire">
										</button>
			                  			<span style="display: none;">{{$a=1}}{{$o=0}}</span>
										@break 2
										@endif
								@endfor
							@if($a==0 and $vehicule->etatPneu)
		                  			<button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="right" title="Tout ok">
									</button>
									<span hidden>{{$o=1}}</span>
							@endif
							@endif
		                  	</td>
		                  	<td>{{$vehicule->stationnement}}</td>
		                  	<!-- <TD>{{$vehicule->nomH}}</TD>
			                  <td>{{$vehicule->phoneH}} / {{$vehicule->emailH}}</td>
			                  <td>{{date('d/m/Y',strtotime($vehicule->dateC))}}</td> -->
		                  <td>{{date('d/m/Y',strtotime($vehicule->derniereMaintenance))}}</td>
		                  <td>
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
		                  </td>
                      <td>
                        @if(isset(unserialize($vehicule->t1)[1]) and isset(unserialize($vehicule->t2)[1]))
                     
                     @if(count(unserialize($vehicule->t2))==8)
                        <span hidden>
                          {{$diff=(strtotime(unserialize($vehicule->t2)[7])-strtotime(unserialize($vehicule->t1)[7]))/86400}}
                          @if($diff==0){{$diff=1}}@endif
                        </span>
                       {{ round($vehicule->kilometrage+((unserialize($vehicule->t2)[6]-unserialize($vehicule->t1)[6])/$diff*(strtotime(date('Y-m-d'))-strtotime(unserialize($vehicule->t2)[7]))/86400))}} km
                       @else
                       <span hidden>
                          {{$diff=(strtotime(unserialize($vehicule->t2)[5])-strtotime(unserialize($vehicule->t1)[5]))/86400}}
                          @if($diff==0){{$diff=1}}@endif
                        </span>
                       {{ round($vehicule->kilometrage+((unserialize($vehicule->t2)[4]-unserialize($vehicule->t1)[4])/$diff*(strtotime(date('Y-m-d'))-strtotime(unserialize($vehicule->t2)[5]))/86400))}} km
                       @endif
                       @else
                          <span hidden>
                            @if(count(unserialize($vehicule->t1))==8)
                            {{$diff=(strtotime(unserialize($vehicule->t1)[7])-strtotime($vehicule->dateC))/86400}}
                            {{$kj=unserialize($vehicule->t1)[6]/$isa}}

                            @elseif(count(unserialize($vehicule->t1))==6)
                            {{$isa=(strtotime(unserialize($vehicule->t1)[5])-strtotime($vehicule->dateC))/86400}}
                            {{$kj=unserialize($vehicule->t1)[4]/$isa}}
                            @endif
                          </span>
                          {{round($vehicule->kilometrage+$kj*(strtotime(date('Y-m-d'))-strtotime($vehicule->control))/86400)}} km 
                       @endif
                      </td>
		                  <td>{{$vehicule->observations}}</td>
		                  <td><img src="/storage/{{$vehicule->imageV}}" width="200" height="100">
		                  	<img src="/storage/{{$vehicule->imageV2}}" width="200" height="100"></td>
                   		@if(Auth::user()->role=="superadmin")
		                  <td>
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
	                          Historiques des interventions
	                        </a>


                          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#suprimer{{$vehicule->id}}">
                            Supprimer
                          </button>

                          <!-- Modal -->
                          
		                      @if($vehicule->factureV==null)
		                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$vehicule->id}}">
		                          Facturer
		                        </button>
		                        @else
		                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$vehicule->id}}">
		                            Modifier la facture
		                        </button>
		                        <a type="button" class="btn btn-default" href="/storage/{{$vehicule->factureV}}">Voir la facture</a>
		                        @endif
		                      </td> 
		                      @else
		                      <td>
		                      	@if($vehicule->factureV!=null)
		                      	<a type="button" class="btn btn-default" href="/storage/{{$vehicule->factureV}}">Voir</a>
		                      	@else
		                      	Non disponible
		                      	@endif
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
