@extends('dashboard.dashboard')
@section('style')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">

@endsection
@section('content')
          <div class="card col-12">
            <div class="card-header card-success">

              <h3 class="card-title">Historiques des alertes</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Immatriculation:</th>
                  <th>Entreprise:</th>
                  <th>Responsable:</th>
                  <th>Messages:</th>
                  <th>Date d'envoi:</th>
                  <th>Réponse:</th>
                  <th>Date de réception:</th>
                  <th>Action :</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($stories as $story)
                      <tr>
                        <div class="modal fade" id="suprimer{{$story->ide}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  Vous voulez vraiment retirer cette ligne de l'historique?
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                                  <a href="story/destroy/{{$story->ide}}" type="button" class="btn btn-primary">Oui</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        <td><a href="vehicules/{{$story->id}}"> {{$story->immatriculation}}</a></td>
                        <td>{{$story->entreprise}}</td>
                        <td>{{$story->name}} ({{$story->email}})</td>
                        <td>{{$story->message}}</td>
                        <td>
                          <span hidden>{{strtotime($story->created_at)}}</span>
                          {{date('d/m/Y H:i',strtotime($story->created_at))}}
                        </td>
                        <td>
                          @foreach($rdvs as $rdv)
                            @if($rdv->vehicule_id==$story->id and strtotime($rdv->date)>strtotime($story->created_at) and $rdv->accepted!=1 and $rdv->finished!=1)
                              {{$rdv->commentaire}}
                              @break
                            @endif
                          @endforeach
                        </td>
                        <td>
                          @foreach($rdvs as $rdv)
                            @if($rdv->vehicule_id==$story->id and strtotime($rdv->date)>strtotime($story->created_at) and $rdv->accepted!=1 and $rdv->finished!=1)
                              {{date('d/m/Y',strtotime($rdv->date))}} 
                              @break
                            @endif
                          @endforeach
                        </td>
                        <td><a  type="button" class="btn btn-danger" data-toggle="modal" data-target="#suprimer{{$story->ide}}">
                          <i class="fa fa-trash-alt"></i>
                        </a> 
                        </td>
                      </tr>
                  @endforeach
                </tbody>
              </table>
                
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
      "order": [ 4, 'desc' ]
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