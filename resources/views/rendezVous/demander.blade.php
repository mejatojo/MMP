@extends('dashboard.dashboard')
@section('style')
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
        <iframe src="https://calendar.google.com/calendar/embed?src=js7fhgkdhh18fp8kqc8025rsoc%40group.calendar.google.com&ctz=Europe%2FParis" style="border: 0" width="100%" height="400" frameborder="0" scrolling="no"></iframe>
      </div>
      <div class="modal-footer"><!-- 
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Prendre un rendez-vous</h3>
              </div>              
              <form role="form" method="post" action="{{Route('rendezVous.store')}}">
                @csrf
                <div class="card-body">
                  <div class="row">
                  <div class="form-group col-6">
                    <label for="exampleInputPassword1">Date</label>
                    <div class="row">
                      <input type="date" class="form-control col-6" id="exampleInputPassword1"  name="date" required>
                      <input type="time" class="form-control col-3" id="exampleInputPassword1"  name="heure" required>
                    </div>
                  </div>
                  <div class="form-group col-6">
                    <label for="exampleInputPassword1">Véhicule</label>
                    <select class="form-control" name="vehicule" required>
                      @foreach($vehicules as $vehicule)
                         <option value="{{$vehicule->ide}}">{{$vehicule->immatriculation}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                  </div>
                    <div class="form-group col-12">
                        <label>Commentaire : </label>
                        <textarea class="form-control" rows="3" placeholder="Enter ..." name="comment" required></textarea>
                    </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
              </form>
             
            </div>
          </div>

@endsection
@section('script')




@endsection