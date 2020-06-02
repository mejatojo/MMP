@extends('dashboard.dashboard')
@section('style')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

@endsection
@section('content')
<div class="card col-12">
            <div class="card-header card-success">

              <h3 class="card-title">Stocks</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Réferences</th>
                  <th>prix d'achat de pneu</th>
                  <th>cout de la pose</th>
                  <th> Carburant</th>
                  <th>Indication</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                	@foreach($references as $reference)
                  <div class="modal fade" id="modal{{$reference->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">{{$reference->reference}}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{Route('stat.store')}}" method="post">
                                @csrf
                                <div class="form-group">
                                  <label>Prix d'achat: </label>
                                  <input type="text" class="form-control" name="reference" value="{{$reference->id}}" hidden>
                                    <input type="text" class="form-control" name="prix" value="{{$reference->prix}}">
                                </div>
                                <div class="form-group">
                                  <label>Coût de la pose: </label>
                                    <input type="text" class="form-control" name="cout" value="{{$reference->cout}}">
                                </div>
                                <div class="form-group">
                                  <label>Prix de carburant: </label>
                                    <input type="text" class="form-control" name="gazole" value="{{$reference->gazole}}">
                                </div>
                                <div class="form-group">
                                  <label>Indice de consommation: </label>
                                    <select class="form-control" name="indication">
                                      <option value="A">A</option>
                                      <option value="B">B</option>
                                      <option value="C">C</option>
                                      <option value="E">E</option>
                                      <option value="F">F</option>
                                      <option value="G">G</option>
                                    </select>
                                </div>
                                <button class="bt btn-primary"> Valider</button>
                            </form>
                        </div>
                      </div>
                    </div>
                  </div>
		                <tr>
		                  <td>{{$reference->reference}}</td>
                      <td>{{$reference->prix}}</td>
                      <td>{{$reference->cout}}</td>
                      <td>{{$reference->gazole}}</td>
                      <td>{{$reference->indication}}</td>
                      <td> 
                        <a  type="button" class="btn btn-warning"  data-toggle="modal" data-target="#modal{{$reference->id}}">
                          <i class="fa fa-edit"></i>
                        </a>
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
  });
  $(function () {
    $("#example2").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
</script>



@endsection