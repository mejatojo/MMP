@extends('dashboard.dashboard')
@section('style')
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
 <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
<style type="text/css">
    .hide:hover{
      opacity: 1;
    }
    .hide{
      opacity: 0;
      transition: opacity 4s;
    }
    .show{
      opacity: 1;
    }
     .jum:hover{
      opacity: 1;
    }
    .jum{
      opacity: 0;
      transition: opacity 4s;
    }
    .exist{
      opacity: 1;
    }
    #div1, #div2 ,#div3,#div4,#div5,#div6{
  float: left;
  border: 1px solid black;
  height: 1.5cm;
}
#dv1, #dv2 ,#dv3,#dv4,#dv5,#dv6{
  float: left;
  border: 1px solid black;
}
</style>
<style type="text/css">
    .tableau{
      border: 1px solid black;
    }
    
  </style>
@endsection
@section('content')
          <!-- left column -->
          @if(!isset(unserialize($vehicule->etatPneu)[0]))
            @include('maintenances.collection')
          @else
            @include('maintenances.vehicule')
          @endif
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
  var pneus=document.querySelectorAll('.pneu')
  for(var i=0;i<pneus.length;i++)
  {
    pneus[i].addEventListener('mouseover',function()
    {
      this.parentElement.querySelector('.hide').className='show'
    })
    pneus[i].addEventListener('mouseout',function()
    {
      this.parentElement.querySelector('.show').className='hide'
    })
      
  }
  var jumele=document.querySelectorAll('.ju')
  for(var i=0;i<pneus.length;i++)
  {
    jumele[i].addEventListener('mouseover',function()
    {
      this.parentElement.querySelector('.jum').className='exist'
    })
    jumele[i].addEventListener('mouseout',function()
    {
      this.parentElement.querySelector('.exist').className='jum'
    })
      
  }
</script>
<script type="text/javascript">
  /*var list=document.querySelectorAll('.list')
for(var i=0;i<list.length;i++)
{
  list[i].nextElementSibling.value=i;
}*/

function allowDrop(ev) {
  ev.preventDefault();
}

function drag(ev) {
  ev.dataTransfer.setData("text", ev.target.id);
  a=document.getElementById(ev.target.id).innerHTML
  el=ev.target.id
}
 
function drop(ev) {
  ev.preventDefault();

  /*var data = ev.dataTransfer.getData("text");
  ev.target.appendChild(document.getElementById(data));*/
  b=document.getElementById(ev.target.id).innerHTML;
  document.getElementById(ev.target.id).innerHTML=a;
  document.getElementById(el).innerHTML=b;
  stockage=document.getElementById(ev.target.id).nextElementSibling.value
  document.getElementById(ev.target.id).nextElementSibling.value=document.getElementById(el).nextElementSibling.value;
document.getElementById(el).nextElementSibling.value=stockage;
}
</script>



@endsection