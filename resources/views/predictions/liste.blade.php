@extends('dashboard.dashboard')
@section('style')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
  <style type="text/css">
    .tableau{
      border: 1px solid black;
    }
    
  </style>
@endsection
@section('content')
<div class="card col-12">
            <div class="card-header">Prédiction</div>
            <div class="card-body">
              <form action="{{route('prediction.store')}}" method="post">
                @csrf
                <div class="form-group row">
                <input type="date" class="form-control col-2" name="date">
                <button class="btn btn-primary col-1">Valider</button>
              </div>
              </form> 
              @if(!isset($datefin) or $datefin<(date('Y-m-d')))
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Immatriculation</th>
                  <th>Entreprise</th>
                  <th>Données initiales</th>
                  <th>Données Finales</th>
                  <th>Prédiction<BR> hauteur de gomme</th>
                  <th>Permutation</th>
                  <th>Pression</th>
                  @if(Auth::user()->role=='superadmin')
                  <th>Action</th>
                  @endif
                </tr>
                </thead>
                <tbody>
                    @foreach($vehicules as $vehicule)
                    <div class="modal fade" id="alert{{$vehicule->id}}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Message d'alerte</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form method="post" action="{{route('predictions.alert')}}">
                              @csrf
                              <input type="text" name="id" value="{{$vehicule->id}}" hidden>
                              <textarea class="form-control" name="texte" placeholder="Si vous mettez rien, on envoie un message par défaut"></textarea>
                              <button class="btn btn-primary">Alerter</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    @if(isset(unserialize($vehicule->t1)[1]) and isset(unserialize($vehicule->t2)[1]))
                  <tr>
                      <td>{{$vehicule->immatriculation}}</td>
                      <td>{{$vehicule->entreprise}}</td>
                      <td width="320px">
                        @if(count(unserialize($vehicule->t1))==8)
                          {{date('d/m/Y',strtotime(unserialize($vehicule->t1)[7]))}}
                        @else
                          {{date('d/m/Y',strtotime(unserialize($vehicule->t1)[5]))}}
                        @endif
                          <div class="row" style="width: 9cm">
                          @if(unserialize($vehicule->etatPneu)[0]<3)
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->t1)[0]}} mm<br>
                          </div>
                          @else
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: green">               
                           {{unserialize($vehicule->t1)[0]}} mm<br>
                          </div>
                          @endif
                          @if(unserialize($vehicule->etatPneu)[1]<3)
                          <div class="col-3 tableau" style="background: red">       
                             {{unserialize($vehicule->t1)[1]}} mm<br>
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">               
                           {{unserialize($vehicule->t1)[1]}} mm<br>
                          </div>
                          <div class="col-3"></div>
                          @endif
                        </div>
                        <div class="row" style="width: 9cm">
                          @if(isset(unserialize($vehicule->etatPneu)[4]))
                          @if(unserialize($vehicule->etatPneu)[4]<3)
                            <div class="col-3 tableau" style="background: red">       
                               {{unserialize($vehicule->t1)[4]}} mm<br>
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">            
                             {{unserialize($vehicule->t1)[4]}} mm<br>
                            </div>
                            @endif
                          @else
                            <div class="col-3"></div> 
                          @endif
                          @if(unserialize($vehicule->etatPneu)[2]<3)
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->t1)[2]}} mm<br>
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->t1)[2]}} mm<br>
                          </div>
                          @endif
                          @if(unserialize($vehicule->etatPneu)[3]<3)
                          <div class="col-3 tableau" style="background: red">       
                             {{unserialize($vehicule->t1)[3]}} mm<br>
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">               
                            {{unserialize($vehicule->t1)[3]}} mm<br>
                          </div>
                          @endif
                          @if(isset(unserialize($vehicule->etatPneu)[5]))
                          @if(unserialize($vehicule->etatPneu)[5]<3)
                            <div class="col-3 tableau" style="background: red">       
                             {{unserialize($vehicule->t1)[5]}} mm<br>
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">             
                             {{unserialize($vehicule->t1)[5 ]}} mm<br>
                            </div>
                            @endif
                          @endif
                        </div>
                        Kilomètrage :
                        @if(count(unserialize($vehicule->t2))==8)
                            {{unserialize($vehicule->t1)[6]}} km
                        @else
                            {{unserialize($vehicule->t1)[4]}} km
                        @endif
                      </td>
                      <td width="320px">
                        @if(count(unserialize($vehicule->t1))==8)
                          {{date('d/m/Y',strtotime(unserialize($vehicule->t2)[7]))}}
                        @else
                          {{date('d/m/Y',strtotime(unserialize($vehicule->t2)[5]))}}
                        @endif
                          <div class="row" style="width: 9cm">
                          @if(unserialize($vehicule->etatPneu)[0]<3)
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->t2)[0]}} mm<br>
                          </div>
                          @else
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: green">               
                           {{unserialize($vehicule->t2)[0]}} mm<br>
                          </div>
                          @endif
                          @if(unserialize($vehicule->etatPneu)[1]<3)
                          <div class="col-3 tableau" style="background: red">       
                             {{unserialize($vehicule->t2)[1]}} mm<br>
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">               
                           {{unserialize($vehicule->t2)[1]}} mm<br>
                          </div>
                          <div class="col-3"></div>
                          @endif
                        </div>
                        <div class="row" style="width: 9cm">
                          @if(isset(unserialize($vehicule->etatPneu)[4]))
                          @if(unserialize($vehicule->etatPneu)[4]<3)
                            <div class="col-3 tableau" style="background: red">       
                               {{unserialize($vehicule->t2)[4]}} mm<br>
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">            
                             {{unserialize($vehicule->t2)[4]}} mm<br>
                            </div>
                            @endif
                          @else
                            <div class="col-3"></div> 
                          @endif
                          @if(unserialize($vehicule->etatPneu)[2]<3)
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->t2)[2]}} mm<br>
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->t2)[2]}} mm<br>
                          </div>
                          @endif
                          @if(unserialize($vehicule->etatPneu)[3]<3)
                          <div class="col-3 tableau" style="background: red">       
                             {{unserialize($vehicule->t2)[3]}} mm<br>
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">               
                            {{unserialize($vehicule->t2)[3]}} mm<br>
                          </div>
                          @endif
                          @if(isset(unserialize($vehicule->etatPneu)[5]))
                          @if(unserialize($vehicule->etatPneu)[5]<3)
                            <div class="col-3 tableau" style="background: red">       
                             {{unserialize($vehicule->t2)[5]}} mm<br>
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">             
                             {{unserialize($vehicule->t2)[5 ]}} mm<br>
                            </div>
                            @endif
                          @endif
                        </div>
                        Kilomètrage :
                        @if(count(unserialize($vehicule->t2))==8)
                            {{unserialize($vehicule->t2)[6]}} km
                        @else
                            {{unserialize($vehicule->t2)[4]}} km
                        @endif
                      </td>
                      <td width="340px">
                        @if(count(unserialize($vehicule->t2))==8)
                        <span hidden>{{$diff=(strtotime(unserialize($vehicule->t2)[7])-strtotime(unserialize($vehicule->t1)[7]))/86400}}
                          {{$dated=$vehicule->control}}
                          {{$datec=$vehicule->control}}
                          {{$tab[0]=unserialize($vehicule->hGomme)[0]}}{{$tab[1]=unserialize($vehicule->hGomme)[1]}}{{$tab[2]=unserialize($vehicule->hGomme)[2]}}{{$tab[3]=unserialize($vehicule->hGomme)[3]}}{{$tab[4]=unserialize($vehicule->hGomme)[4]}}{{$tab[5]=unserialize($vehicule->hGomme)[5]}}
                        {{$today=date('d/m/Y')}}</span>
                        @else
                       <span hidden>{{$diff=(strtotime(unserialize($vehicule->t2)[5])-strtotime(unserialize($vehicule->t1)[5]))/86400}}
                        {{$dated=$vehicule->control}}
                        {{$datec=$vehicule->control}}
                        {{$tab[0]=unserialize($vehicule->hGomme)[0]}}{{$tab[1]=unserialize($vehicule->hGomme)[1]}}{{$tab[2]=unserialize($vehicule->hGomme)[2]}}{{$tab[3]=unserialize($vehicule->hGomme)[3]}}
                        {{$today=date('d/m/Y')}}</span>
                        @endif
                        <span hidden>

                        @if($diff<=0)
                          {{$diff=1}}
                        @endif
                          {{$stop=0}}{{$count=0}}
                        @while($stop!=1)
                          @for($i=0;$i<count(unserialize($vehicule->hGomme));$i++)
                            {{$tab[$i]=$tab[$i]-(unserialize($vehicule->t1)[$i]-unserialize($vehicule->t2)[$i])/$diff}}
                            @if($tab[$i]<1.6)
                              {{$stop=1}}
                            @endif
                          @endfor
                          {{$count++}}
                        @endwhile
                        {{$nbPneu=0}}
                        @for($i=0;$i<count(unserialize($vehicule->hGomme));$i++)
                            @if($tab[$i]<1.6)
                            {{$nbPneu++}}
                            @endif
                        @endfor
                        </span>

                          <span hidden><!-- {{$difference=((strtotime($datec)-strtotime($dated))/86400)}} -->
                            {{$dateprevu=date('y-m-d',strtotime($datec)+86400*$count)}}
                          {{$countAu=(strtotime($dateprevu)-strtotime(date('y-m-d')))/86400}}</span>
                        Dans {{$countAu}} jours soit le {{date('d/m/Y',strtotime($dateprevu))}}<br>
                        {{$nbPneu}} pneus à remplacer
                        <div class="row" style="width: 9cm">
                          @if(unserialize($vehicule->etatPneu)[0]<3)
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: red">       
                            {{round($tab[0],2)}} mm<br>
                            {{round((unserialize($vehicule->t1)[0]-unserialize($vehicule->t2)[0])/$diff,2)}}mm/j
                          </div>
                          @else
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: green">               
                           {{round($tab[0],2)}} mm<br>
                            {{round((unserialize($vehicule->t1)[0]-unserialize($vehicule->t2)[0])/$diff,2)}}mm/j
                          </div>
                          @endif
                          @if(unserialize($vehicule->etatPneu)[1]<3)
                          <div class="col-3 tableau" style="background: red">       
                             {{round($tab[1],2)}} mm<br>
                            {{round((unserialize($vehicule->t1)[1]-unserialize($vehicule->t2)[1])/$diff,2)}}mm/j
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">               
                           {{round($tab[1],2)}} mm<br>
                            {{round((unserialize($vehicule->t1)[1]-unserialize($vehicule->t2)[1])/$diff,2)}}mm/j
                          </div>
                          <div class="col-3"></div>
                          @endif
                        </div>
                        <div class="row" style="width: 9cm">
                          @if(isset(unserialize($vehicule->etatPneu)[4]))
                          @if(unserialize($vehicule->etatPneu)[4]<3)
                            <div class="col-3 tableau" style="background: red">       
                               {{round($tab[4],2)}} mm<br>
                              {{round((unserialize($vehicule->t1)[4]-unserialize($vehicule->t2)[4])/$diff,2)}}mm/j
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">            
                             {{round($tab[4],2)}} mm<br>
                              {{round((unserialize($vehicule->t1)[4]-unserialize($vehicule->t2)[4])/$diff,2)}}mm/j
                            </div>
                            @endif
                          @else
                            <div class="col-3"></div> 
                          @endif
                          @if(unserialize($vehicule->etatPneu)[2]<3)
                          <div class="col-3 tableau" style="background: red">       
                            {{round($tab[2],2)}} mm<br>
                            {{round((unserialize($vehicule->t1)[2]-unserialize($vehicule->t2)[2])/$diff,2)}}mm/j
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">                  
                            {{round($tab[2],2)}} mm<br>
                              {{round((unserialize($vehicule->t1)[2]-unserialize($vehicule->t2)[2])/$diff,2)}}mm/j
                          </div>
                          @endif
                          @if(unserialize($vehicule->etatPneu)[3]<3)
                          <div class="col-3 tableau" style="background: red">       
                            {{round($tab[3],2)}} mm<br>
                            {{round((unserialize($vehicule->t1)[3]-unserialize($vehicule->t2)[3])/$diff,2)}}mm/j
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">               
                            {{round($tab[3],2)}} mm<br>
                            {{round((unserialize($vehicule->t1)[3]-unserialize($vehicule->t2)[3])/$diff,2)}}mm/j
                          </div>
                          @endif
                          @if(isset(unserialize($vehicule->etatPneu)[5]))
                          @if(unserialize($vehicule->etatPneu)[5]<3)
                            <div class="col-3 tableau" style="background: red">       
                              {{round($tab[5],2)}} mm<br>
                             {{round((unserialize($vehicule->t1)[5]-unserialize($vehicule->t2)[5])/$diff,2)}}mm/j
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">             
                              {{round($tab[5],2)}} mm<br>
                               {{round((unserialize($vehicule->t1)[5]-unserialize($vehicule->t2)[5])/$diff,2)}}mm/j
                            </div>
                            @endif
                          @endif
                        </div>
                      </td>
                      <td>
                        Permutation dans
                         @if(count(unserialize($vehicule->t2))==8)
                        <!-- {{round(unserialize($vehicule->t2)[6]-(((unserialize($vehicule->t1)[6]-unserialize($vehicule->t2)[6])/$diff))*$difference,2)}} km -->
                        <span hidden>
                          {{$k=$vehicule->kilometrage}}
                          {{$countk=0}}
                          @while($k<10000)
                          {{$k=$k+(unserialize($vehicule->t2)[6]-unserialize($vehicule->t1)[6])/$diff}}
                          {{$countk++}}
                          @endwhile
                          {{$dateprevuk=date('y-m-d',strtotime($datec)+86400*$countk)}}
                          {{$countAuk=(strtotime($dateprevuk)-strtotime(date('y-m-d')))/86400}}
                        </span>
                        {{$countAuk}} jours soit le
                        {{date('d/m/Y',strtotime($dateprevuk))}}<br>
                          ({{round((unserialize($vehicule->t2)[6]-unserialize($vehicule->t1)[6])/$diff,2)}}
                           km/j)
                       @else
                       <span hidden>
                          {{$k=$vehicule->kilometrage}}
                          {{$countk=0}}
                          @while($k<10000)
                          {{$k=$k+(unserialize($vehicule->t2)[4]-unserialize($vehicule->t1)[4])/$diff}}
                          {{$countk++}}
                          @endwhile
                           {{$dateprevuk=date('y-m-d',strtotime($datec)+86400*$countk)}}
                          {{$countAuk=(strtotime($dateprevuk)-strtotime(date('y-m-d')))/86400}}
                        </span>
                        {{$countAuk}} j ou
                        {{date('d/m/Y',strtotime($dateprevuk))}}<br>
                         ({{round((unserialize($vehicule->t2)[4]-unserialize($vehicule->t1)[4])/$diff,2)}} km/j)
                       @endif

                      </td>
                      <td>
                        <!-- <span hidden>
                          {{$inf=20}}
                          @for($i=0;$i<count(unserialize($vehicule->etatPneu));$i++)
                            @if(unserialize($vehicule->etatPneu)[$i]<$inf)
                              {{$inf=unserialize($vehicule->etatPneu)[$i]}}
                            @endif
                          @endfor
                          {{$countp=((3-$inf)/-0.1)*30}}
                          {{$dateprevup=date('y-m-d',strtotime($datec)+86400*$countp)}}
                          {{$countAup=(strtotime($dateprevup)-strtotime(date('y-m-d')))/86400}}
                        </span>
                        @if($countAup<0)
                        Pression dans  {{abs($countAup)}} jours passés soit le 
                        @else
                        Pression dans  {{abs($countAup)}} jours soit le
                        @endif
                        {{date('d/m/Y',strtotime($dateprevup))}} -->
                        Dans {{$countP=30-(strtotime(date('Y-m-d'))-strtotime($vehicule->derniereMaintenance))/86400}} jours
                      </td>
                      @if(Auth::user()->role=='superadmin')
                      <td>
                        @if($vehicule->alertP==0)
                         <a  type="button" class="btn btn-danger" data-toggle="modal" data-target="#alert{{$vehicule->id}}">
                          Alerter
               </a>      
                        @else
                        <button type="button" class="btn btn-danger" disabled="true">
                          Alerter
                        </button>
                        @endif
                      </td>
                      @endif
                  </tr>
                  @elseif(isset(unserialize($vehicule->t1)[1]) and !isset(unserialize($vehicule->t2)[1]))
                    <tr>
                      <td>{{$vehicule->immatriculation}}</td>
                      <td>{{$vehicule->entreprise}}</td>
                      <td>{{date('d/m/Y',strtotime($vehicule->dateC))}}
                        <br>Kilomètrage : 0 km
                      </td>
                      <td>{{date('d/m/Y',strtotime($vehicule->control))}}
                        <br>Kilomètrage : {{$vehicule->kilometrage}} km</td>
                        <td>@if(count(unserialize($vehicule->t1))==8)
                          {{date('d/m/Y',strtotime(unserialize($vehicule->t1)[7]))}}
                        @else
                          {{date('d/m/Y',strtotime(unserialize($vehicule->t1)[5]))}}
                        @endif
                          <div class="row" style="width: 9cm">
                          @if(unserialize($vehicule->etatPneu)[0]<3)
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->t1)[0]}} mm<br>
                          </div>
                          @else
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: green">               
                           {{unserialize($vehicule->t1)[0]}} mm<br>
                          </div>
                          @endif
                          @if(unserialize($vehicule->etatPneu)[1]<3)
                          <div class="col-3 tableau" style="background: red">       
                             {{unserialize($vehicule->t1)[1]}} mm<br>
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">               
                           {{unserialize($vehicule->t1)[1]}} mm<br>
                          </div>
                          <div class="col-3"></div>
                          @endif
                        </div>
                        <div class="row" style="width: 9cm">
                          @if(isset(unserialize($vehicule->etatPneu)[4]))
                          @if(unserialize($vehicule->etatPneu)[4]<3)
                            <div class="col-3 tableau" style="background: red">       
                               {{unserialize($vehicule->t1)[4]}} mm<br>
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">            
                             {{unserialize($vehicule->t1)[4]}} mm<br>
                            </div>
                            @endif
                          @else
                            <div class="col-3"></div> 
                          @endif
                          @if(unserialize($vehicule->etatPneu)[2]<3)
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->t1)[2]}} mm<br>
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->t1)[2]}} mm<br>
                          </div>
                          @endif
                          @if(unserialize($vehicule->etatPneu)[3]<3)
                          <div class="col-3 tableau" style="background: red">       
                             {{unserialize($vehicule->t1)[3]}} mm<br>
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">               
                            {{unserialize($vehicule->t1)[3]}} mm<br>
                          </div>
                          @endif
                          @if(isset(unserialize($vehicule->etatPneu)[5]))
                          @if(unserialize($vehicule->etatPneu)[5]<3)
                            <div class="col-3 tableau" style="background: red">       
                             {{unserialize($vehicule->t1)[5]}} mm<br>
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">             
                             {{unserialize($vehicule->t1)[5 ]}} mm<br>
                            </div>
                            @endif
                          @endif
                        </div></td>
                        <td>
                          <span hidden>
                            @if($vehicule->kilometrage==0 and count(unserialize($vehicule->t1))==8)
                            {{$isa=(strtotime($vehicule->control)-strtotime($vehicule->dateC))/86400}}:
                            {{$jour=($isa*10000)/unserialize($vehicule->t1)[6]}}
                             {{$dateper=date('y-m-d',strtotime($vehicule->control)+86400*$jour)}}
                            {{$countPer=(strtotime($dateper)-strtotime(date('y-m-d')))/86400}}
                            {{$countPer=$countPer+(strtotime($vehicule->control)-strtotime(unserialize($vehicule->t1)[7]))/86400}}
                            @elseif($vehicule->kilometrage==0 and count(unserialize($vehicule->t1))==6)
                            {{$isa=(strtotime($vehicule->control)-strtotime($vehicule->dateC))/86400}}:
                            {{$jour=($isa*10000)/unserialize($vehicule->t1)[4]}}
                             {{$dateper=date('y-m-d',strtotime($vehicule->control)+86400*$jour)}}
                            {{$countPer=(strtotime($dateper)-strtotime(date('y-m-d')))/86400}}
                            {{$countPer=$countPer+(strtotime($vehicule->control)-strtotime(unserialize($vehicule->t1)[5]))/86400}}
                            @else
                            {{$isa=(strtotime($vehicule->control)-strtotime($vehicule->dateC))/86400}}:
                            {{$jour=($isa*10000)/$vehicule->kilometrage}}{{$jour=$jour-$isa}}
                             {{$dateper=date('y-m-d',strtotime($vehicule->control)+86400*$jour)}}
                            {{$countPer=(strtotime($dateper)-strtotime(date('y-m-d')))/86400}}
                            @endif
                          </span>
                          Permutation dans {{$countPer}} jours soit le
                          {{date('d/m/Y',strtotime($dateper))}}
                          @if(isset(unserialize($vehicule->t1)[1]) and isset(unserialize($vehicule->t2)[1]))
                     
                     @if(count(unserialize($vehicule->t2))==8)
                        <span hidden>
                          {{$diff=(strtotime(unserialize($vehicule->t2)[7])-strtotime(unserialize($vehicule->t1)[7]))/86400}}
                          @if($diff==0){{$diff=1}}@endif
                        </span>
                       {{ (unserialize($vehicule->t2)[6]-unserialize($vehicule->t1)[6])/$diff}} km/jour
                       @else
                       <span hidden>
                          {{$diff=(strtotime(unserialize($vehicule->t2)[5])-strtotime(unserialize($vehicule->t1)[5]))/86400}}
                          @if($diff==0){{$diff=1}}@endif
                        </span>
                       {{ (unserialize($vehicule->t2)[4]-unserialize($vehicule->t1)[4])/$diff}} km/jour
                       @endif
                       @else
                          <span hidden>
                            @if(count(unserialize($vehicule->t1))==8)
                            {{$isa=(strtotime(unserialize($vehicule->t1)[7])-strtotime($vehicule->dateC))/86400}}
                            {{$kj=unserialize($vehicule->t1)[6]/$isa}}

                            @elseif(count(unserialize($vehicule->t1))==6)
                            {{$isa=(strtotime(unserialize($vehicule->t1)[5])-strtotime($vehicule->dateC))/86400}}
                            {{$kj=unserialize($vehicule->t1)[4]/$isa}}
                            @endif
                          </span>
                          ({{round($kj)}} km / jour)
                       @endif
                        </td>
                        <td>
                       <!-- <span hidden>
                           {{$inf=20}}
                          @for($i=0;$i<count(unserialize($vehicule->etatPneu));$i++)
                            @if(unserialize($vehicule->etatPneu)[$i]<$inf)
                              {{$inf=unserialize($vehicule->etatPneu)[$i]}}
                            @endif
                          @endfor
                          {{$countp=((3-$inf)/-0.1)*30}}
                          {{$dateprevup=date('y-m-d',strtotime($vehicule->control)+86400*$countp)}}
                          {{$countAup=(strtotime($dateprevup)-strtotime(date('y-m-d')))/86400}}
                        </span>
                        @if($countAup<0)
                        Pression dans  {{abs($countAup)}} jours passés soit le
                        @else
                        Pression dans  {{abs($countAup)}} jours soit le
                        @endif
                        {{date('d/m/Y',strtotime($dateprevup))}} -->
                        Dans {{$countP=30-(strtotime(date('Y-m-d'))-strtotime($vehicule->derniereMaintenance))/86400}} jours
                      </td>
                      @if(Auth::user()->role=='superadmin')
                        <td>
                        @if($vehicule->alertP==0)
                        <a  type="button" class="btn btn-danger" data-toggle="modal" data-target="#alert{{$vehicule->id}}">
                          Alerter
               </a> 
                        @else
                        <button type="button" class="btn btn-danger" disabled="true">
                          Alerter
                         </button>
                        @endif
                      </td>
                      @endif
                    </tr>
                     @endif
                     

                    @endforeach

                </tbody>
              </table>
              @else
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Immatriculation</th>
                  <th>Entreprise</th>
                  <th>Données initiales</th>
                  <th>Données Finales</th>
                  <th>Prédiction hauteur de gomme</th>
                  <th>Permutation</th>
                  <th>Pression</th>
                  @if(Auth::user()->role=='superadmin')
                  <th>Action</th>
                  @endif
                </tr>
                </thead>
                <tbody>
                    @foreach($vehicules as $vehicule)
                    @if(isset(unserialize($vehicule->t1)[1]) and isset(unserialize($vehicule->t2)[1]))
                  <tr>
                      <td>{{$vehicule->immatriculation}}</td>
                      <td>{{$vehicule->entreprise}}</td>
                      <td width="300px">
                        @if(count(unserialize($vehicule->t1))==8)
                          {{date('d/m/Y',strtotime(unserialize($vehicule->t1)[7]))}}
                        @else
                          {{date('d/m/Y',strtotime(unserialize($vehicule->t1)[5]))}}
                        @endif
                          <div class="row" style="width: 9cm">
                          @if(unserialize($vehicule->etatPneu)[0]<3)
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->t1)[0]}} mm<br>
                          </div>
                          @else
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: green">               
                           {{unserialize($vehicule->t1)[0]}} mm<br>
                          </div>
                          @endif
                          @if(unserialize($vehicule->etatPneu)[1]<3)
                          <div class="col-3 tableau" style="background: red">       
                             {{unserialize($vehicule->t1)[1]}} mm<br>
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">               
                           {{unserialize($vehicule->t1)[1]}} mm<br>
                          </div>
                          <div class="col-3"></div>
                          @endif
                        </div>
                        <div class="row" style="width: 9cm">
                          @if(isset(unserialize($vehicule->etatPneu)[4]))
                          @if(unserialize($vehicule->etatPneu)[4]<3)
                            <div class="col-3 tableau" style="background: red">       
                               {{unserialize($vehicule->t1)[4]}} mm<br>
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">            
                             {{unserialize($vehicule->t1)[4]}} mm<br>
                            </div>
                            @endif
                          @else
                            <div class="col-3"></div> 
                          @endif
                          @if(unserialize($vehicule->etatPneu)[2]<3)
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->t1)[2]}} mm<br>
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->t1)[2]}} mm<br>
                          </div>
                          @endif
                          @if(unserialize($vehicule->etatPneu)[3]<3)
                          <div class="col-3 tableau" style="background: red">       
                             {{unserialize($vehicule->t1)[3]}} mm<br>
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">               
                            {{unserialize($vehicule->t1)[3]}} mm<br>
                          </div>
                          @endif
                          @if(isset(unserialize($vehicule->etatPneu)[5]))
                          @if(unserialize($vehicule->etatPneu)[5]<3)
                            <div class="col-3 tableau" style="background: red">       
                             {{unserialize($vehicule->t1)[5]}} mm<br>
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">             
                             {{unserialize($vehicule->t1)[5 ]}} mm<br>
                            </div>
                            @endif
                          @endif
                        </div>
                        Kilomètrage :
                        @if(count(unserialize($vehicule->t2))==8)
                            {{unserialize($vehicule->t1)[6]}} km
                        @else
                            {{unserialize($vehicule->t1)[4]}} km
                        @endif
                      </td>
                      <td width="300px">
                        @if(count(unserialize($vehicule->t1))==8)
                          {{date('d/m/Y',strtotime(unserialize($vehicule->t2)[7]))}}
                        @else
                          {{date('d/m/Y',strtotime(unserialize($vehicule->t2)[5]))}}
                        @endif
                          <div class="row" style="width: 9cm">
                          @if(unserialize($vehicule->etatPneu)[0]<3)
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->t2)[0]}} mm<br>
                          </div>
                          @else
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: green">               
                           {{unserialize($vehicule->t2)[0]}} mm<br>
                          </div>
                          @endif
                          @if(unserialize($vehicule->etatPneu)[1]<3)
                          <div class="col-3 tableau" style="background: red">       
                             {{unserialize($vehicule->t2)[1]}} mm<br>
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">               
                           {{unserialize($vehicule->t2)[1]}} mm<br>
                          </div>
                          <div class="col-3"></div>
                          @endif
                        </div>
                        <div class="row" style="width: 9cm">
                          @if(isset(unserialize($vehicule->etatPneu)[4]))
                          @if(unserialize($vehicule->etatPneu)[4]<3)
                            <div class="col-3 tableau" style="background: red">       
                               {{unserialize($vehicule->t2)[4]}} mm<br>
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">            
                             {{unserialize($vehicule->t2)[4]}} mm<br>
                            </div>
                            @endif
                          @else
                            <div class="col-3"></div> 
                          @endif
                          @if(unserialize($vehicule->etatPneu)[2]<3)
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->t2)[2]}} mm<br>
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->t2)[2]}} mm<br>
                          </div>
                          @endif
                          @if(unserialize($vehicule->etatPneu)[3]<3)
                          <div class="col-3 tableau" style="background: red">       
                             {{unserialize($vehicule->t2)[3]}} mm<br>
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">               
                            {{unserialize($vehicule->t2)[3]}} mm<br>
                          </div>
                          @endif
                          @if(isset(unserialize($vehicule->etatPneu)[5]))
                          @if(unserialize($vehicule->etatPneu)[5]<3)
                            <div class="col-3 tableau" style="background: red">       
                             {{unserialize($vehicule->t2)[5]}} mm<br>
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">             
                             {{unserialize($vehicule->t2)[5 ]}} mm<br>
                            </div>
                            @endif
                          @endif
                        </div>
                        Kilomètrage :
                        @if(count(unserialize($vehicule->t2))==8)
                            {{unserialize($vehicule->t2)[6]}} km
                        @else
                            {{unserialize($vehicule->t2)[4]}} km
                        @endif
                      </td>
                      <td width="340px">
                        @if(count(unserialize($vehicule->t2))==8)
                        <span hidden>{{$diff=(strtotime(unserialize($vehicule->t2)[7])-strtotime(unserialize($vehicule->t1)[7]))/86400}}
                          {{$dated=$vehicule->control}}
                          {{$datec=$vehicule->control}}
                          {{$tab[0]=unserialize($vehicule->hGomme)[0]}}{{$tab[1]=unserialize($vehicule->hGomme)[1]}}{{$tab[2]=unserialize($vehicule->hGomme)[2]}}{{$tab[3]=unserialize($vehicule->hGomme)[3]}}{{$tab[4]=unserialize($vehicule->hGomme)[4]}}{{$tab[5]=unserialize($vehicule->hGomme)[5]}}
                        {{$today=date('d/m/Y')}}</span>
                        @else
                       <span hidden>{{$diff=(strtotime(unserialize($vehicule->t2)[5])-strtotime(unserialize($vehicule->t1)[5]))/86400}}
                        {{$dated=$vehicule->control}}
                        {{$datec=$vehicule->control}}
                        {{$tab[0]=unserialize($vehicule->hGomme)[0]}}{{$tab[1]=unserialize($vehicule->hGomme)[1]}}{{$tab[2]=unserialize($vehicule->hGomme)[2]}}{{$tab[3]=unserialize($vehicule->hGomme)[3]}}
                        {{$today=date('d/m/Y')}}</span>
                        @endif
                        <span hidden>

                        @if($diff<=0)
                          {{$diff=1}}
                        @endif
                          {{$stop=0}}{{$count=0}}
                          {{$countdiff=(strtotime($datefin)-strtotime(date('Y-m-d')))/86400}}
                        @while($count<$countdiff)
                          @for($i=0;$i<count(unserialize($vehicule->hGomme));$i++)
                            {{$tab[$i]=$tab[$i]-(unserialize($vehicule->t1)[$i]-unserialize($vehicule->t2)[$i])/$diff}}
                           <!--  @if($tab[$i]<1.6)
                              {{$stop=1}}
                            @endif -->
                          @endfor
                          {{$count++}}
                        @endwhile
                        {{$nbPneu=0}}
                        @for($i=0;$i<count(unserialize($vehicule->hGomme));$i++)
                            @if($tab[$i]<1.6)
                            {{$nbPneu++}}
                            @endif
                        @endfor
                        </span>

                          <span hidden><!-- {{$difference=((strtotime($datec)-strtotime($dated))/86400)}} -->
                            {{$dateprevu=date('y-m-d',strtotime($datec)+86400*$count)}}
                          {{$countAu=(strtotime($dateprevu)-strtotime(date('y-m-d')))/86400}}</span>
                        Dans {{$countAu}} jours soit le {{date('d/m/Y',strtotime($dateprevu))}}<br>
                        {{$nbPneu}} pneus à remplacer
                        <div class="row" style="width: 9cm">
                          @if(unserialize($vehicule->etatPneu)[0]<3)
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: red">       
                            {{round($tab[0],2)}} mm<br>
                            {{round((unserialize($vehicule->t1)[0]-unserialize($vehicule->t2)[0])/$diff,2)}}mm/j
                          </div>
                          @else
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: green">               
                           {{round($tab[0],2)}} mm<br>
                            {{round((unserialize($vehicule->t1)[0]-unserialize($vehicule->t2)[0])/$diff,2)}}mm/j
                          </div>
                          @endif
                          @if(unserialize($vehicule->etatPneu)[1]<3)
                          <div class="col-3 tableau" style="background: red">       
                             {{round($tab[1],2)}} mm<br>
                            {{round((unserialize($vehicule->t1)[1]-unserialize($vehicule->t2)[1])/$diff,2)}}mm/j
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">               
                           {{round($tab[1],2)}} mm<br>
                            {{round((unserialize($vehicule->t1)[1]-unserialize($vehicule->t2)[1])/$diff,2)}}mm/j
                          </div>
                          <div class="col-3"></div>
                          @endif
                        </div>
                        <div class="row" style="width: 9cm">
                          @if(isset(unserialize($vehicule->etatPneu)[4]))
                          @if(unserialize($vehicule->etatPneu)[4]<3)
                            <div class="col-3 tableau" style="background: red">       
                               {{round($tab[4],2)}} mm<br>
                              {{round((unserialize($vehicule->t1)[4]-unserialize($vehicule->t2)[4])/$diff,2)}}mm/j
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">            
                             {{round($tab[4],2)}} mm<br>
                              {{round((unserialize($vehicule->t1)[4]-unserialize($vehicule->t2)[4])/$diff,2)}}mm/j
                            </div>
                            @endif
                          @else
                            <div class="col-3"></div> 
                          @endif
                          @if(unserialize($vehicule->etatPneu)[2]<3)
                          <div class="col-3 tableau" style="background: red">       
                            {{round($tab[2],2)}} mm<br>
                            {{round((unserialize($vehicule->t1)[2]-unserialize($vehicule->t2)[2])/$diff,2)}}mm/j
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">                  
                            {{round($tab[2],2)}} mm<br>
                              {{round((unserialize($vehicule->t1)[2]-unserialize($vehicule->t2)[2])/$diff,2)}}mm/j
                          </div>
                          @endif
                          @if(unserialize($vehicule->etatPneu)[3]<3)
                          <div class="col-3 tableau" style="background: red">       
                            {{round($tab[3],2)}} mm<br>
                            {{round((unserialize($vehicule->t1)[3]-unserialize($vehicule->t2)[3])/$diff,2)}}mm/j
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">               
                            {{round($tab[3],2)}} mm<br>
                            {{round((unserialize($vehicule->t1)[3]-unserialize($vehicule->t2)[3])/$diff,2)}}mm/j
                          </div>
                          @endif
                          @if(isset(unserialize($vehicule->etatPneu)[5]))
                          @if(unserialize($vehicule->etatPneu)[5]<3)
                            <div class="col-3 tableau" style="background: red">       
                              {{round($tab[5],2)}} mm<br>
                             {{round((unserialize($vehicule->t1)[5]-unserialize($vehicule->t2)[5])/$diff,2)}}mm/j
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">             
                              {{round($tab[5],2)}} mm<br>
                               {{round((unserialize($vehicule->t1)[5]-unserialize($vehicule->t2)[5])/$diff,2)}}mm/j
                            </div>
                            @endif
                          @endif
                        </div>
                      </td>
                      <td>
                         @if(count(unserialize($vehicule->t2))==8)
                        <!-- {{round(unserialize($vehicule->t2)[6]-(((unserialize($vehicule->t1)[6]-unserialize($vehicule->t2)[6])/$diff))*$difference,2)}} km -->
                        <span hidden>
                          {{$k=$vehicule->kilometrage}}
                          {{$countk=0}}
                          @while($countk<$countdiff)
                          {{$k=$k+(unserialize($vehicule->t2)[6]-unserialize($vehicule->t1)[6])/$diff}}
                          {{$countk++}}
                          @endwhile
                          {{$dateprevuk=date('y-m-d',strtotime($datec)+86400*$countk)}}
                          {{$countAuk=(strtotime($dateprevuk)-strtotime($datefin))/86400}}
                        </span>
                        {{date('d/m/Y',strtotime($datefin))}}<br>{{$k}} km<br>
                          ({{round((unserialize($vehicule->t2)[6]-unserialize($vehicule->t1)[6])/$diff,2)}}
                           km/j)
                       @else
                        <span hidden>
                          {{$k=$vehicule->kilometrage}}
                          {{$countk=0}}
                          @while($countk<$countdiff)
                          {{$k=$k+(unserialize($vehicule->t2)[4]-unserialize($vehicule->t1)[4])/$diff}}
                          {{$countk++}}
                          @endwhile
                           {{$dateprevuk=date('y-m-d',strtotime($datec)+86400*$countk)}}
                          {{$countAuk=(strtotime($dateprevuk)-strtotime($datefin))/86400}}
                        </span>
                        {{date('d/m/Y',strtotime($datefin))}}<br>{{$k}} km<br>
                         ({{round((unserialize($vehicule->t2)[4]-unserialize($vehicule->t1)[4])/$diff,2)}} km/j)
                       @endif

                      </td>
                      <td>
                       <!--  <span hidden>
                          {{$inf=20}}
                          @for($i=0;$i<count(unserialize($vehicule->etatPneu));$i++)
                            @if(unserialize($vehicule->etatPneu)[$i]<$inf)
                              {{$inf=unserialize($vehicule->etatPneu)[$i]}}
                            @endif
                          @endfor
                          {{$countp=((3-$inf)/-0.1)*30}}
                          {{$dateprevup=date('y-m-d',strtotime($datec)+86400*$countp)}}
                          {{$countAup=(strtotime($dateprevup)-strtotime($datefin))/86400}}
                        </span>
                        @if($countAup<0)
                        Pression dans  {{abs($countAup)}} jours passés soit le
                        @else
                        Pression dans  {{abs($countAup)}} jours soit le
                        @endif
                        ({{date('d/m/Y',strtotime($dateprevup))}}) -->
                        Dans {{$countP=30-(strtotime(date('Y-m-d'))-strtotime($vehicule->derniereMaintenance))/86400}} jours
                      </td>
                      @if(Auth::user()->role=='superadmin')
                      <td>
                        @if($vehicule->alertP==0)
                         <a  type="button" class="btn btn-danger" data-toggle="modal" data-target="#alert{{$vehicule->id}}">
                          Alerter
                        </a>  
                        @else
                        <button type="button" class="btn btn-danger" disabled="true">
                          Alerter
                        </button>
                        @endif
                      </td>
                      @endif
                  </tr>
                  @elseif(isset(unserialize($vehicule->t1)[1]) and !isset(unserialize($vehicule->t2)[1]))
                    <tr>
                      <td>{{$vehicule->immatriculation}}</td>
                      <td>{{$vehicule->entreprise}}</td>
                      <td>{{date('d/m/Y',strtotime($vehicule->dateC))}}
                        <br>Kilomètrage : 0 km
                      </td>
                      <td>{{date('d/m/Y',strtotime($vehicule->control))}}
                        <br>Kilomètrage : {{$vehicule->kilometrage}} km</td>
                        <td>@if(count(unserialize($vehicule->t1))==8)
                          {{date('d/m/Y',strtotime(unserialize($vehicule->t1)[7]))}}
                        @else
                          {{date('d/m/Y',strtotime(unserialize($vehicule->t1)[5]))}}
                        @endif
                          <div class="row" style="width: 9cm">
                          @if(unserialize($vehicule->etatPneu)[0]<3)
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->t1)[0]}} mm<br>
                          </div>
                          @else
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: green">               
                           {{unserialize($vehicule->t1)[0]}} mm<br>
                          </div>
                          @endif
                          @if(unserialize($vehicule->etatPneu)[1]<3)
                          <div class="col-3 tableau" style="background: red">       
                             {{unserialize($vehicule->t1)[1]}} mm<br>
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">               
                           {{unserialize($vehicule->t1)[1]}} mm<br>
                          </div>
                          <div class="col-3"></div>
                          @endif
                        </div>
                        <div class="row" style="width: 9cm">
                          @if(isset(unserialize($vehicule->etatPneu)[4]))
                          @if(unserialize($vehicule->etatPneu)[4]<3)
                            <div class="col-3 tableau" style="background: red">       
                               {{unserialize($vehicule->t1)[4]}} mm<br>
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">            
                             {{unserialize($vehicule->t1)[4]}} mm<br>
                            </div>
                            @endif
                          @else
                            <div class="col-3"></div> 
                          @endif
                          @if(unserialize($vehicule->etatPneu)[2]<3)
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->t1)[2]}} mm<br>
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->t1)[2]}} mm<br>
                          </div>
                          @endif
                          @if(unserialize($vehicule->etatPneu)[3]<3)
                          <div class="col-3 tableau" style="background: red">       
                             {{unserialize($vehicule->t1)[3]}} mm<br>
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">               
                            {{unserialize($vehicule->t1)[3]}} mm<br>
                          </div>
                          @endif
                          @if(isset(unserialize($vehicule->etatPneu)[5]))
                          @if(unserialize($vehicule->etatPneu)[5]<3)
                            <div class="col-3 tableau" style="background: red">       
                             {{unserialize($vehicule->t1)[5]}} mm<br>
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">             
                             {{unserialize($vehicule->t1)[5 ]}} mm<br>
                            </div>
                            @endif
                          @endif
                        </div></td>
                        <td>
                          <span hidden>
                            @if($vehicule->kilometrage==0 and count(unserialize($vehicule->t1))==8)
                            {{$isa=(strtotime($vehicule->control)-strtotime($vehicule->dateC))/86400}}:
                            {{$jour=($isa*10000)/unserialize($vehicule->t1)[6]}}
                            {{$parj=unserialize($vehicule->t1)[6]/$isa}}
                             {{$dateper=date('y-m-d',strtotime($vehicule->control)+86400*$jour)}}
                            {{$countPer=(strtotime($dateper)-strtotime($datefin))/86400}}
                            {{$countPer=$countPer+(strtotime($vehicule->control)-strtotime(unserialize($vehicule->t1)[7]))/86400}}
                            @elseif($vehicule->kilometrage==0 and count(unserialize($vehicule->t1))==6)
                            {{$isa=(strtotime($vehicule->control)-strtotime($vehicule->dateC))/86400}}:
                            {{$parj=unserialize($vehicule->t1)[4]/$isa}}
                            {{$jour=($isa*10000)/unserialize($vehicule->t1)[4]}}
                             {{$dateper=date('y-m-d',strtotime($vehicule->control)+86400*$jour)}}
                            {{$countPer=(strtotime($dateper)-strtotime($datefin))/86400}}
                            {{$countPer=$countPer+(strtotime($vehicule->control)-strtotime(unserialize($vehicule->t1)[5]))/86400}}
                            @else
                            {{$isa=(strtotime($vehicule->control)-strtotime($vehicule->dateC))/86400}}:
                            {{$parj=$vehicule->kilometrage/$isa}}
                            {{$jour=($isa*10000)/$vehicule->kilometrage}}{{$jour=$jour-$isa}}
                             {{$dateper=date('y-m-d',strtotime($vehicule->control)+86400*$jour)}}
                            {{$countPer=(strtotime($dateper)-strtotime($datefin))/86400}}

                            @endif
                          </span>
                          {{date('d/m/Y',strtotime($datefin))}}<br>
                          {{round(($parj*(strtotime($datefin)-strtotime($vehicule->control))/86400)+$vehicule->kilometrage)}} km 
                          ({{round($parj)}} km/j)
                        </td>
                        <td>
                       <!--  <span hidden>
                          {{$inf=20}}
                          @for($i=0;$i<count(unserialize($vehicule->etatPneu));$i++)
                            @if(unserialize($vehicule->etatPneu)[$i]<$inf)
                              {{$inf=unserialize($vehicule->etatPneu)[$i]}}
                            @endif
                          @endfor
                          {{$countp=((3-$inf)/-0.1)*30}}
                          {{$dateprevup=date('y-m-d',strtotime($vehicule->control)+86400*$countp)}}
                          {{$countAup=(strtotime($dateprevup)-strtotime($datefin))/86400}}
                        </span>
                        @if($countAup<0)
                        Pression dans  {{abs($countAup)}} jours passés soit le
                        @else
                        Pression dans  {{abs($countAup)}} jours soit le
                        @endif
                        ({{date('d/m/Y',strtotime($dateprevup))}}) -->
                        Dans {{$countP=30-(strtotime(date('Y-m-d'))-strtotime($vehicule->derniereMaintenance))/86400}} jours
                      </td>
                       @if(Auth::user()->role=='superadmin')
                        <td>
                        @if($vehicule->alertP==0)
                        <a  type="button" class="btn btn-danger" data-toggle="modal" data-target="#alert{{$vehicule->id}}">
                          Alerter
               </a>
                        @else
                        <button type="button" class="btn btn-danger" disabled="true">
                          Alerter
               </button>
                        @endif
                      </td>
                      @endif
                    </tr>
                     @endif
                     

                    @endforeach

                </tbody>
              </table>
              @endif
            </div>
            <!-- /.card-body -->
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