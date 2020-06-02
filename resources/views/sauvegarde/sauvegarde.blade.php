@extends('dashboard.dashboard')
@section('content')
	<a class="btn btn-warning" href="mytextdocument{{date('d_m_Y')}}.sql">Effectuer une sauvegarde</a>
	<a class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">Importer les données</a>

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