@extends('dashboard.dashboard')
@section('content')
 <div class="col-md-12">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-bullhorn"></i>
                  Vos rendez-vous
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body row">
              	@foreach($rendezVous as $rdv)
	              	@if($rdv->accepted==1)
			                <div class="callout callout-danger col-6">
			                  <h5>{{$rdv->immatriculation}}       &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{{$rdv->daty}} à {{$rdv->heure}}</h5>
			                  <p>"{{$rdv->commentaire}}"</p>
			                  Rendez-vous rejeté
			                  <br>
			                  Cause : {{$rdv->raison}}
			                </div>																		
	                @endif
	                @if($rdv->accepted==0)
			                <div class="callout callout-warning col-6">
			                  <h5>{{$rdv->immatriculation}}       &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{{$rdv->daty}} à {{$rdv->heure}}</h5>
			                  <p>"{{$rdv->commentaire}}"</p>
			                  Demande en attente
			                </div>																		
	                @endif
	                @if($rdv->accepted==2)
			                <div class="callout callout-success col-6">
			                  <h5>{{$rdv->immatriculation}}       &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{{$rdv->daty}} à {{$rdv->heure}}</h5>
			                  <p>"{{$rdv->commentaire}}"</p>
			                  Rendez-vous confirmé
			                </div>																		
	                @endif
                @endforeach
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
@endsection