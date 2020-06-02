@extends('dashboard.dashboard')
@section('style')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">

@endsection
@section('content')
          <div class="card col-12">
            <div class="card-header card-success">

              <h3 class="card-title">Liste des pneus utilisés par entreprise</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form action="{{route('utiliser.depuis')}}" method="post">
                @csrf
                <div class="form-group row">
                <input type="date" class="form-control col-2" name="date">
                <button class="btn btn-primary col-1">Valider</button>
              </div>
              </form> 
              @if(!isset($date))
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Entreprise</th>
                  <th>Nombre des pneus utilisés</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($stats as $stat)
                      <tr>
                        <td>{{$stat->entreprise}}</td>
                        <td>{{$stat->nb}}</td>
                      </tr>
                  @endforeach
                </tbody>
              </table>
              @else
                <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Entreprise</th>
                  <th>Nombre des pneus utilisés</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($users as $stat)
                    <span hidden>
                      {{$count=0}}
                        @foreach($stats as $statu)
                          @if(date('Y-m-d',strtotime($statu->cre))>=date('Y-m-d',strtotime($date)))
                            @if($stat->entreprise==$statu->entreprise)
                              {{$nom=$stat->entreprise}}
                              {{$count++}}
                            @endif
                          @endif
                        @endforeach
                        @if($count!=0)
                        <tr>
                          <td>{{$nom}}</td>
                          <td> {{$count}}</td>
                        </tr>
                        @endif
                    </span>
                  @endforeach
                </tbody>
              </table>
              @endif
            </div>
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