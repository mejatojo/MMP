@extends('dashboard.dashboard')
@section('style')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
  <style type="text/css">
    .tableau
    {
    border: 1px solid black;
    }
   
  </style>
@endsection
@section('content')
<div class="card col-12 card-success">
            <div class="card-header">

              <h3 class="card-title">Liste des interventions effectuées</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <TH>Date :</TH>
                  <th>Immatriculation :</th>
                  <th>Modèle :</th>
                  <th>marque :</th>
                  <th>Contact du responsable :</th>
                  <th>Entreprise :</th>
                  <th>Ordre de réparation :</th>
                  <th>Images :</th>
                  <th>Actions :</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($maintenanceEffs as $maintenanceEff)
                  <div class="modal fade" id="exa{{$maintenanceEff->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modification</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                          <form method="post" action="{{Route('rendezVous.modifierRapide')}}">
                                              @csrf
                                              <div class="form-group row">
                                                <div class="col-4">
                                                  <label>{{ __('Immatriculation') }}</label>

                                                      <input type="text" name="immatriculation" class="form-control" value="{{$maintenanceEff->immatriculation}}">
                                                </div>
                                                <div class="col-4">
                                                  <label>{{ __('Model') }}</label>

                                                      <input type="text" name="model" class="form-control" value="{{$maintenanceEff->model}}">
                                                </div>
                                                <div class="col-4">
                                                  <label>{{ __('Marque') }}</label>

                                                      <input type="text" name="marque" class="form-control" value="{{$maintenanceEff->marque}}">
                                                </div>
                                              </div>
                                              <div class="form-group row">
                                                <div class="col-4">
                                                  <label>{{ __('Email') }}</label>

                                                      <input type="text" name="email" class="form-control" value="{{$maintenanceEff->email}}">
                                                </div>
                                                <div class="col-4">
                                                  <label>{{ __('Phone') }}</label>

                                                      <input type="text" name="phone" class="form-control" value="{{$maintenanceEff->phone}}">
                                                </div>
                                                <div class="col-md-4">
                                                  <label for="password">{{ __('Entreprise') }}</label>
                                                    <select class="form-control" name="conducteur" id="choixE">
                                                      @foreach($entreprises as $entreprise)
                                                        @if($maintenanceEff->entreprise==$entreprise->entreprise)
                                                          <option value="{{$entreprise->id}}" selected>{{$entreprise->entreprise}}</option>
                                                        @else
                                                          <option value="{{$entreprise->id}}">{{$entreprise->entreprise}}</option>
                                                        @endif
                                                      @endforeach
                                                    </select>
                                              </div>
                                              </div>
                                              <div class="form-group row">
                                                  <label>{{ __('Ordre de réparation') }}</label>

                                                      <textarea name="operations" class="form-control">{{$maintenanceEff->operations}}</textarea>
                                                      <input type="text" name="id" value="{{$maintenanceEff->id}}" hidden>
                                              </div>
                                              <div class="form-group row">
                                                  <label>{{ __('Observation') }}</label>

                                                      <textarea name="observations" class="form-control">{{$maintenanceEff->observations}}</textarea>
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
                  <div class="modal fade" id="supprimer{{$maintenanceEff->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  Vous voulez vraiment supprimer cet historique?
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                                  <a href="/maintenances/destroy/{{$maintenanceEff->id}}" type="button" class="btn btn-primary">Oui</a>
                                </div>
                              </div>
                            </div>
                          </div>
                    <div class="modal fade" id="exampleModal{{$maintenanceEff->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Choisir la facture</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form action="{{route('maintenances.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="text" name="id" value="{{$maintenanceEff->id}}" hidden>
                                <input type="file" name="file" class="form-control">
                                <button class="btn btn-primary">Valider</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                   
                       
                    <tr style="">
                      <td><span hidden>{{strtotime($maintenanceEff->fin)}}</span>
                        {{date('d/m/Y',strtotime($maintenanceEff->fin))}}
                      </td>
                      <td>
                        <div class="modal fade " id="cout{{$maintenanceEff->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Les coûts pneumatiques</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                      <form class="row" action="{{route('stocks.cout')}}" method="post">
                                                @csrf
                  @if($maintenanceEff->etatPneu)
                        <div class="row" style="width: 100%;">
                          <div class="col-3"></div>
                          <div class="col-3 tableau">       
                            @foreach($References as $reference)
                              @if($reference->id==unserialize($maintenanceEff->refPneus)[0])
                                {{$reference->reference}}
                                @if($reference->quantite==0)
                                <br>(hors du stock)
                                @else
                                <br>MMP
                                @endif
                            <input type="text" name="id0" value="{{$reference->id}}" hidden>
                            <input type="text" name="cout0" class="col-6" value="{{$reference->cout}}">
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3 tableau">       
                            @foreach($References as $reference)
                              @if($reference->id==unserialize($maintenanceEff->refPneus)[1])
                                {{$reference->reference}}
                                @if($reference->quantite==0)
                                <br>(hors du stock)
                                @else
                                <br>MMP
                                @endif
                            <input type="text" name="id1" value="{{$reference->id}}" hidden>
                            <input type="text" name="cout1" class="col-6" value="{{$reference->cout}}">
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3"></div>
                          
                        </div>
                        <div class="row" style="width: 100%;">
                          @if(isset(unserialize($maintenanceEff->etatPneu)[4]))
                          <div class="col-3 tableau">       
                              @foreach($References as $reference)
                              @if($reference->id==unserialize($maintenanceEff->refPneus)[4])
                                {{$reference->reference}}
                                @if($reference->quantite==0)
                                <br>(hors du stock)
                                @else
                                <br>MMP
                                @endif
                                <input type="text" name="id4" value="{{$reference->id}}" hidden>
                            <input type="text" name="cout4" class="col-6" value="{{$reference->cout}}">
                              @endif
                            @endforeach
                          </div>
                            
                          @else
                            <div class="col-3"></div> 
                          @endif
                          <div class="col-3 tableau">       
                            @foreach($References as $reference)
                              @if($reference->id==unserialize($maintenanceEff->refPneus)[2])
                                {{$reference->reference}}
                                @if($reference->quantite==0)
                                <br>(hors du stock)
                                @else
                                <br>MMP
                                @endif
                                <input type="text" name="id2" value="{{$reference->id}}" hidden>
                            <input type="text" name="cout2" class="col-6" value="{{$reference->cout}}">
                              @endif
                            @endforeach
                          </div>
                          
                          <div class="col-3 tableau">       
                            @foreach($References as $reference)
                              @if($reference->id==unserialize($maintenanceEff->refPneus)[3])
                                {{$reference->reference}}
                                @if($reference->quantite==0)
                                <br>(hors du stock)
                                @else
                                <br>MMP
                                @endif
                                <input type="text" name="id3" value="{{$reference->id}}" hidden>
                            <input type="text" name="cout3" class="col-6" value="{{$reference->cout}}">
                              @endif
                            @endforeach
                          </div>
                          @if(isset(unserialize($maintenanceEff->etatPneu)[5]))
                            <div class="col-3 tableau">       
                              @foreach($References as $reference)
                              @if($reference->id==unserialize($maintenanceEff->refPneus)[5])
                                {{$reference->reference}}
                                @if($reference->quantite==0)
                                <br>(hors du stock)
                                @else
                                <br>MMP
                                @endif
                                <input type="text" name="id5" value="{{$reference->id}}" hidden>
                            <input type="text" name="cout5" class="col-6" value="{{$reference->cout}}">
                              @endif
                            @endforeach
                            </div>
                          @endif
                        </div>
                        @endif
                        <button class="btn btn-primary col-12"> Modifier</button>
                                              </form>
                          </div>
                        </div>
                      </div>
                  </div>
                        {{$maintenanceEff->immatriculation}} 
                      </td>
                      
                      <td>{{$maintenanceEff->model}}</td>
                      <td>{{$maintenanceEff->marque}}</td>
                      <td>{{$maintenanceEff->email}}/{{$maintenanceEff->phone}}</td>
                      <td>{{$maintenanceEff->entreprise}}</td>
                      <td>{{$maintenanceEff->operations}}</td>
                      <td>
                        <a href="/storage/{{$maintenanceEff->imageIn1}}">
                          <img src="/storage/{{$maintenanceEff->imageIn1}}" width="200" height="100" alt="{{$maintenanceEff->imageIn1}}">
                        </a>
                        <a href="/storage/{{$maintenanceEff->imageIn2}}">
                          <img src="/storage/{{$maintenanceEff->imageIn2}}" width="200" height="100" alt="{{$maintenanceEff->imageIn2}}">
                        </a>
                      </td>
                      @if(Auth::user()->role=='superadmin')
                      <td>
                        @if($maintenanceEff->facture==null)
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$maintenanceEff->id}}"> 
                          Facturer
                        </button>
                        @else
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$maintenanceEff->id}}">
                            Modifier la facture
                        </button>
                        <a type="button" class="btn btn-default" href="/storage/{{$maintenanceEff->facture}}">Voir</a>
                        @endif
                        <a href="/continue/{{$maintenanceEff->id}}" class="btn btn-warning">
                            Modifier
                        </a>
                         <a  type="button" class="btn btn-danger" data-toggle="modal" data-target="#supprimer{{$maintenanceEff->id}}">
                          Supprimer
                        </a> 
                        <a  type="button" class="btn btn-secondary" data-toggle="modal" data-target="#cout{{$maintenanceEff->id}}">
                          Coût pneumatique
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
   $(function () {
    $("#example2").DataTable({
      "responsive": true,
      "autoWidth": false,
      "order": [ 0, 'desc' ]
    });
    
  });
   

</script>
   



@endsection