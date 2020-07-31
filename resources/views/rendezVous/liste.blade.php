@extends('dashboard.dashboard')
@section('style')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">

@endsection
@section('content')
          <div class="card col-12">
            <div class="card-header card-success">

              <h3 class="card-title">Rendez-vous</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Immatriculation:</th>
                  <th>Date:</th>
                  <th>Commentaire:</th>
                  <th>Etat:</th>
                  <th>Date d'envoi</th>
                </tr>
                </thead>
                <tbody>
                 @foreach($rendezVous as $rdv)
                      <tr>
                        <td><a href="/vehicules/{{$rdv->idV}}"> {{$rdv->immatriculation}}</a></td>
                        <td>{{date('d/m/Y',strtotime($rdv->daty))}} à {{date('H:i',strtotime($rdv->heure))}}</td>
                        <td>{{$rdv->commentaire}}</td>
                        <td>
                          @if($rdv->accepted==1)
                          	<button class="btn btn-danger"></button>Refusé, cause : '{{$rdv->raison}}' 
                          	@elseif($rdv->accepted==0)
                          	<button class="btn btn-warning"></button>En attente 
                          	@elseif($rdv->accepted==2)
                          	<button class="btn btn-success"></button>Accepté 
                          @endif
                        </td>
                        <td>{{date('d/m/Y',strtotime($rdv->created_at))}} à {{date('H:i',strtotime($rdv->created_at))}}</td>
                      </tr>
                  @endforeach
                </tbody>
              </table>
                
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
      "order": [ 1, 'desc' ]
    });
  });
</script>



@endsection