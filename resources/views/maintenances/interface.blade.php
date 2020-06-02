@extends('dashboard.dashboard')
@section('style')
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
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