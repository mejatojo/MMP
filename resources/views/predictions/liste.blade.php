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
  <style type="text/css">
    .tableau
    {
    border: 1px solid black;
    }
    .ty {
  position: relative;
/*  display: inline-block;
 border-bottom: 1px dotted black;*/ 
}

.ty .tytext {
  visibility: hidden;
  background-color: white;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  position: absolute;
  z-index: 1;
  top: 125%;
  right: : 300%;
  margin-right: -60px;
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

@endsection
@section('content')
<div class="card col-12">
            <div class="card-header">Prédiction</div>
            <div class="card-body">
              <form action="{{route('prediction.store')}}" method="post">
                @csrf
                <div class="form-group row">
                <input type="date" class="form-control col-2" name="date">
                <button class="btn btn-primary col-3">Valider</button>
              </div>
              </form> 
              @if(!isset($datefin) or $datefin<(date('Y-m-d')))
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Immatriculation :</th>
                  <th>Marque :</th>
                  <th>Modele :</th>
                  @if(Auth::user()->role=="superadmin")
                  <th>Entreprise  :</th>
                  @endif
                  <th>Dernières données  (hauteur de gomme/ distance parcourue) :</th>
                  <th id="gg">Prochain changement de pneus :</th>
                 <!--  <th>Permutation</th> -->
                  <!-- <th>Pression</th> -->
                  <th>Action :</th>
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
                              <textarea class="form-control" name="texte" placeholder="Si vous laisser ce champs vide,il enverra un message par défaut"></textarea>
                              <button class="btn btn-primary">Alerter</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    @if(isset(unserialize($vehicule->t1)[1]) and isset(unserialize($vehicule->t2)[1]))
                  <tr>
                      <td>{{$vehicule->immatriculation}}</td>
                      <td>{{$vehicule->marque}}</td>
                      <td>{{$vehicule->model}}</td>
                      @if(Auth::user()->role=="superadmin")
                      <td>{{$vehicule->entreprise}}</td>
                      @endif
                      <td>
                        Dernier contrôle : {{date('d/m/Y',strtotime($vehicule->control))}}
            <div class="ty" style="width: 17cm;">
                <span class="tytext">
                  @if($vehicule->etatPneu)
                        <div class="row" style="width: 100%;">
                          @if(unserialize($vehicule->hGomme)[0]<$vehicule->limiteHg+0.4)
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->hGomme)[0]}} mm/
                            {{unserialize($vehicule->etatPneu)[0]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[0])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @elseif(unserialize($vehicule->hGomme)[0]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[0]>=$vehicule->limiteHg+0.4)
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[0]}} mm/
                            {{unserialize($vehicule->etatPneu)[0]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[0])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @else
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: green">
                  {{unserialize($vehicule->hGomme)[0]}} mm/
                            {{unserialize($vehicule->etatPneu)[0]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[0])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @endif
                          @if(unserialize($vehicule->hGomme)[1]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->hGomme)[1]}} mm/
                            {{unserialize($vehicule->etatPneu)[1]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[1])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3"></div>
                          @elseif(unserialize($vehicule->hGomme)[1]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[1]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[1]}} mm/
                            {{unserialize($vehicule->etatPneu)[1]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[1])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3"></div>
                          @else
                          <div class="col-3 tableau" style="background: green">                   {{unserialize($vehicule->hGomme)[1]}} mm/
                            {{unserialize($vehicule->etatPneu)[1]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[1])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3"></div>
                          @endif
                        </div>
                        <div class="row" style="width: 100%;">
                          @if(isset(unserialize($vehicule->etatPneu)[4]))
                          @if(unserialize($vehicule->hGomme)[4]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                              {{unserialize($vehicule->hGomme)[4]}} mm/
                            {{unserialize($vehicule->etatPneu)[4]}} bar<br>
                              @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[4])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                            @elseif(unserialize($vehicule->hGomme)[4]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[4]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[4]}} mm/
                            {{unserialize($vehicule->etatPneu)[4]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[4])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                            @else
                            <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[4]}} mm/
                            {{unserialize($vehicule->etatPneu)[4]}}bar<br>
                              @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[4])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                            </div>
                            @endif
                          @else
                            <div class="col-3"></div> 
                          @endif
                          @if(unserialize($vehicule->hGomme)[2]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->hGomme)[2]}} mm/
                            {{unserialize($vehicule->etatPneu)[2]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[2])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @elseif(unserialize($vehicule->hGomme)[2]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[2]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[2]}} mm/
                            {{unserialize($vehicule->etatPneu)[2]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[2])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">                   {{unserialize($vehicule->hGomme)[2]}} mm/
                            {{unserialize($vehicule->etatPneu)[2]}} bar<br>
                            @foreach($references as $reference)
                            @if($reference->id==unserialize($vehicule->refPneus)[2])
                              {{$reference->reference}}
                            @endif
                            @endforeach
                          </div>
                          @endif
                          @if(unserialize($vehicule->hGomme)[3]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->hGomme)[3]}} mm/
                            {{unserialize($vehicule->etatPneu)[3]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[3])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @elseif(unserialize($vehicule->hGomme)[3]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[3]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[3]}} mm/
                            {{unserialize($vehicule->etatPneu)[3]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[3])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">                   {{unserialize($vehicule->hGomme)[3]}} mm/
                            {{unserialize($vehicule->etatPneu)[3]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[3])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @endif
                          @if(isset(unserialize($vehicule->etatPneu)[5]))
                          @if(unserialize($vehicule->hGomme)[5]<$vehicule->limiteHg+0.4)
                            <div class="col-3 tableau" style="background: red">       
                              {{unserialize($vehicule->hGomme)[5]}} mm/
                            {{unserialize($vehicule->etatPneu)[5]}} bar<br>
                              @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[5])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                            </div>
                          @elseif(unserialize($vehicule->hGomme)[5]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[5]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[5]}} mm/
                            {{unserialize($vehicule->etatPneu)[5]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[5])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @else
                            <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[5]}} mm/
                            {{unserialize($vehicule->etatPneu)[5]}} bar<br>
                              @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[5])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                            </div>
                            @endif
                          @endif
                        </div>
                        @endif
                </span>
                        @if($vehicule->etatPneu)
                        <div class="row">
                          @if(unserialize($vehicule->hGomme)[0]<$vehicule->limiteHg+0.4)
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: red">       
                          {{unserialize($vehicule->hGomme)[0]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[0])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @elseif(unserialize($vehicule->hGomme)[0]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[0]>=$vehicule->limiteHg+0.4)
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: orange">        
                          {{unserialize($vehicule->hGomme)[0]}} mm/
                             @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[0])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @else
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: green"> 
                            {{unserialize($vehicule->hGomme)[0]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[0])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @endif
                          @if(unserialize($vehicule->hGomme)[1]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                          {{unserialize($vehicule->hGomme)[1]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[1])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3"></div>
                          @elseif(unserialize($vehicule->hGomme)[1]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[1]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                          {{unserialize($vehicule->hGomme)[1]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[1])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3"></div>
                          @else
                          <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[1]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[1])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3"></div>
                          @endif
                        </div>
                        <div class="row">
                          @if(isset(unserialize($vehicule->etatPneu)[4]))
                          @if(unserialize($vehicule->hGomme)[4]<$vehicule->limiteHg+0.4)
                            <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->hGomme)[4]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[4])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                            </div>
                            @elseif(unserialize($vehicule->hGomme)[4]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[4]>=$vehicule->limiteHg+0.4)
                            <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[4]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[4])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[4]}} mm/
                           @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[4])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                            </div>
                            @endif
                          @else
                            <div class="col-3"></div> 
                          @endif
                          @if(unserialize($vehicule->hGomme)[2]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                          {{unserialize($vehicule->hGomme)[2]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[2])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @elseif(unserialize($vehicule->hGomme)[2]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[2]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                          {{unserialize($vehicule->hGomme)[2]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[2])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[2]}} mm/
                           @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[2])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @endif
                          @if(unserialize($vehicule->hGomme)[3]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                          {{unserialize($vehicule->hGomme)[3]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[3])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @elseif(unserialize($vehicule->hGomme)[3]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[3]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                          {{unserialize($vehicule->hGomme)[3]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[3])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[3]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[3])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @endif
                          @if(isset(unserialize($vehicule->etatPneu)[5]))
                          @if(unserialize($vehicule->hGomme)[5]<$vehicule->limiteHg+0.4)
                            <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->hGomme)[5]}} mm/
                             @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[5])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                            </div>
                            @elseif(unserialize($vehicule->hGomme)[5]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[5]>=$vehicule->limiteHg+0.4)
                            <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[5]}} mm/
                              @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[5])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[5]}} mm/
                              @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[5])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                            </div>
                            @endif
                          @endif
                        </div>
                        @endif
                    </div>
                      </td>
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
                            @if($tab[$i]<$vehicule->limiteHg)
                              {{$stop=1}}
                            @endif
                          @endfor
                          {{$count++}}
                          @if($count>1000)
                          {{$stop=1}}
                          @endif
                        @endwhile
                        {{$nbPneu=0}}
                        @for($i=0;$i<count(unserialize($vehicule->hGomme));$i++)
                            @if($tab[$i]<$vehicule->limiteHg)
                            {{$nbPneu++}}
                            @endif
                        @endfor 
                        </span>

                          <span hidden><!-- {{$difference=((strtotime($datec)-strtotime($dated))/86400)}} -->
                            {{$dateprevu=date('y-m-d',strtotime($datec)+86400*$count)}}
                          {{$countAu=(strtotime($dateprevu)-strtotime(date('y-m-d')))/86400}}</span>
                      <td width="340px">
                        <span hidden>{{$count/1000}}</span>
                          @if($count>1000)
                          Non disponible (on n'a qu'une donnée)
                          @else
                           @if($countAu<=0) 
                           <font color="red">
                           Passé de {{abs(round($countAu))}} jours, {{$nbPneu}} pneus à remplacer
                           soit le {{date('d/m/Y',strtotime($dateprevu))}}</font>
                           @else
                            {{$nbPneu}} pneus à remplacer dans {{abs(round($countAu))}} jours,
                           soit le {{date('d/m/Y',strtotime($dateprevu))}}
                           @endif
                          @endif
                      </td>
                      @if(Auth::user()->role=='superadmin')
                      <td>
                         <a  type="button" class="btn btn-danger" data-toggle="modal" data-target="#alert{{$vehicule->id}}">
                          Alerter
               </a>      
                       
                      </td>
                      @endif
                      @if(Auth::user()->role!="superadmin")
                          <td>
                          <a type="button" class="btn btn-info" href="rendezVous/{{$vehicule->id}}">
                            Prendre un rendez-vous
                          </a>
                          </td>
                          @endif
                  </tr>
                  @elseif(isset(unserialize($vehicule->t1)[1]) and !isset(unserialize($vehicule->t2)[1]))
                    <tr>
                      <td>{{$vehicule->immatriculation}}</td>
                      <td>{{$vehicule->marque}}</td>
                      <td>{{$vehicule->model}}</td>
                      @if(Auth::user()->role=="superadmin")
                      <td>{{$vehicule->entreprise}}</td>
                      @endif
                      <td>
                        Dernier contrôle : {{date('d/m/Y',strtotime($vehicule->control))}}
            <div class="ty" style="width: 17cm;">
                <span class="tytext">
                  @if($vehicule->etatPneu)
                        <div class="row" style="width: 100%;">
                          @if(unserialize($vehicule->hGomme)[0]<$vehicule->limiteHg+0.4)
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->hGomme)[0]}} mm/
                            {{unserialize($vehicule->etatPneu)[0]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[0])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @elseif(unserialize($vehicule->hGomme)[0]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[0]>=$vehicule->limiteHg+0.4)
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[0]}} mm/
                            {{unserialize($vehicule->etatPneu)[0]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[0])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @else
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: green">
                  {{unserialize($vehicule->hGomme)[0]}} mm/
                            {{unserialize($vehicule->etatPneu)[0]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[0])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @endif
                          @if(unserialize($vehicule->hGomme)[1]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->hGomme)[1]}} mm/
                            {{unserialize($vehicule->etatPneu)[1]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[1])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3"></div>
                          @elseif(unserialize($vehicule->hGomme)[1]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[1]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[1]}} mm/
                            {{unserialize($vehicule->etatPneu)[1]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[1])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3"></div>
                          @else
                          <div class="col-3 tableau" style="background: green">                   {{unserialize($vehicule->hGomme)[1]}} mm/
                            {{unserialize($vehicule->etatPneu)[1]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[1])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3"></div>
                          @endif
                        </div>
                        <div class="row" style="width: 100%;">
                          @if(isset(unserialize($vehicule->etatPneu)[4]))
                          @if(unserialize($vehicule->hGomme)[4]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                              {{unserialize($vehicule->hGomme)[4]}} mm/
                            {{unserialize($vehicule->etatPneu)[4]}} bar<br>
                              @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[4])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                            @elseif(unserialize($vehicule->hGomme)[4]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[4]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[4]}} mm/
                            {{unserialize($vehicule->etatPneu)[4]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[4])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                            @else
                            <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[4]}} mm/
                            {{unserialize($vehicule->etatPneu)[4]}}bar<br>
                              @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[4])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                            </div>
                            @endif
                          @else
                            <div class="col-3"></div> 
                          @endif
                          @if(unserialize($vehicule->hGomme)[2]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->hGomme)[2]}} mm/
                            {{unserialize($vehicule->etatPneu)[2]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[2])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @elseif(unserialize($vehicule->hGomme)[2]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[2]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[2]}} mm/
                            {{unserialize($vehicule->etatPneu)[2]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[2])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">                   {{unserialize($vehicule->hGomme)[2]}} mm/
                            {{unserialize($vehicule->etatPneu)[2]}} bar<br>
                            @foreach($references as $reference)
                            @if($reference->id==unserialize($vehicule->refPneus)[2])
                              {{$reference->reference}}
                            @endif
                            @endforeach
                          </div>
                          @endif
                          @if(unserialize($vehicule->hGomme)[3]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->hGomme)[3]}} mm/
                            {{unserialize($vehicule->etatPneu)[3]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[3])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @elseif(unserialize($vehicule->hGomme)[3]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[3]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[3]}} mm/
                            {{unserialize($vehicule->etatPneu)[3]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[3])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">                   {{unserialize($vehicule->hGomme)[3]}} mm/
                            {{unserialize($vehicule->etatPneu)[3]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[3])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @endif
                          @if(isset(unserialize($vehicule->etatPneu)[5]))
                          @if(unserialize($vehicule->hGomme)[5]<$vehicule->limiteHg+0.4)
                            <div class="col-3 tableau" style="background: red">       
                              {{unserialize($vehicule->hGomme)[5]}} mm/
                            {{unserialize($vehicule->etatPneu)[5]}} bar<br>
                              @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[5])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                            </div>
                          @elseif(unserialize($vehicule->hGomme)[5]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[5]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[5]}} mm/
                            {{unserialize($vehicule->etatPneu)[5]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[5])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @else
                            <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[5]}} mm/
                            {{unserialize($vehicule->etatPneu)[5]}} bar<br>
                              @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[5])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                            </div>
                            @endif
                          @endif
                        </div>
                        @endif
                </span>
                        @if($vehicule->etatPneu)
                        <div class="row">
                          @if(unserialize($vehicule->hGomme)[0]<$vehicule->limiteHg+0.4)
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: red">       
                          {{unserialize($vehicule->hGomme)[0]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[0])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @elseif(unserialize($vehicule->hGomme)[0]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[0]>=$vehicule->limiteHg+0.4)
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: orange">        
                          {{unserialize($vehicule->hGomme)[0]}} mm/
                             @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[0])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @else
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: green"> 
                            {{unserialize($vehicule->hGomme)[0]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[0])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @endif
                          @if(unserialize($vehicule->hGomme)[1]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                          {{unserialize($vehicule->hGomme)[1]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[1])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3"></div>
                          @elseif(unserialize($vehicule->hGomme)[1]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[1]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                          {{unserialize($vehicule->hGomme)[1]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[1])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3"></div>
                          @else
                          <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[1]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[1])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3"></div>
                          @endif
                        </div>
                        <div class="row">
                          @if(isset(unserialize($vehicule->etatPneu)[4]))
                          @if(unserialize($vehicule->hGomme)[4]<$vehicule->limiteHg+0.4)
                            <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->hGomme)[4]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[4])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                            </div>
                            @elseif(unserialize($vehicule->hGomme)[4]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[4]>=$vehicule->limiteHg+0.4)
                            <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[4]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[4])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[4]}} mm/
                           @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[4])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                            </div>
                            @endif
                          @else
                            <div class="col-3"></div> 
                          @endif
                          @if(unserialize($vehicule->hGomme)[2]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                          {{unserialize($vehicule->hGomme)[2]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[2])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @elseif(unserialize($vehicule->hGomme)[2]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[2]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                          {{unserialize($vehicule->hGomme)[2]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[2])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[2]}} mm/
                           @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[2])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @endif
                          @if(unserialize($vehicule->hGomme)[3]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                          {{unserialize($vehicule->hGomme)[3]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[3])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @elseif(unserialize($vehicule->hGomme)[3]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[3]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                          {{unserialize($vehicule->hGomme)[3]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[3])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[3]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[3])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @endif
                          @if(isset(unserialize($vehicule->etatPneu)[5]))
                          @if(unserialize($vehicule->hGomme)[5]<$vehicule->limiteHg+0.4)
                            <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->hGomme)[5]}} mm/
                             @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[5])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                            </div>
                            @elseif(unserialize($vehicule->hGomme)[5]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[5]>=$vehicule->limiteHg+0.4)
                            <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[5]}} mm/
                              @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[5])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[5]}} mm/
                              @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[5])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                            </div>
                            @endif
                          @endif
                        </div>
                        @endif
                    </div>
                      </td>
                        <td>Non disponible (on n'a qu'une donnée)<br>
                          <!-- @if(count(unserialize($vehicule->t1))==8)
                          {{date('d/m/Y',strtotime(unserialize($vehicule->t1)[7]))}}
                        @else
                          {{date('d/m/Y',strtotime(unserialize($vehicule->t1)[5]))}}
                        @endif -->
                        
                      
                      
                       
                      @if(Auth::user()->role=='superadmin')
                        <td>
                        <a  type="button" class="btn btn-danger" data-toggle="modal" data-target="#alert{{$vehicule->id}}">
                          Alerter
               </a> 
                      </td>
                      @endif
                      @if(Auth::user()->role!="superadmin")
                          <td>
                          <a type="button" class="btn btn-info" href="rendezVous/{{$vehicule->id}}">
                            Prendre un rendez-vous
                          </a>
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
                  <th>Immatriculation :</th>
                  <th>Marque :</th>
                  <th>Modele :</th>
                  @if(Auth::user()->role=="superadmin")
                  <th>Entreprise : </th>
                  @endif
                  <th>Dernières données  (hauteur de gomme/ distance parcourue) :</th>
                  <th>Prédiction hauteur de gomme :</th>
                  <!-- <th>Permutation</th> -->
                  <!-- <th>Pression</th> -->
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($vehicules as $vehicule)
                    @if(isset(unserialize($vehicule->t1)[1]) and isset(unserialize($vehicule->t2)[1]))
                  <tr>
                      <td>{{$vehicule->immatriculation}}</td>
                      <td>{{$vehicule->marque}}</td>
                      <td>{{$vehicule->model}}</td>
                      @if(Auth::user()->role=="superadmin")
                      <td>{{$vehicule->entreprise}}</td>
                      @endif
                       <td>
                        Dernier contrôle : {{date('d/m/Y',strtotime($vehicule->control))}}
            <div class="ty" style="width: 17cm;">
                <span class="tytext">
                  @if($vehicule->etatPneu)
                        <div class="row" style="width: 100%;">
                          @if(unserialize($vehicule->hGomme)[0]<$vehicule->limiteHg+0.4)
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->hGomme)[0]}} mm/
                            {{unserialize($vehicule->etatPneu)[0]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[0])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @elseif(unserialize($vehicule->hGomme)[0]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[0]>=$vehicule->limiteHg+0.4)
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[0]}} mm/
                            {{unserialize($vehicule->etatPneu)[0]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[0])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @else
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: green">
                  {{unserialize($vehicule->hGomme)[0]}} mm/
                            {{unserialize($vehicule->etatPneu)[0]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[0])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @endif
                          @if(unserialize($vehicule->hGomme)[1]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->hGomme)[1]}} mm/
                            {{unserialize($vehicule->etatPneu)[1]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[1])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3"></div>
                          @elseif(unserialize($vehicule->hGomme)[1]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[1]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[1]}} mm/
                            {{unserialize($vehicule->etatPneu)[1]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[1])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3"></div>
                          @else
                          <div class="col-3 tableau" style="background: green">                   {{unserialize($vehicule->hGomme)[1]}} mm/
                            {{unserialize($vehicule->etatPneu)[1]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[1])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3"></div>
                          @endif
                        </div>
                        <div class="row" style="width: 100%;">
                          @if(isset(unserialize($vehicule->etatPneu)[4]))
                          @if(unserialize($vehicule->hGomme)[4]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                              {{unserialize($vehicule->hGomme)[4]}} mm/
                            {{unserialize($vehicule->etatPneu)[4]}} bar<br>
                              @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[4])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                            @elseif(unserialize($vehicule->hGomme)[4]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[4]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[4]}} mm/
                            {{unserialize($vehicule->etatPneu)[4]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[4])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                            @else
                            <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[4]}} mm/
                            {{unserialize($vehicule->etatPneu)[4]}}bar<br>
                              @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[4])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                            </div>
                            @endif
                          @else
                            <div class="col-3"></div> 
                          @endif
                          @if(unserialize($vehicule->hGomme)[2]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->hGomme)[2]}} mm/
                            {{unserialize($vehicule->etatPneu)[2]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[2])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @elseif(unserialize($vehicule->hGomme)[2]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[2]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[2]}} mm/
                            {{unserialize($vehicule->etatPneu)[2]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[2])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">                   {{unserialize($vehicule->hGomme)[2]}} mm/
                            {{unserialize($vehicule->etatPneu)[2]}} bar<br>
                            @foreach($references as $reference)
                            @if($reference->id==unserialize($vehicule->refPneus)[2])
                              {{$reference->reference}}
                            @endif
                            @endforeach
                          </div>
                          @endif
                          @if(unserialize($vehicule->hGomme)[3]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->hGomme)[3]}} mm/
                            {{unserialize($vehicule->etatPneu)[3]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[3])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @elseif(unserialize($vehicule->hGomme)[3]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[3]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[3]}} mm/
                            {{unserialize($vehicule->etatPneu)[3]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[3])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">                   {{unserialize($vehicule->hGomme)[3]}} mm/
                            {{unserialize($vehicule->etatPneu)[3]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[3])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @endif
                          @if(isset(unserialize($vehicule->etatPneu)[5]))
                          @if(unserialize($vehicule->hGomme)[5]<$vehicule->limiteHg+0.4)
                            <div class="col-3 tableau" style="background: red">       
                              {{unserialize($vehicule->hGomme)[5]}} mm/
                            {{unserialize($vehicule->etatPneu)[5]}} bar<br>
                              @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[5])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                            </div>
                          @elseif(unserialize($vehicule->hGomme)[5]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[5]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[5]}} mm/
                            {{unserialize($vehicule->etatPneu)[5]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[5])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @else
                            <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[5]}} mm/
                            {{unserialize($vehicule->etatPneu)[5]}} bar<br>
                              @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[5])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                            </div>
                            @endif
                          @endif
                        </div>
                        @endif
                </span>
                        @if($vehicule->etatPneu)
                        <div class="row">
                          @if(unserialize($vehicule->hGomme)[0]<$vehicule->limiteHg+0.4)
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: red">       
                          {{unserialize($vehicule->hGomme)[0]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[0])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @elseif(unserialize($vehicule->hGomme)[0]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[0]>=$vehicule->limiteHg+0.4)
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: orange">        
                          {{unserialize($vehicule->hGomme)[0]}} mm/
                             @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[0])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @else
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: green"> 
                            {{unserialize($vehicule->hGomme)[0]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[0])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @endif
                          @if(unserialize($vehicule->hGomme)[1]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                          {{unserialize($vehicule->hGomme)[1]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[1])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3"></div>
                          @elseif(unserialize($vehicule->hGomme)[1]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[1]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                          {{unserialize($vehicule->hGomme)[1]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[1])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3"></div>
                          @else
                          <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[1]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[1])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3"></div>
                          @endif
                        </div>
                        <div class="row">
                          @if(isset(unserialize($vehicule->etatPneu)[4]))
                          @if(unserialize($vehicule->hGomme)[4]<$vehicule->limiteHg+0.4)
                            <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->hGomme)[4]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[4])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                            </div>
                            @elseif(unserialize($vehicule->hGomme)[4]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[4]>=$vehicule->limiteHg+0.4)
                            <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[4]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[4])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[4]}} mm/
                           @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[4])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                            </div>
                            @endif
                          @else
                            <div class="col-3"></div> 
                          @endif
                          @if(unserialize($vehicule->hGomme)[2]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                          {{unserialize($vehicule->hGomme)[2]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[2])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @elseif(unserialize($vehicule->hGomme)[2]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[2]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                          {{unserialize($vehicule->hGomme)[2]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[2])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[2]}} mm/
                           @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[2])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @endif
                          @if(unserialize($vehicule->hGomme)[3]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                          {{unserialize($vehicule->hGomme)[3]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[3])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @elseif(unserialize($vehicule->hGomme)[3]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[3]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                          {{unserialize($vehicule->hGomme)[3]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[3])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[3]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[3])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @endif
                          @if(isset(unserialize($vehicule->etatPneu)[5]))
                          @if(unserialize($vehicule->hGomme)[5]<$vehicule->limiteHg+0.4)
                            <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->hGomme)[5]}} mm/
                             @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[5])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                            </div>
                            @elseif(unserialize($vehicule->hGomme)[5]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[5]>=$vehicule->limiteHg+0.4)
                            <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[5]}} mm/
                              @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[5])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[5]}} mm/
                              @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[5])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                            </div>
                            @endif
                          @endif
                        </div>
                        @endif
                    </div>
                      </td>
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
                          @if($count>1000)
                          {{$stop=1}}
                          @endif
                        @endwhile
                        {{$nbPneu=0}}
                        @for($i=0;$i<count(unserialize($vehicule->hGomme));$i++)
                            @if($tab[$i]<$vehicule->limiteHg)
                            {{$nbPneu++}}
                            @endif
                        @endfor
                        </span>

                          <span hidden><!-- {{$difference=((strtotime($datec)-strtotime($dated))/86400)}} -->
                            {{$dateprevu=date('y-m-d',strtotime(date('y-m-d'))+86400*$count)}}
                          {{$countAu=(strtotime($dateprevu)-strtotime(date('y-m-d')))/86400}}</span>
                      <td width="340px">
                        <span hidden>{{$count/1000}}</span>
                          @if($count>1000)
                            Non disponible (on n'a qu'une donnée)
                          @else
                            @if($countAu<=0) 
                             <font color="red">
                             Passé de {{abs(round($countAu))}} jours, {{$nbPneu}} pneus à remplacer
                             soit le {{date('d/m/Y',strtotime($dateprevu))}}</font>
                             @else
                              {{$nbPneu}} pneus à remplacer dans {{abs(round($countAu))}} jours
                             soit le {{date('d/m/Y',strtotime($dateprevu))}}
                             @endif<br>
                           @endif
                        
                      </td>
                     
                      </td>
                      @if(Auth::user()->role=='superadmin')
                      <td>
                         <a  type="button" class="btn btn-danger" data-toggle="modal" data-target="#alert{{$vehicule->id}}">
                          Alerter
                        </a>  
                      </td>
                      @endif
                      @if(Auth::user()->role!="superadmin")
                          <td>
                          <a type="button" class="btn btn-info" href="rendezVous/{{$vehicule->id}}">
                            Prendre un rendez-vous
                          </a>
                          </td>
                          @endif
                  </tr>
                  @elseif(isset(unserialize($vehicule->t1)[1]) and !isset(unserialize($vehicule->t2)[1]))
                    <tr>
                      <td>{{$vehicule->immatriculation}}</td>
                      <td>{{$vehicule->marque}}</td>
                      <td>{{$vehicule->model}}</td>
                      @if(Auth::user()->role=="superadmin")
                      <td>{{$vehicule->entreprise}}</td>
                      @endif
                        <td>
                        Dernier contrôle : {{date('d/m/Y',strtotime($vehicule->control))}}
            <div class="ty" style="width: 17cm;">
                <span class="tytext">
                  @if($vehicule->etatPneu)
                        <div class="row" style="width: 100%;">
                          @if(unserialize($vehicule->hGomme)[0]<$vehicule->limiteHg+0.4)
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->hGomme)[0]}} mm/
                            {{unserialize($vehicule->etatPneu)[0]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[0])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @elseif(unserialize($vehicule->hGomme)[0]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[0]>=$vehicule->limiteHg+0.4)
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[0]}} mm/
                            {{unserialize($vehicule->etatPneu)[0]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[0])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @else
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: green">
                  {{unserialize($vehicule->hGomme)[0]}} mm/
                            {{unserialize($vehicule->etatPneu)[0]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[0])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @endif
                          @if(unserialize($vehicule->hGomme)[1]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->hGomme)[1]}} mm/
                            {{unserialize($vehicule->etatPneu)[1]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[1])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3"></div>
                          @elseif(unserialize($vehicule->hGomme)[1]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[1]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[1]}} mm/
                            {{unserialize($vehicule->etatPneu)[1]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[1])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3"></div>
                          @else
                          <div class="col-3 tableau" style="background: green">                   {{unserialize($vehicule->hGomme)[1]}} mm/
                            {{unserialize($vehicule->etatPneu)[1]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[1])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3"></div>
                          @endif
                        </div>
                        <div class="row" style="width: 100%;">
                          @if(isset(unserialize($vehicule->etatPneu)[4]))
                          @if(unserialize($vehicule->hGomme)[4]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                              {{unserialize($vehicule->hGomme)[4]}} mm/
                            {{unserialize($vehicule->etatPneu)[4]}} bar<br>
                              @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[4])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                            @elseif(unserialize($vehicule->hGomme)[4]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[4]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[4]}} mm/
                            {{unserialize($vehicule->etatPneu)[4]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[4])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                            @else
                            <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[4]}} mm/
                            {{unserialize($vehicule->etatPneu)[4]}}bar<br>
                              @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[4])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                            </div>
                            @endif
                          @else
                            <div class="col-3"></div> 
                          @endif
                          @if(unserialize($vehicule->hGomme)[2]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->hGomme)[2]}} mm/
                            {{unserialize($vehicule->etatPneu)[2]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[2])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @elseif(unserialize($vehicule->hGomme)[2]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[2]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[2]}} mm/
                            {{unserialize($vehicule->etatPneu)[2]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[2])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">                   {{unserialize($vehicule->hGomme)[2]}} mm/
                            {{unserialize($vehicule->etatPneu)[2]}} bar<br>
                            @foreach($references as $reference)
                            @if($reference->id==unserialize($vehicule->refPneus)[2])
                              {{$reference->reference}}
                            @endif
                            @endforeach
                          </div>
                          @endif
                          @if(unserialize($vehicule->hGomme)[3]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->hGomme)[3]}} mm/
                            {{unserialize($vehicule->etatPneu)[3]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[3])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @elseif(unserialize($vehicule->hGomme)[3]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[3]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[3]}} mm/
                            {{unserialize($vehicule->etatPneu)[3]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[3])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">                   {{unserialize($vehicule->hGomme)[3]}} mm/
                            {{unserialize($vehicule->etatPneu)[3]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[3])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @endif
                          @if(isset(unserialize($vehicule->etatPneu)[5]))
                          @if(unserialize($vehicule->hGomme)[5]<$vehicule->limiteHg+0.4)
                            <div class="col-3 tableau" style="background: red">       
                              {{unserialize($vehicule->hGomme)[5]}} mm/
                            {{unserialize($vehicule->etatPneu)[5]}} bar<br>
                              @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[5])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                            </div>
                          @elseif(unserialize($vehicule->hGomme)[5]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[5]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[5]}} mm/
                            {{unserialize($vehicule->etatPneu)[5]}} bar<br>
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[5])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                          </div>
                          @else
                            <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[5]}} mm/
                            {{unserialize($vehicule->etatPneu)[5]}} bar<br>
                              @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[5])
                                {{$reference->reference}}
                              @endif
                            @endforeach
                            </div>
                            @endif
                          @endif
                        </div>
                        @endif
                </span>
                        @if($vehicule->etatPneu)
                        <div class="row">
                          @if(unserialize($vehicule->hGomme)[0]<$vehicule->limiteHg+0.4)
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: red">       
                          {{unserialize($vehicule->hGomme)[0]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[0])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @elseif(unserialize($vehicule->hGomme)[0]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[0]>=$vehicule->limiteHg+0.4)
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: orange">        
                          {{unserialize($vehicule->hGomme)[0]}} mm/
                             @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[0])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @else
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: green"> 
                            {{unserialize($vehicule->hGomme)[0]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[0])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @endif
                          @if(unserialize($vehicule->hGomme)[1]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                          {{unserialize($vehicule->hGomme)[1]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[1])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3"></div>
                          @elseif(unserialize($vehicule->hGomme)[1]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[1]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                          {{unserialize($vehicule->hGomme)[1]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[1])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3"></div>
                          @else
                          <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[1]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[1])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          <div class="col-3"></div>
                          @endif
                        </div>
                        <div class="row">
                          @if(isset(unserialize($vehicule->etatPneu)[4]))
                          @if(unserialize($vehicule->hGomme)[4]<$vehicule->limiteHg+0.4)
                            <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->hGomme)[4]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[4])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                            </div>
                            @elseif(unserialize($vehicule->hGomme)[4]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[4]>=$vehicule->limiteHg+0.4)
                            <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[4]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[4])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[4]}} mm/
                           @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[4])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                            </div>
                            @endif
                          @else
                            <div class="col-3"></div> 
                          @endif
                          @if(unserialize($vehicule->hGomme)[2]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                          {{unserialize($vehicule->hGomme)[2]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[2])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @elseif(unserialize($vehicule->hGomme)[2]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[2]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                          {{unserialize($vehicule->hGomme)[2]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[2])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[2]}} mm/
                           @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[2])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @endif
                          @if(unserialize($vehicule->hGomme)[3]<$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: red">       
                          {{unserialize($vehicule->hGomme)[3]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[3])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @elseif(unserialize($vehicule->hGomme)[3]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[3]>=$vehicule->limiteHg+0.4)
                          <div class="col-3 tableau" style="background: orange">        
                          {{unserialize($vehicule->hGomme)[3]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[3])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[3]}} mm/
                            @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[3])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                          </div>
                          @endif
                          @if(isset(unserialize($vehicule->etatPneu)[5]))
                          @if(unserialize($vehicule->hGomme)[5]<$vehicule->limiteHg+0.4)
                            <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->hGomme)[5]}} mm/
                             @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[5])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                            </div>
                            @elseif(unserialize($vehicule->hGomme)[5]<$vehicule->limiteHg+0.8 and unserialize($vehicule->hGomme)[5]>=$vehicule->limiteHg+0.4)
                            <div class="col-3 tableau" style="background: orange">        
                            {{unserialize($vehicule->hGomme)[5]}} mm/
                              @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[5])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->hGomme)[5]}} mm/
                              @foreach($references as $reference)
                              @if($reference->id==unserialize($vehicule->refPneus)[5])
                                {{$vehicule->kilometrage-$reference->kInit}} km
                              @endif
                            @endforeach
                            </div>
                            @endif
                          @endif
                        </div>
                        @endif
                    </div>
                      </td>
                     <td>Non disponible (on n'a qu'une donnée)<br>
                        <!-- @if(count(unserialize($vehicule->t1))==8)
                          {{date('d/m/Y',strtotime(unserialize($vehicule->t1)[7]))}}
                        @else
                          {{date('d/m/Y',strtotime(unserialize($vehicule->t1)[5]))}}
                        @endif -->
                        
                      </td>
                       @if(Auth::user()->role=='superadmin')
                        <td>
                        <a  type="button" class="btn btn-danger" data-toggle="modal" data-target="#alert{{$vehicule->id}}">
                          Alerter
               </a>
                       
                      </td>
                      @endif
                      @if(Auth::user()->role!="superadmin")
                          <td>
                          <a type="button" class="btn btn-info" href="rendezVous/{{$vehicule->id}}">
                            Prendre un rendez-vous
                          </a>
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
  @if(Auth::user()->role=="superadmin")
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
      "order": [ 5, 'asc' ]
    });
  });
  $(function () {
    $("#example2").DataTable({
      "responsive": true,
      "autoWidth": false, 
      "order": [ 5, 'asc' ]
    });
  });
</script>
@else
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
      "order": [ 4, 'asc' ]
    });
  });
  $(function () {
    $("#example2").DataTable({
      "responsive": true,
      "autoWidth": false, 
      "order": [ 4, 'asc' ]
    });
  });
</script>
@endif



@endsection