@extends('dashboard.dashboard')
@section('style')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

@endsection
@section('content')
<div class="card col-12 card-success">
            <div class="card-header">

              <h3 class="card-title">Maintenance rapide (sans rendez-vous) </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Immatriculation</th>
                  <th>Modèle</th>
                  <th>marque</th>
                  <th>Contact du responsable</th>
                  <th>Entreprise</th>
                  <th>Action</th>
                </tr>
                </thead> 
                <tbody>
                  @foreach($rdvRapides as $rdvRapide)
                      <div class="modal fade" id="pression{{$rdvRapide->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Choisir la date</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div> 
                              <div class="modal-body">
                                <form action="/begin" method="post">
                                  @csrf
                                  <input type="date" name="date" value="{{date('Y-m-d')}}" class="form-control">
                                  <input type="text" name="id" value="{{$rdvRapide->id}}" hidden>

                                  <button class="btn btn-primary">Valider</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                    <tr style="">
                      <td>{{$rdvRapide->immatriculation}} </td>
                      <td>{{$rdvRapide->model}}</td>
                      <td>{{$rdvRapide->marque}}</td>
                      <td>{{$rdvRapide->phone}} / {{$rdvRapide->email}}</td>
                      <td>{{$rdvRapide->entreprise}} </td>
                      <td>
                        <button class="btn btn-default" data-toggle="modal" data-target="#pression{{$rdvRapide->id}}">Commencer</button><!-- 
                        <a href="/begin/{{$rdvRapide->id}}" class="btn btn-primary">
                            Commencer
                        </a> -->
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