@extends('dashboard.dashboard')
@section('style')
 <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

@endsection
@section('content')
<div class="card col-12 card-success">
            <div class="card-header">

              <h3 class="card-title">Liste des entreprises</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Entreprises</th>
                  <th>Responsable de flotte</th>
                  <th>Nombre de véhicule</th>
                </tr>
                </thead>
                <tbody>
                	@foreach($entreprises as $entreprise)
		                <tr style="">
                      <td>
                          <a href="flotte/{{$entreprise->id}}"> 
                            {{$entreprise->entreprise}}
                          </a>
                      </td>
                      <td>{{$entreprise->name}}</td>
		                  <td>
									<a type="button" class="btn btn-default" data-toggle="modal" data-target="#a{{$entreprise->entreprise}}">
		                  		{{$entreprise->nombre}}
									</a>
<!-- Modal -->
<div class="modal fade" id="a{{$entreprise->entreprise}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">vehicules</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table  class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Vehicule</th>
                  <th>Modele</th>
                  <th>Marque</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($vehicules as $vehicule)
                  @if($vehicule->entreprise==$entreprise->entreprise)
                      <tr>
                        <td>{{$vehicule->immatriculation}}</td>
                        <td>{{$vehicule->model}}</td>
                        <td>{{$vehicule->marque}}</td>
                      </tr>
                      @endif
                  @endforeach
                </tbody>
              </table>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
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
</script>
   
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <script>
  @if(Session::has('message'))
    var type="{{Session::get('alert-type','info')}}"
     toastr.info("{{ Session::get('message') }}");
  @endif
</script>


@endsection