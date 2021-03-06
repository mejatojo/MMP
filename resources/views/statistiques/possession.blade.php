@extends('dashboard.dashboard')
@section('style')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

@endsection
@section('content')
<div class="card col-12">
            <div class="card-header card-success">

              <h3 class="card-title">Gestion de coûts</h3>
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
                  <th>Usure moyenne pour 1000 km:</th>
                  @endif
                  <!-- <th>Kilomètrage moyen:</th> -->
                  <th>Coût du pneu:</th>
                  <th>Kilométrage parcouru:</th>
                  @if(Auth::user()->role=='superadmin')
                  <th>Indice de consommation:</th>
                  @endif
                  <th>Carburant:</th>
                  <th>Surconsommation en l et en €:</th>
                  <th>Coût de possession:</th>
                  <th>Prix de revient total d'un pneu pour 1000 km:</th>
                   @if(Auth::user()->role=='superadmin')
                  <th>Actions:</th>
                  @endif
                </tr>
                </thead>
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
                                          <label>Réference : </label>
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
                                          <label>Kilomètrage initial: </label>
                                            <input type="text" class="form-control" name="kinit" value="{{$Reference->kInit}}">
                                        </div>
                                        <div class="form-group">
                                          <label>Kilomètrage final: </label>
                                            <input type="text" class="form-control" name="kFinal" value="{{$Reference->kFinal}}">
                                        </div>
                                        <div class="form-group">
                                          <label>Coût de la pose: </label>
                                            <input type="text" class="form-control" name="cout" value="{{$Reference->cout}}">
                                        </div>
                                        <div class="form-group">
                                          <label>Prix de carburant: </label>
                                            <input type="text" class="form-control" name="gazole" value="{{$Reference->gazole}}">
                                        </div>
                                        <!-- <div class="form-group">
                                          <label>Indice de consommation: </label>
                                            <select class="form-control" name="indication">
                                              @if($Reference->indication=='A')
                                              <option value="A" selected>A</option>
                                              @else
                                              <option value="A" >A</option>
                                              @endif
                                              @if($Reference->indication=='B')
                                              <option value="B" selected>B</option>
                                              @else
                                              <option value="B" >B</option>
                                              @endif
                                              @if($Reference->indication=='C')
                                              <option value="C" selected>C</option>
                                              @else
                                              <option value="C" >C</option>
                                              @endif
                                              @if($Reference->indication=='E')
                                              <option value="E" selected>E</option>
                                              @else
                                              <option value="E" >E</option>
                                              @endif
                                              @if($Reference->indication=='F')
                                              <option value="F" selected>F</option>
                                              @else
                                              <option value="F" >F</option>
                                              @endif
                                              @if($Reference->indication=='G')
                                              <option value="G" selected>G</option>
                                              @else
                                              <option value="G" >G</option>
                                              @endif
                                            </select>
                                        </div> -->
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
                                <span hidden>{{round(($Reference->hgInit-$Reference->hgFinal)*1000/($Reference->kFinal-$Reference->kInit),2)/1000}}</span>
                                {{round(($Reference->hgInit-$Reference->hgFinal)*1000/($Reference->kFinal-$Reference->kInit),2)}} mm
                              </td> 
                              @endif
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
                                <span hidden>{{$Reference->cout/1000}}</span>
                                {{$Reference->cout}} €</td>
                              <td>
                                <span hidden>{{($Reference->kFinal-$Reference->kInit)/100000}}</span>
                                <!-- {{round(($Reference->prix+$Reference->cout)+($Reference->gazole*$Reference->consommation)*($countk/100),2)}} € pour  -->{{$Reference->kFinal-$Reference->kInit}} km
                              </td>

                  @if(Auth::user()->role=='superadmin')
                              <td>
                                <span hidden>{{$Reference->consommation/1000}}</span>
                                {{$Reference->indication}} soit {{$Reference->consommation}} l/100km</td>
                                @endif
                              <td> 
                                <span hidden>{{$Reference->gazole/1000}}</span>
                                {{$Reference->gazole}} ({{$vehicule->carburant}})</td>
                              <td>
                                <span hidden>
                                   {{round(($Reference->kFinal-$Reference->kInit)*$Reference->consommation/100/4,2)/1000}}
                                </span>
                                {{round(($Reference->kFinal-$Reference->kInit)*$Reference->consommation/100/4,2)}} l / {{round((($Reference->kFinal-$Reference->kInit)*$Reference->consommation/100/4)*$Reference->gazole,2)}} €
                              </td>
                              <td>
                                <span hidden>
                                  {{round((($Reference->kFinal-$Reference->kInit)*$Reference->consommation/100/4)*$Reference->gazole,2)/1000}}
                                </span>
                                {{round(((($Reference->kFinal-$Reference->kInit)*$Reference->consommation/100/4)*$Reference->gazole)+$Reference->cout,2)}} €
                              </td>
                              <td>
                                <span hidden>
                                  {{round((((($Reference->kFinal-$Reference->kInit)*$Reference->consommation/100/4)*$Reference->gazole)+$Reference->cout)/($Reference->kFinal-$Reference->kInit)*1000,2)/1000}}
                                </span>
                                {{round((((($Reference->kFinal-$Reference->kInit)*$Reference->consommation/100/4)*$Reference->gazole)+$Reference->cout)/($Reference->kFinal-$Reference->kInit)*1000,2)}} €
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