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
              <div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Ajouter</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{Route('stocks.store')}}" method="post">
                                @csrf
                                <div class="form-group">
                                  <label>Réference: </label>
                                    <input type="text" class="form-control" name="referenceName">
                                </div>
                                <div class="form-group">
                                  <label>Quantité: </label>
                                    <input type="number" class="form-control" name="quantite">
                                </div>
                                <div class="form-group">
                                  <label>Fournisseur: </label>
                                    <input type="text" class="form-control" name="source">
                                </div>
                                <button class="bt btn-primary"> Enregistrer</button>
                            </form>
                        </div>
                      </div>
                    </div>
                  </div>
              <button class="btn btn-primary"  data-toggle="modal" data-target="#mymodal">Ajouter</button>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Réferences</th>
                  <th>Stock initial</th>
                  <th>Pneu monté</th>
                  <th>Stock restant</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                	@foreach($stocks as $stock)
                  <div class="modal fade" id="modal{{$stock->reference_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">{{$stock->reference}}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{Route('stocks.store')}}" method="post">
                                @csrf
                                <div class="form-group">
                                  <label>Quantité: </label>
                                  <input type="text" class="form-control" name="reference" value="{{$stock->reference_id}}" hidden>
                                    <input type="number" class="form-control" name="quantite">
                                </div>
                                <div class="form-group">
                                  <label>Fournisseur: </label>
                                    <input type="text" class="form-control" name="source">
                                </div>
                                <button class="bt btn-primary"> <i class="fa fa-plus"></i></button>
                            </form>
                        </div>
                      </div>
                    </div>
                  </div>
		                <tr style="">
		                  <td>{{$stock->reference}}</td>
                      <td>
                        @foreach($stockinitials as $sInitial)
                          @if($stock->reference_id==$sInitial->reference_id)
                            {{$sInitial->qte}}
                          @endif
                        @endforeach
                      </td>
                      <td>
                        @foreach($stockperdus as $sPerdu)
                          @if($stock->reference_id==$sPerdu->reference_id)
                            {{abs($sPerdu->qte)}}
                          @endif
                        @endforeach
                      </td>
		                  <td>{{$stock->qte}}</td>
                      <td> 
                        <a href="stocks/{{$stock->reference_id}}" type="button" class="btn btn-success">Détail</a>
                        <a  type="button" class="btn btn-warning"  data-toggle="modal" data-target="#modal{{$stock->reference_id}}">
                          <i class="fa fa-plus"></i>
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