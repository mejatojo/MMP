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
                                  <label>Référence: </label>
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
                                <div class="form-group">
                                  <label>Prix: </label>
                                    <input type="text" class="form-control" name="prix">
                                </div>
                                <div class="form-group">
                                    <label>Indice de consommation: </label>
                                      <select class="form-control" name="indication">
                                        <option value="A" >A</option>
                                        <option value="B" >B</option>
                                        <option value="C" >C</option>
                                        <option value="E" >E</option>
                                        <option value="F" >F</option>
                                        <option value="G" >G</option>
                                      </select>
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
                  <th>Références</th>
                  <th>Stock</th>
                  <th>Pneus montés sur parc</th>
                  <!-- <th>Stock restant</th> -->
                  <th>Prix unitaire (HT)</th>
                  <th>Indication</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                	@foreach($stocks as $stock)
                  <div class="modal fade" id="suprimer{{$stock->reference_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  Cet référence disparaîtra sur la liste des véhicules et sur les statistiques après la suppression. Voulez-vous continuer?
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                                  <a href="stock/destroy/{{$stock->reference_id}}" type="button" class="btn btn-primary">Oui</a>
                                </div>
                              </div>
                            </div>
                          </div>
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
                  <div class="modal fade" id="modif{{$stock->reference_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Modification</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{Route('stocks.modifier')}}" method="post">
                                @csrf
                                 <div class="form-group">
                                  <label>Référence: </label>
                                    <input type="text" class="form-control" name="nvref" value="{{$stock->reference}}">
                                </div>
                                  <input type="text" class="form-control" name="reference" value="{{$stock->reference_id}}" hidden>
                                <div class="form-group">
                                  <label>Prix: </label>
                                    <input type="text" class="form-control" name="prix" value="{{$stock->prix}}">
                                </div>
                                <div class="form-group">
                                    <label>Indice de consommation: </label>
                                      <select class="form-control" name="indication">
                                              @if($stock->indication=='A')
                                              <option value="A" selected>A</option>
                                              @else
                                              <option value="A" >A</option>
                                              @endif
                                              @if($stock->indication=='B')
                                              <option value="B" selected>B</option>
                                              @else
                                              <option value="B" >B</option>
                                              @endif
                                              @if($stock->indication=='C')
                                              <option value="C" selected>C</option>
                                              @else
                                              <option value="C" >C</option>
                                              @endif
                                              @if($stock->indication=='E')
                                              <option value="E" selected>E</option>
                                              @else
                                              <option value="E" >E</option>
                                              @endif
                                              @if($stock->indication=='F')
                                              <option value="F" selected>F</option>
                                              @else
                                              <option value="F" >F</option>
                                              @endif
                                              @if($stock->indication=='G')
                                              <option value="G" selected>G</option>
                                              @else
                                              <option value="G" >G</option>
                                              @endif
                                            </select>
                                </div>
                                <button class="bt btn-primary"> Modifier</button>
                            </form>
                        </div>
                      </div>
                    </div>
                  </div>
		                <tr style="">
		                  <td>{{$stock->reference}}</td>
                      <td>{{$stock->qte}}</td>
                      <td>
                        <span hidden>{{$pos=0}}</span>
                        @foreach($vehicules as $vehicule)
                          @for($i=0;$i<count(unserialize($vehicule->refPneus));$i++)
                              @foreach($Reference as $ref)
                                @if($stock->reference_id==$ref->reference_id)
                                @if($ref->id==unserialize($vehicule->refPneus)[$i])
                                <span hidden>{{$pos++}}</span>
                                @endif
                                @endif
                              @endforeach
                          @endfor
                        @endforeach
                        {{$pos}}
                      </td>
		                  <!-- <td>{{$stock->qte}}</td> -->
                      <td>{{$stock->prix}} €</td>
                      <td>{{$stock->indication}} ou {{$stock->consommation}} </td>
                      <td> 
                        <a href="stocks/{{$stock->reference_id}}" type="button" class="btn btn-success">Détail</a>
                        <a  type="button" class="btn btn-warning"  data-toggle="modal" data-target="#modal{{$stock->reference_id}}">
                          <i class="fa fa-plus"></i>
                        </a>
                        <a  type="button" class="btn btn-danger"  data-toggle="modal" data-target="#modif{{$stock->reference_id}}">
                          <i class="fa fa-edit"></i>
                        </a>
                       <a  type="button" class="btn btn-danger" data-toggle="modal" data-target="#suprimer{{$stock->reference_id}}">
                          <i class="fa fa-trash-alt"></i>
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