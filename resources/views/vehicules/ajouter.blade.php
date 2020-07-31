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
  <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">

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
                  <div class="form-group col-3">
                    <label for="exampleInputPassword1">Immatriculation</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Immatriculation" name="immatriculation" required>
                  </div>
                  <div class="form-group col-3">
                    <label for="exampleInputPassword1">Marque</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="marque" name="marque" required>
                  </div>
                    <div class="form-group col-3">
                    <label for="exampleInputPassword1">Model</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Model" name="model" required>
                  </div>
                  <div class="form-group col-3">
                    <label for="exampleInputPassword1">Dernière maintenance</label>
                    <input type="date" class="form-control" id="exampleInputPassword1" name="dmaintenance" required>
                  </div>
                </div>
                <div class="row">
                   <div class="form-group col-4">
                    <label for="exampleInputPassword1">Hauteur de gomme minimale : </label>
                    <input type="text" class="form-control" id="exampleInputPassword1" name="limiteHg" required value="1.6">
                  </div>
                  <div class="form-group col-4">
                    <label for="exampleInputPassword1">Pression tous les :(en jour)</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" name="limitePression" required value="30"> 
                  </div>
                    <div class="form-group col-4">
                    <label for="exampleInputPassword1">Permutation tous les : (en km)</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" name="limiteP" required value="10000">
                  </div>
                </div>
                    <div class="row">
                       <div class="form-group col-4">
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
                     <div class="form-group col-4">
                      <label>Entreprise</label>
                      <select class="form-control" name="conducteur" id="choixE">
                          @foreach($entreprises as $entreprise)
                              <option value="{{$entreprise->id}}">{{$entreprise->entreprise}}</option>
                          @endforeach
                      </select>                  
                    </div>
                    <div class="form-group col-4">
                                      <label for="exampleInputPassword1">Carburant: </label>
                                      <select class="form-control" name="carburant" >
                                          <option value="Gazoil">Gazoil</option>
                                          <option value="Essence">Essence</option>
                                          <option value="GPL">GPL</option>
                                          <option value="Electrique">Electrique</option>
                                        </select>
                                    </div> 
                 </div>
                 <div class="row">
                                    <div class="form-group col-4">
                                      <label for="exampleInputPassword1">Date de mise en circulation: </label>
                                      <input type="date" class="form-control" id="exampleInputPassword1" name="datec" required>
                                    </div>
                                    <div class="form-group col-4">
                                      <label for="exampleInputPassword1">Stationnement: </label>
                                      <input type="text" class="form-control" id="exampleInputPassword1" name="stationnement" required>
                                    </div>
                                  <div class="form-group col-4">
                                      <label for="exampleInputPassword1">Commentaire : </label>
                                      <textarea name="information" placeholder="information pour l'opérateur" class="form-control" required></textarea>
                                    </div>
                  </div>
                    @include('maintenances.collection')
                  </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" onclick="launch()">Ajouter</button>
                </div>
              </form>

            </div>
          </div>

@endsection
@section('script')
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>
<script type="text/javascript">
  function launch(event)
  {
    var ini=document.querySelectorAll('.init')
  for(i=0;i<ini.length;i++)
  {
      ini[i].previousElementSibling.value=ini[i].value
  }
  }
</script>
<script type="text/javascript">
  var rad = document.forma.pne;
  if(rad.value==6)
    {
          var cache=document.querySelectorAll('.cache');
          for (var o = 0; o < cache.length; o++) {
          cache[o].classList.remove('cache')
          cache[o].classList.add('tscache')
        cache[o].disabled=false}
    }
var prev = null;
for (var i = 0; i < rad.length; i++) {
    rad[i].addEventListener('change', function() {
        if(this.value==6)
        {
          var cache=document.querySelectorAll('.cache');
          console.log(cache);
          for (var o = 0; o < cache.length; o++) {
          cache[o].classList.remove('cache')
          cache[o].classList.add('tscache')
          cache[o].disabled=false
        }
        }
        if(this.value==4)
        {
          var cache=document.querySelectorAll('.tscache');
          for (var a= 0; a < cache.length; a++) {
          cache[a].classList.remove('tscache')
          cache[a].classList.add('cache')
          cache[a].disabled=true
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