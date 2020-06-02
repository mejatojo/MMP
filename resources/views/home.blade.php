@extends('dashboard.dashboard')
@section('style')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

@endsection
@section('content')
    
        <div class="col-md-12">
            <div class="card">
                @if(auth::user()->role=='responsable')
                <div class="card-header"><h3>Bienvenu sur votre flotte "{{Auth::user()->entreprise}}"</h3>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modifier">
                  Modifier
                </button>
                <div class="modal fade" id="modifier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Personnaliser votre flotte</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form action="{{route('user.modifier')}}" method="post"  enctype="multipart/form-data">
                          @csrf
                          <label>Logo :</label>
                          <input type="file" name="logo" class="form-control">
                          <label>Nom de l'entreprise</label>
                          <input type="text" name="nom" class="form-control" value="{{auth::user()->entreprise}}">
                          <button class="btn btn-primary">Valider</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
                <div class="card-body">
                    <b>Nombre de vehicule inscrit :</b> 
                    @if(isset($vehiculesInscrit[0]->nombre))
                        {{$vehiculesInscrit[0]->nombre}}
                    @else
                        0
                    @endif
                    <br>
                    <b>Nombre de vehicule en maintenance :</b> 
                    @if(isset($vehiculesM[0]->nombre))
                        {{$vehiculesM[0]->nombre}}
                    @else
                        0
                    @endif<br>
                    <h4 style="text-align: center">Liste des prochains rendez-vous: </h4>
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Immatriculation</th>
                        <th>Marque & Model</th>
                        <th>Date</th>
                      </tr>
                      </thead>
                      <tbody>
                          @foreach($pRdvs as $pRdv)
                              <tr>
                                <td>{{$pRdv->immatriculation}}</td>
                                <td>{{$pRdv->marque}} ({{$pRdv->model}})</td>
                                <td>{{date('d/m/Y',strtotime($pRdv->date))}} à {{$pRdv->heure}}</td>
                              </tr>   
                          @endforeach                                                         
                      </tbody>
                    </table>
                    <h4 style="text-align: center">Cout des maintenances </h4>
                    <table id="example2" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Immatriculation</th>
                        <th>Ordre de réparation</th>
                        <th>Facture</th>
                      </tr>
                      </thead>
                      <tbody>
                          @foreach($maintenanceEffs as $maintenanceEff)
                              <tr>
                                <td>{{$maintenanceEff->immatriculation}}</td>
                                <td>{{$maintenanceEff->operations}}</td>
                                <td>
                                  @if($maintenanceEff->facture!='')
                                  <a href="/storage/{{$maintenanceEff->facture}}" type="button" class="btn btn-primary">Voir</a></td>
                                  @else
                                  Non disponible
                                  @endif
                              </tr>   
                          @endforeach                                                         
                      </tbody>
                    </table>
                </div>
                @endif
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
  });
   $(function () {
    $("#example2").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
</script>
   


@endsection
