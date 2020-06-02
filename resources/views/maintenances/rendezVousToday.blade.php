@extends('dashboard.dashboard')
@section('style')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

@endsection
@section('content')
<div class="card col-12 card-success">
            <div class="card-header">

              <h3 class="card-title">Intervention à faire </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Immatriculation</th>
                  <th>Modele</th>
                  <th>marque</th>
                  <th>Contact du responsable</th>
                  <th>Entreprise</th>
                  <th>Commentaire</th>
                  <th>Heure</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                	@foreach($rdvs as $rdv)
		                <tr style="">
		                 <td>{{$rdv->immatriculation}} </td>
                      <td>{{$rdv->model}}</td>
                      <td>{{$rdv->marque}}</td>
		                  <td>{{$rdv->email}}/{{$rdv->phone}}</td>
                      <td>{{$rdv->entreprise}}</td>
                      <td>{{$rdv->commentaire}}</td>
                      <td>{{$rdv->heure}}</td>
                      <td>
                        @if($rdv->finished==0)
                        <a href="/begin/{{$rdv->vehicule_id}}" class="btn btn-primary">
                            Commencer
                        </a>
                        @elseif($rdv->finished==1)
                        <a href="/begin/{{$rdv->vehicule_id}}" class="btn btn-primary">
                            Continuer
                        </a>
                        @endif
                    </td>
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