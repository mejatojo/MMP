@extends('dashboard.dashboard')
@section('style')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

@endsection
@section('content')
<div class="card col-12">
            <div class="card-header card-success">

              <h3 class="card-title">Liste des pneus usés</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Immatriculation:</th>
                  <th>Marque:</th>
                  <th>Modèle:</th>
                  @if(Auth::user()->role=='superadmin')
                  <th>Entreprise:</th>
                  @endif
                  <th>Référence:</th>
                   @if(Auth::user()->role=='superadmin')
                  <th>Pose:</th>
                  <th>Dépose:</th>
                  <th>Origine:</th>
                  @endif
                  <th>Hauteur initiale de gomme:</th>
                  <th>Hauteur finale de gomme:</th>
                  <!-- <th>Kilomètrage moyen:</th>> -->
                  <th>Kilométrage parcouru:</th>
                  <th>Usure moyenne pour 1000 km:</th>
                   @if(Auth::user()->role=='superadmin')
                  <th>Actions:</th>
                  @endif
                </tr>
                </th>
                <tbody>
                	@foreach($vehicules as $vehicule)
                    @if(isset(unserialize($vehicule->refPneus)[0]))
                        @foreach($References as $Reference)
                          @if($vehicule->id==$Reference->id_vehicule)
                          <div class="modal fade" id="suprimer{{$Reference->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  Vous voulez vraiment supprimer cet pneu?
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                                  <a href="pneus/destroy/{{$Reference->id}}" type="button" class="btn btn-primary">Oui</a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="modal fade" id="exa{{$Reference->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">{{$Reference->reference}}</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{Route('stat.store')}}" method="post">
                                        @csrf
                                        <div class="form-group">
                                          <label>Référence : </label>
                                          <input type="text" class="form-control" name="reference" value="{{$Reference->id}}" hidden>
                                          <select class="form-control" name="ref" >
                                            @foreach($refPneus as $refPneu)
                                            @if($refPneu->id==$Reference->reference_id)
                                            <option value="{{$refPneu->id}}" selected>{{$refPneu->reference}}</option>
                                            @endif
                                            @endforeach
                                            @foreach($refPneus as $refPneu)
                                            @if($refPneu->id!=$Reference->reference_id)
                                            <option value="{{$refPneu->id}}">{{$refPneu->reference}}</option>
                                            @endif
                                            @endforeach
                                          </select>
                                        </div>
                                        <div class="form-group">
                                          <label>Kilométrage initial: </label>
                                            <input type="text" class="form-control" name="kInit" value="{{$Reference->kInit}}">
                                        </div>
                                        <div class="form-group">
                                          <label>Kilométrage final: </label>
                                            <input type="text" class="form-control" name="kFinal" value="{{$Reference->kFinal}}">
                                        </div>
                                        <div class="form-group">
                                          <label>Hauteur de gomme initial: </label>
                                            <input type="text" class="form-control" name="hgInit" value="{{$Reference->hgInit}}">
                                        </div>
                                        <div class="form-group">
                                          <label>Hauteur de gomme final: </label>
                                            <input type="text" class="form-control" name="hgFinal" value="{{$Reference->hgFinal}}">
                                        </div>
                                        <button class="bt btn-primary"> Valider</button>
                                    </form>
                                </div>
                              </div>
                            </div>
                          </div>
                      <tr>
                              <td>{{$vehicule->immatriculation}}</td>
                              <td>{{$vehicule->marque}}</td>
                              <td>{{$vehicule->model}}</td>
                              @if(Auth::user()->role=='superadmin')
                              <td>{{$vehicule->entreprise}}</td>
                              @endif
                              <td>{{$Reference->reference}}</td>
                                 @if(Auth::user()->role=='superadmin')
                              <td>
                                <span hidden>{{strtotime($Reference->pose)}}</span>
                                {{date('d/m/Y',strtotime($Reference->pose))}}</td>
                              <td>
                                <span hidden>{{strtotime($Reference->depose)}}</span>
                                {{date('d/m/Y',strtotime($Reference->depose))}}</td>
                              <td>
                                @if($Reference->quantite==0)
                                  hors du stock 
                                @else
                                  MMP
                                @endif
                              </td>
                              @endif
                              <td><span hidden>{{($Reference->hgInit)/1000}}</span>{{$Reference->hgInit}} mm</td>
                              <td><span hidden>{{($Reference->hgFinal)/1000}}</span>{{$Reference->hgFinal}} mm</td>
                              <!-- <td>
                                <span hidden>
                                  {{$kj=($Reference->kFinal-$Reference->kInit)/($Reference->hgInit-$Reference->hgFinal)}}|
                                  {{$countk=0}}|
                                  {{$hgm=($Reference->hgInit-$Reference->hgFinal)}}|
                                  {{$final=$Reference->hgInit}}|
                                   @while($final>1.6)
                                    {{$final=$final-$hgm}}
                                    {{$countk=$countk+$kj}}
                                  @endwhile
                                </span>
                                {{round($kj)}} km / jour
                              </td> -->
                              <td>
                                <span hidden>{{($Reference->kFinal-$Reference->kInit)/1000}}</span>
                                <!-- {{round(($Reference->prix+$Reference->cout)+($Reference->gazole*$Reference->consommation)*($countk/100),2)}} € pour  -->{{$Reference->kFinal-$Reference->kInit}} km
                              </td>
                              <td>
                                <span hidden>{{round(($Reference->hgInit-$Reference->hgFinal)*1000/($Reference->kFinal-$Reference->kInit),2)/10000}}</span>
                                {{round(($Reference->hgInit-$Reference->hgFinal)*1000/($Reference->kFinal-$Reference->kInit),2)}} mm
                              </td> 
                               @if(Auth::user()->role=='superadmin')
                              <td>
                                 <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exa{{$Reference->id}}" data-toggle="tooltip" data-placement="bottom" title="Modifier">
                                    <i class="fa fa-edit"></i>
                                  </button>
                                   <a  type="button" class="btn btn-danger" data-toggle="modal" data-target="#suprimer{{$Reference->id}}">
                                    <i class="fa fa-trash-alt"></i>
                                  </a> 
                              </td>
                              @endif
                      </tr> 
                          @endif
                        @endforeach
                    @endif
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