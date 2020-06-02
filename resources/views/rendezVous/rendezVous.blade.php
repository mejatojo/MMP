@extends('dashboard.dashboard')
@section('style')
  <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <style type="text/css">
  	.col-6
  	{
  		background: red;
  		border: 1px solid black;
  	}
  	.ty {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black;
}

.ty .tytext {
  visibility: hidden;
  width: 200px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  position: absolute;
  z-index: 1;
  bottom: 125%;
  left: 50%;
  margin-left: -60px;
  opacity: 0;
  transition: opacity 0.3s;
}

.ty .tytext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

.ty:hover .tytext {
  visibility: visible;
  opacity: 1;
}
  </style>

<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
@endsection
@section('content')

  <button class="btn btn-secondary" data-toggle="modal" data-target="#exampleModalLong">
      Calendrier
  </button>
<div class="modal fade bd-example-modal-lg" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Rendez_vous du mois</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <iframe src="https://calendar.google.com/calendar/embed?src=5jfn704enpctkok1rjditnds1g%40group.calendar.google.com&ctz=Africa%2FNairobi" style="border: 0" width="100%" height="400" frameborder="0" scrolling="no"></iframe>
      </div>
      <div class="modal-footer"><!-- 
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

<div class="card col-12 card-warning">
            <div class="card-header">

              <h3 class="card-title">Liste des rendez-vous</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table  class="table table-bordered table-striped exo">
                <thead>
                <tr>
                  <th>Immatriculation</th>
                  <th>Propriété</th>
                  <th>Date</th>
                  <th>Commentaire</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                	@foreach($rendezVous as $rdv)

                  <!-- Modal -->
                  <div class="modal fade" id="e{{$rdv->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Cause : </h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form action="/rendezVous/reject" method="POST">
                            @csrf
                            <input type="text" name="id" value="{{$rdv->id}}" hidden>
                            <textarea name="raison" class="form-control"></textarea>
                            <button class="btn btn-primary">Valider</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
		                <tr style="">
		                  <td>{{$rdv->immatriculation}}</td>
		                  <td>{{$rdv->name}}</td>
		                  <td>{{date('d/m/Y',strtotime($rdv->daty))}} à {{$rdv->heure}}</td>
		                  <td>{{$rdv->commentaire}}</td>
		                  <td>
                        <a href="/rendezVous/accept/{{$rdv->id}}" type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="right" title="Accepter">
                          <i class="fa fa-check"></i>
                  </a>
		                  	<a  type="button" class="btn btn-danger"  data-toggle="modal" data-target="#e{{$rdv->id}}">
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
      </div>
      <div class="card col-12 card-success">
            <div class="card-header">

              <h3 class="card-title">Liste des rendez-vous acceptés</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table  class="table table-bordered table-striped exo">
                <thead>
                <tr>
                  <th>Immatriculation</th>
                  <th>Propriété</th>
                  <th>Date</th>
                  <th>Commentaire</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                	@foreach($rendezVousAcc as $rdv)
                  <div class="modal fade" id="re{{$rdv->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Cause :</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form action="/rendezVous/reject" method="POST">
                            @csrf
                            <input type="text" name="id" value="{{$rdv->id}}" hidden>
                            <textarea name="raison" class="form-control"></textarea>
                            <button class="btn btn-primary">Valider</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
		                <tr style="">
		                  <td>{{$rdv->immatriculation}}</td>
		                  <td>{{$rdv->name}}</td>
		                  <td>{{date('d/m/Y',strtotime($rdv->daty))}} à {{$rdv->heure}}</td>
		                  <td>{{$rdv->commentaire}}</td>
		                  <td>
									<a  type="button" class="btn btn-danger"  data-toggle="modal" data-target="#re{{$rdv->id}}">
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
      </div>
      <div class="card col-12 card-danger">
            <div class="card-header">

              <h3 class="card-title">Liste des rendez-vous rejetés</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table  class="table table-bordered table-striped exo">
                <thead>
                <tr>
                  <th>Immatriculation</th>
                  <th>Propriété</th>
                  <th>Date</th>
                  <th>Commentaire</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                	@foreach($rendezVousRef as $rdv)
		                <tr style="">
		                  <td>{{$rdv->immatriculation}}</td>
		                  <td>{{$rdv->name}}</td>
		                  <td>{{date('d/m/Y',strtotime($rdv->daty))}} à {{$rdv->heure}}</td>
		                  <td>{{$rdv->commentaire}}</td>
		                  <td>
		                  	<a href="/rendezVous/accept/{{$rdv->id}}" type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="right" title="Accepter">
		                  		<i class="fa fa-check"></i>
									</a>
		                  </td>
		                </tr>	
		            @endforeach															
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
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
    $(".exo").DataTable({
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



@endsection
  