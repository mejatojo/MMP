@extends('dashboard.dashboard')
@section('style')
<style type="text/css">
  .cache{
    visibility: hidden;
  }
  .tscache{
    visibility: visible
  }
</style>
@endsection
@section('content')
          <!-- left column -->
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Ajout d'un véhicule</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" action="{{Route('vehicules.store')}}" name="forma">
                @csrf
                <div class="card-body">
                  <div class="row">
                  <div class="form-group col-6">
                    <label for="exampleInputPassword1">Immatriculation</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Immatriculation" name="immatriculation">
                  </div>
                  <div class="form-group col-6">
                    <label for="exampleInputPassword1">Marque</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="marque" name="marque">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-6">
                    <label for="exampleInputPassword1">Model</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Model" name="model">
                  </div>
                  <div class="form-group col-6">
                    <label for="exampleInputPassword1">Dernière maintenance</label>
                    <input type="date" class="form-control" id="exampleInputPassword1" name="dmaintenance">
                  </div>
                </div>
                    <div class="row">
                       <div class="form-group col-6">
                      <label>Pneus : </label>
                      <div class="row">
                      <div class="form-check col-3">
                          <input class="form-check-input" type="radio" name="pne" value="4" checked>
                          <label class="form-check-label">4 roues</label>
                        </div>
                        <div class="form-check col-3">
                          <input class="form-check-input" type="radio" name="pne" value="6">
                          <label class="form-check-label">6 roues</label>
                      <input type="text" value="{{Auth::user()->id}}" name="conducteur" hidden="true">
                        </div>
                      </div>
                    </div>
                     <div class="form-group col-6">
                      <label>Entreprise</label>
                      <select class="form-control" name="conducteur" id="choixE">
                          @foreach($entreprises as $entreprise)
                              <option value="{{$entreprise->id}}">{{$entreprise->entreprise}}</option>
                          @endforeach
                      </select>                  
                    </div>
                 </div>
                 <div class="row">
                                    <div class="form-group col-4">
                                      <label for="exampleInputPassword1">Date de mise en circulation: </label>
                                      <input type="date" class="form-control" id="exampleInputPassword1" name="datec">
                                    </div>
                                    <div class="form-group col-4">
                                      <label for="exampleInputPassword1">Stationnement: </label>
                                      <input type="text" class="form-control" id="exampleInputPassword1" name="stationnement">
                                    </div>
                                  <div class="form-group col-4">
                                      <label for="exampleInputPassword1">Commentaire : </label>
                                      <textarea name="information" placeholder="information pour l'opérateur" class="form-control"></textarea>
                                    </div>
                  </div>
                    @include('maintenances.collection')
                  </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
              </form>

            </div>
          </div>

@endsection
@section('script')
<script type="text/javascript">
  var rad = document.forma.pne;
var prev = null;
for (var i = 0; i < rad.length; i++) {
    rad[i].addEventListener('change', function() {
        if(this.value==6)
        {
          var cache=document.querySelectorAll('.cache');
          for (var o = 0; o < cache.length; o++) {
          cache[o].classList.remove('cache')
          cache[o].classList.add('tscache')
        }
        }
        if(this.value==4)
        {
          var cache=document.querySelectorAll('.tscache');
          for (var a= 0; a < cache.length; a++) {
          cache[a].classList.remove('tscache')
          cache[a].classList.add('cache')
        }
        }
    });
}
</script>
<script type="text/javascript">
  var init=document.querySelectorAll('.init')
  for(i=0;i<init.length;i++)
  {
    init[i].addEventListener('keyup',function(){
      this.previousElementSibling.value=this.value
    })
  }
</script>

@endsection