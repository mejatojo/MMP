@extends('dashboard.dashboard')
@section('style')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

@endsection
@section('content')
<div class="card col-12 card-success">
            <div class="card-header">

              <h3 class="card-title">Liste interventions effectuées</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Immatriculation</th>
                  <th>Modele</th>
                  <th>marque</th>
                  <th>Contact du responsable</th>
                  <th>Entreprise</th>
                  <TH>Date</TH>
                  <th>Durée</th>
                  <th>Ordre de réparation</th>
                  @if(Auth::user()->role=='superadmin')
                  <th>Facture</th>
                  @endif
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
                                                  <label>{{ __('Ordre de réparation') }}</label>

                                                      <textarea name="operations" class="form-control">{{$maintenanceEff->operations}}</textarea>
                                                      <input type="text" name="id" value="{{$maintenanceEff->id}}" hidden>
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
                                  <a href="maintenances/destroy/{{$maintenanceEff->id}}" type="button" class="btn btn-primary">Oui</a>
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
                      <td>{{$maintenanceEff->immatriculation}} </td>
                      <td>{{$maintenanceEff->model}}</td>
                      <td>{{$maintenanceEff->marque}}</td>
                      <td>{{$maintenanceEff->email}}/{{$maintenanceEff->phone}}</td>
                      <td>{{$maintenanceEff->entreprise}}</td>
                      <td>{{date('d/m/Y',strtotime($maintenanceEff->debut))}} à 
                        {{date('H:i',strtotime($maintenanceEff->debut))}}</td>
                      <td>{{date('H:i:s',abs(strtotime($maintenanceEff->fin)-strtotime($maintenanceEff->debut)))}}</td>
                      <td>{{$maintenanceEff->operations}}</td>
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
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exa{{$maintenanceEff->id}}" data-toggle="tooltip" data-placement="bottom" title="Modifier">
                          <i class="fa fa-edit"></i>
                        </button>
                         <a  type="button" class="btn btn-danger" data-toggle="modal" data-target="#supprimer{{$maintenanceEff->id}}">
                          <i class="fa fa-trash-alt"></i>
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
    });
    
  });
</script>
   



@endsection