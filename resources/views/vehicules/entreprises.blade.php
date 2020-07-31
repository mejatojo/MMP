@extends('dashboard.dashboard')
@section('style')
 <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

@endsection
@section('content')
@if(Auth::user()->role=='superadmin')
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
                  <th>Nombre de pneu utilisé</th>
                  <th>Moyenne de hauteur final de gomme</th>
                  <th>Moyenne kilométrique</th>
                  <th>Moyenne du coût pour 1000 km</th>
                  <th>Moyenne des usures moyennes</th>
                </tr>
                </thead>
                <tbody>
                  <span hidden>{{$totalhg=0}}{{$totalkmp=0}}{{$totalcout=0}}{{$totalusure=0}}{{$nbV=0}}{{$nbE=0}}{{$nbP=0}}</span>
                  @foreach($entreprises as $entreprise)
                  <span hidden>{{$nbE++}}{{$nbV=$nbV+$entreprise->nombre}}{{$hg=0}}{{$kmp=0}}{{$cout=0}}{{$count=0}}{{$usure=0}}{{$hgv=0}}{{$kmpv=0}}{{$coutv=0}}{{$countv=0}}{{$usurev=0}}</span>
                        @foreach($vehicules as $vehicule)
                          @if($vehicule->entreprise==$entreprise->entreprise)
                            @foreach($References as $Reference)
                              @if($vehicule->id==$Reference->id_vehicule)
                                <span hidden>
                                  {{$hg=$hg+$Reference->hgFinal}}
                                  {{$kmp=$kmp+$Reference->kFinal-$Reference->kInit}}
                                  {{$cout=$cout+(((($Reference->kFinal-$Reference->kInit)*$Reference->consommation/100/4)*$Reference->gazole)+$Reference->cout)/($Reference->kFinal-$Reference->kInit)*1000}}
                                  {{$count++}}
                                  {{$usure=$usure+($Reference->hgInit-$Reference->hgFinal)*1000/($Reference->kFinal-$Reference->kInit)}}
                                </span>
                              @endif
                            @endforeach
                          @endif 
                        @endforeach
                  @foreach($vehicules as $vehicule)
                          @if($vehicule->entreprise==Auth::user()->entreprise)
                            @foreach($References as $Reference)
                              @if($vehicule->id==$Reference->id_vehicule)
                                <span hidden>
                                  {{$hgv=$hgv+$Reference->hgFinal}}
                                  {{$kmpv=$kmpv+$Reference->kFinal-$Reference->kInit}}
                                  {{$coutv=$coutv+(((($Reference->kFinal-$Reference->kInit)*$Reference->consommation/100/4)*$Reference->gazole)+$Reference->cout)/($Reference->kFinal-$Reference->kInit)*1000}}
                                  {{$countv++}}
                                  {{$usurev=$usurev+($Reference->hgInit-$Reference->hgFinal)*1000/($Reference->kFinal-$Reference->kInit)}}
                                </span>
                              @endif
                            @endforeach
                          @endif 
                        @endforeach

                      <tr style="">
                      <td>
                          <a href="flotte/{{$entreprise->id}}"> 
                            {{$entreprise->entreprise}}
                          </a>
                      </td>
                      <td>{{$entreprise->name}}</td>
                      <td>
                  <a type="button" class="btn btn-default" data-toggle="modal" data-target="#a{{trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $entreprise->entreprise))}}">
                          {{$entreprise->nombre}}
                  </a>
                  <!-- Modal -->
                                        </td>
                                        <td>{{$count}}</td>
                                        <span hidden>
                                          {{$nbP=$nbP+$count}}
                                          @if($count==0)
                                            {{$count=1}}
                                          @endif
                                          {{$totalhg=$totalhg+$hg}}
                                        </span>
                                        <td>
                                          
                                        {{round($hg/$count,2)}} mm
                                        </td>
                                        <td><span hidden>{{$totalkmp=$totalkmp+$kmp}}</span> 
                                        {{number_format(round($kmp/$count,2),2,",",".")}}km</td>
                                        <td><span hidden>{{$totalcout=$totalcout+$cout}}</span> 
                                        {{round($cout/$count,2)}} €</td>
                                        <td><span hidden>{{$totalusure=$totalusure+$usure}}</span>{{round($usure/$count,2)}} mm</td>
                                      </tr> 

                @endforeach   
                <tr>
                  <td>Toutes les entreprises</td>
                  <td>
                  Totaux

                </td>
                  <td>{{$nbV}}</td>
                  <td>{{$nbP}}</td>
                  <span hidden>
                    @if($nbP==0)
                          {{$nbP=1}}
                        @endif
                  </span>
                  <td>{{round($totalhg/$nbP,2)}} mm</td>
                  <td>{{number_format(round($totalkmp/$nbP,2),2,",",".")}} km</td>
                  <td>{{round($totalcout/$nbP,2)}} €</td>
                  <td>{{round($totalusure/$nbP,2)}} mm</td>
                </tr>                         
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          @else
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
                  <th>Nombre de véhicule</th>
                  <th>Nombre de pneu utilisé</th>
                  <th>Moyenne de hauteur final de gomme</th>
                  <th>Moyenne kilométrique</th>
                  <th>Moyenne du coût pour 1000 km</th>
                  <th>Moyenne des usures moyennes</th>
                </tr>
                </thead>
                <tbody>
                  <span hidden>{{$totalhg=0}}{{$totalkmp=0}}{{$totalcout=0}}{{$totalusure=0}}{{$nbV=0}}{{$nbE=0}}{{$nbP=0}}</span>
                  @foreach($entreprises as $entreprise)
                  <span hidden>{{$nbE++}}{{$nbV=$nbV+$entreprise->nombre}}{{$hg=0}}{{$kmp=0}}{{$cout=0}}{{$count=0}}{{$usure=0}}{{$hgv=0}}{{$kmpv=0}}{{$coutv=0}}{{$countv=0}}{{$usurev=0}}</span>
                        @foreach($vehicules as $vehicule)
                          @if($vehicule->entreprise==$entreprise->entreprise)
                            @foreach($References as $Reference)
                              @if($vehicule->id==$Reference->id_vehicule)
                                <span hidden>
                                  {{$hg=$hg+$Reference->hgFinal}}
                                  {{$kmp=$kmp+$Reference->kFinal-$Reference->kInit}}
                                  {{$cout=$cout+(((($Reference->kFinal-$Reference->kInit)*$Reference->consommation/100/4)*$Reference->gazole)+$Reference->cout)/($Reference->kFinal-$Reference->kInit)*1000}}
                                  {{$count++}}
                                  {{$usure=$usure+($Reference->hgInit-$Reference->hgFinal)*1000/($Reference->kFinal-$Reference->kInit)}}
                                </span>
                              @endif
                            @endforeach
                          @endif 
                        @endforeach
                  @foreach($vehicules as $vehicule)
                          @if($vehicule->entreprise==Auth::user()->entreprise)
                            @foreach($References as $Reference)
                              @if($vehicule->id==$Reference->id_vehicule)
                                <span hidden>
                                  {{$hgv=$hgv+$Reference->hgFinal}}
                                  {{$kmpv=$kmpv+$Reference->kFinal-$Reference->kInit}}
                                  {{$coutv=$coutv+(((($Reference->kFinal-$Reference->kInit)*$Reference->consommation/100/4)*$Reference->gazole)+$Reference->cout)/($Reference->kFinal-$Reference->kInit)*1000}}
                                  {{$countv++}}
                                  {{$usurev=$usurev+($Reference->hgInit-$Reference->hgFinal)*1000/($Reference->kFinal-$Reference->kInit)}}
                                </span>
                              @endif
                            @endforeach
                          @endif 
                        @endforeach
                    @if(Auth::user()->entreprise==$entreprise->entreprise)
                       
                    <tr style="">
                      <td>
                          <a href="flotte/{{$entreprise->id}}"> 
                            {{$entreprise->entreprise}}
                          </a>
                      </td>

                      <td>
                  <a type="button" class="btn btn-default" data-toggle="modal" data-target="#a{{trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $entreprise->entreprise))}}">
                          {{$entreprise->nombre}}
                  </a>

                      </td>
                      <td>{{$countv}}</td>
                      <span hidden>
                        {{$nbP=$nbP+$count}}
                        @if($countv==0)
                          {{$countv=1}}
                        @endif
                        {{$totalhg=$totalhg+$hg}}
                        <span hidden>{{$totalkmp=$totalkmp+$kmp}}</span> 
                        <span hidden>{{$totalcout=$totalcout+$cout}}</span> 
                        <span hidden>{{$totalusure=$totalusure+$usure}}</span>
                      </span>
                      <td>
                        
                      {{round($hgv/$countv,2)}} mm
                      </td>
                      <td>
                      {{number_format(round($kmpv/$countv,2),2,",",".")}} km</td>
                      <td>
                      {{round($coutv/$countv,2)}} €</td>
                      <td>{{round($usurev/$countv,2)}} mm</td>
                    </tr> 
                    @endif
                @endforeach   
                <tr>
                  <td>
                  Toutes les entreprises

                </td>
                  <td>{{$nbV}}</td>
                  <td>{{$nbP}}</td>
                  <span hidden>
                    @if($nbP==0)
                          {{$nbP=1}}
                        @endif
                  </span>
                  <td>{{round($totalhg/$nbP,2)}} mm</td>
                  <td>{{number_format(round($totalkmp/$nbP,2),2,",",".")}} km</td>
                  <td>{{round($totalcout/$nbP,2)}} €</td>
                  <td>{{round($totalusure/$nbP,2)}} mm</td>
                </tr>                         
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          @endif
          @foreach($entreprises as $entreprise)
          <!-- Modal -->
<div class="modal fade" id="a{{trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $entreprise->entreprise))}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">vehicules</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table  class="table table-bordered table-striped example2" id="example2">
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
          @endforeach


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
  <script>
  $(function () {
    $(".example2").DataTable({
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