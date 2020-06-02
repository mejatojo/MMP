@extends('dashboard.dashboard')
@section('style')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

@endsection
@section('content')
<div class="card col-12">
            <div class="card-header card-success">

              <h3 class="card-title">Coût de possession</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Immatriculation</th>
                  <th>Marque</th>
                  <th>Modele</th>
                  <th>Kilomètrage moyen</th>
                  <th>Entreprise</th>
                  <th>Réference</th>
                  <th>Possession</th>
                </tr>
                </thead>
                <tbody>
                	@foreach($vehicules as $vehicule)
                    @if(isset(unserialize($vehicule->refPneus)[0]))
  		                @for($i=0;$i<(count(unserialize($vehicule->refPneus)));$i++)
                        @foreach($References as $Reference)
                          @if(unserialize($vehicule->refPneus)[$i]==$Reference->id)
                      <tr>
                              <td>{{$vehicule->immatriculation}}</td>
                              <td>{{$vehicule->marque}}</td>
                              <td>{{$vehicule->model}}</td>
                              <td>
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
                              </td>
                              <td>{{$vehicule->entreprise}}</td>
                              <td>{{$Reference->reference}}</td>
                              <td>
                                {{round(($Reference->prix+$Reference->cout)+($Reference->gazole*$Reference->consommation)*($countk/100),2)}} € pour {{round($countk)}} km
                              </td>
                      </tr>
                          @endif
                        @endforeach
                      @endfor  
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