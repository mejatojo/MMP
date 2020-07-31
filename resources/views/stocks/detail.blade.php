@extends('dashboard.dashboard')
@section('style')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

@endsection
@section('content')
<div class="card col-12">
            <div class="card-header card-success">

              <h3 class="card-title"> ENTREE 
                @if(isset($stockentres[0]->reference))
                {{$stockentres[0]->reference}}
                @endif 
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <a class="btn btn-primary"  href="/stocks">Retour à la liste</a>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Quantité</th>
                  <th>Date</th>
                  <th>Entrée</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                	@foreach($stockentres as $entree)
                  <div class="modal fade" id="modal{{$entree->ide}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">{{$entree->reference}}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{Route('stocks.update',$entree->ide)}}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                  <label>Quantité: </label>
                                    <input type="number" class="form-control" name="quantite" value="{{$entree->quantite}}">
                                </div>
                                <div class="form-group">
                                  <label>Fournisseur: </label>
                                    <input type="text" class="form-control" name="source" value="{{$entree->source}}">
                                </div>
                                <button class="bt btn-primary"> Modifier</button>
                            </form>
                        </div>
                      </div>
                    </div>
                  </div>
		                <tr style="">
		                  <td>{{$entree->quantite}}</td>
		                  <td>{{date('d/m/Y',strtotime($entree->date))}}</td>
                      <td>{{$entree->source}}</td>
                      <td>
                        <a  type="button" class="btn btn-warning"  data-toggle="modal" data-target="#modal{{$entree->ide}}">
                          <i class="fa fa-edit"></i>
                        </a>
                        <a  href="destroy/{{$entree->ide}}" type="button" class="btn btn-danger">
                          <i class="fa fa-times"></i>
                        </a>
                    </td>
		                </tr>	
		            @endforeach															
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <div class="card col-12">
            <div class="card-header card-success">

              <h3 class="card-title"> SORTIE 
               @if(isset($stockentres[0]->reference))
                {{$stockentres[0]->reference}}
                @endif
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <!-- <a class="btn btn-primary"  href="/stocks">Retour à la liste</a> -->
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Quantité</th>
                  <th>Date</th>
                  <th>Sortie</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($stocksorties as $sortie)
                  <div class="modal fade" id="modal{{$sortie->ide}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">{{$sortie->reference}}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{Route('stocks.update',$sortie->ide)}}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                  <label>Quantité: </label>
                                    <input type="number" class="form-control" name="quantite" value="{{$sortie->quantite}}">
                                </div>
                                <div class="form-group">
                                  <label>Fournisseur: </label>
                                    <input type="text" class="form-control" name="source" value="{{$sortie->source}}">
                                </div>
                                <button class="bt btn-primary"> Modifier</button>
                            </form>
                        </div>
                      </div>
                    </div>
                  </div>
                    <tr style="">
                      <td>{{$sortie->quantite}}</td>
                      <td>{{date('d/m/Y',strtotime($sortie->pose))}}</td>
                      <td>{{$sortie->source}}</td>
                      <td>
                        <a  type="button" class="btn btn-warning"  data-toggle="modal" data-target="#modal{{$sortie->ide}}">
                          <i class="fa fa-edit"></i>
                        </a>
                        <a  href="destroy/{{$sortie->ide}}" type="button" class="btn btn-danger">
                          <i class="fa fa-times"></i>
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