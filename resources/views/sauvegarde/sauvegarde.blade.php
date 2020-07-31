@extends('dashboard.dashboard')
@section('content')
<div class="row" style="width: 100%;margin-top: 2cm;">
  <div class="col-2"></div>
	<a class="btn btn-warning col-4" href="mytextdocument{{date('d_m_Y')}}.sql" download><i class="fas fa-file-download">&nbsp;&nbsp;</i>Effectuer une sauvegarde</a>
	<a class="btn btn-danger col-4" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-file-import">&nbsp;&nbsp;</i>Importer les données</a>
  <div class="col-2"></div>
</div>
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Téléverser votre fichier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form action="{{route('importer')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="file" class="form-control">
                                <button class="btn btn-primary">Valider</button>
                            </form>
      </div>
    </div>
  </div>
</div>
@endsection 