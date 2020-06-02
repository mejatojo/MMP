@extends('dashboard.dashboard')
@section('style')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

@endsection
@section('content')
    
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                        
                  Flotte de {{$vehiculesInscrit[0]->entreprise}}
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
                        <th>Marque</th>
                        <th>Modele</th>
                        <th>Date</th>
                      </tr>
                      </thead>
                      <tbody>
                          @foreach($pRdvs as $pRdv)
                              <tr>
                                <td>{{$pRdv->immatriculation}}</td>
                                <td>{{$pRdv->marque}}</td>
                                <td> ({{$pRdv->model}})</td>
                                <td>{{date('d/m/Y',strtotime($pRdv->date))}} à {{$pRdv->heure}}</td>
                              </tr>   
                          @endforeach                                                         
                      </tbody>
                    </table>
                </div>
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
