<!DOCTYPE html>
<html>
<head>
  <style>
.tool {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black;
}

.tool .toolt {
  visibility: hidden;
  width: 120px;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;

  /* Position the tool */
  position: absolute;
  z-index: 1;
}

.tool:hover .toolt {
  visibility: visible;
}
</style>
<style>

.month {
  padding: 70px 25px;
  width: 100%;
  background: #1abc9c;
  text-align: center;
}

.month ul {
  margin: 0;
  padding: 0;
}

.month ul li {
  color: white;
  font-size: 20px;
  text-transform: uppercase;
  letter-spacing: 3px;
}

.month .prev {
  float: left;
  padding-top: 10px;
}

.month .next {
  float: right;
  padding-top: 10px;
}

.weekdays {
  margin: 0;
  padding: 10px 0;
  background-color: #ddd;
}

.weekdays li {
  display: inline-block;
  width: 13.6%;
  color: #666;
  text-align: center;
}

.days {
  padding: 10px 0;
  background: #eee;
  margin: 0;
}
.cache{
  display: none;
}
.days li {
  list-style-type: none;
  display: inline-block;
  width: 13.6%;
  text-align: center;
  margin-bottom: 5px;
  font-size:12px;
  color: #777;
}

.days li .active {
  padding: 5px;
  background: #1abc9c;
  color: white !important
}
.exist {
  padding: 5px;
  background: rgb(153,150,205);
  color: white !important
}
.full {
  padding: 5px;
  background: rgb(68,65,137);
  color: white !important
}
/* Add media queries for smaller screens */
@media screen and (max-width:720px) {
  .weekdays li, .days li {width: 13.1%;}
}

@media screen and (max-width: 420px) {
  .weekdays li, .days li {width: 12.5%;}
  .days li .active {padding: 2px;}
}

@media screen and (max-width: 290px) {
  .weekdays li, .days li {width: 12.2%;}
}
</style>
</head>
<body>
<span class="cache">{{$d = Date('y-m-t')}}</span>
<span class="cache">{{$au = Date('y-m-d')}}</span>
   <span class="cache">{{$p = Date('y-m-01')}}</span>
   <span class="cache">{{$nbJour = Date('y-m-07')}}</span>

<div class="month">      
  <ul>
   <!--  <li class="prev">&#10094;</li>
    <li class="next">&#10095;</li> -->
    <li>
      {{date("F", strtotime($au))}}<br>
      <span style="font-size:18px">{{date("y", strtotime($au))}}</span>
    </li>
  </ul>
</div>

<ul class="weekdays">
  @for ($date = strtotime($p); $date <= strtotime($nbJour); $date = strtotime("+1 day", $date)) 
  <li>{{date("D", $date)}}</li>
  @endfor
</ul>

   
<ul class="days">
  @for ($date = strtotime($p); $date <= strtotime($d); $date = strtotime("+1 day", $date)) 
  <span class="cache">{{$a=0}}</span>
    @foreach($rdvs as $rdv)
      @if(date("y/m/d", strtotime($rdv->date))==date("y/m/d",$date) and $rdv->compte<=4)
                <li>
                  <div class="tool"><span class="exist">{{date("d", strtotime($rdv->date))}} </span>
                    @if(Auth::user()->role=='superadmin')
                  <span class="toolt exist">
                     @foreach($rdvdetails as $rdvdetail)
                        @if(date("y/m/d", strtotime($rdvdetail->date))==date("y/m/d",$date))
                        {{$rdvdetail->entreprise}} {{$rdvdetail->heure}}<br>
                        @endif
                      @endforeach
                  </span>
                  @endif
                </div>
                </li>
                <span class="cache"> {{$a=1}}</span>
      @elseif(date("y/m/d", strtotime($rdv->date))==date("y/m/d",$date) and $rdv->compte>4)
      <li><div class="tool"><span class="full">{{date("d", strtotime($rdv->date))}} </span>
               @if(Auth::user()->role=='superadmin')
                  <span class="toolt exist">
                     @foreach($rdvdetails as $rdvdetail)
                        @if(date("y/m/d", strtotime($rdvdetail->date))==date("y/m/d",$date))
                        {{$rdvdetail->entreprise}} {{$rdvdetail->heure}}<br>
                        @endif
                      @endforeach
                  </span>
                  @endif
                </div></li>
                <span class="cache"> {{$a=1}}</span>
      @endif
    @endforeach
      @if($a==0)
        @if(date("d", $date)==date("d", strtotime($au)))
            <li><span class="active">{{date("d", $date)}}</span></li>
        @else
          <li>
            <span hidden>{{$a=0}}</span>
            @foreach($datebloquees as $datebloquee)
              @if($datebloquee->datebloque==date('Y-m-d',$date))
              <span hidden>{{$a=$datebloquee->id}}</span>
                
                
              @endif
            @endforeach
            @if($a==0)
            <div class="tool">{{date("d", $date)}}
              @if(Auth::user()->role=='superadmin')
                  <span class="toolt exist">
                    <form action="{{route('rdv.bloquer')}}" method="post">
                      @csrf
                      <input type="text" name="date" value="{{date('Y/m/d',$date)}}" hidden>
                      <button class="btn btn-danger">Bloquer</button>
                    </form>
                  </span>
              @endif
            </div>
            @else
            <div class="tool"><span style="background: red">{{date("d", $date)}}</span>
              @if(Auth::user()->role=='superadmin')
                  <span class="toolt exist">
                      <a href="/rdv/debloquer/{{$datebloquee->id}}" class="btn btn-danger">Débloquer</a>
                  </span>
                </div>
              @endif
            @endif
          </li>
        @endif
      @endif
  @endfor
</ul>


</body>
</html>
