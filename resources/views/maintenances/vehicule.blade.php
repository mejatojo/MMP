                      <!--Modal-->
                        <div class="modal fade" id="changeAVG" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">pneu AVG</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form action="{{route('changement.store')}}" method="post">
                                  @csrf
                                  <input type="text" name="id" value="{{$vehicule->id}}" hidden>
                                  <input type="text" name="kil" value="{{$vehicule->kilometrage}}" hidden>
                                  <input type="text" name="place" value="0" hidden>
                                  <label>Référence :</label>
                                  <select class="form-control" name="ref">
                                    <option></option>
                                      @foreach($references as $stock)
                                      <option value="{{$stock->id}}">{{$stock->reference}}</option>
                                      @endforeach
                                  </select>
                                  <label>Hauteur de gomme :</label>
                                  <input type="text" name="hg" class="form-control">
                                  <label>Pression :</label>
                                  <input type="text" name="pression" class="form-control">
                                  <button class="btn btn-primary">Valider</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!--Fin Modal-->
                        <!--Modal-->
                        <div class="modal fade" id="changeAVD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">pneu AVD</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form action="{{route('changement.store')}}" method="post">
                                  @csrf
                                  <input type="text" name="id" value="{{$vehicule->id}}" hidden>
                                  <input type="text" name="kil" value="{{$vehicule->kilometrage}}" hidden>
                                  <input type="text" name="place" value="1" hidden>
                                  <label>Référence :</label>
                                  <select class="form-control" name="ref">
                                    <option></option>
                                      @foreach($references as $stock)
                                      <option value="{{$stock->id}}">{{$stock->reference}}</option>
                                      @endforeach
                                  </select>
                                  <label>Hauteur de gomme :</label>
                                  <input type="text" name="hg" class="form-control">
                                  <label>Pression :</label>
                                  <input type="text" name="pression" class="form-control">
                                  <button class="btn btn-primary">Valider</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!--Fin Modal-->
                        <!--Modal-->
                        <div class="modal fade" id="changeARG" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">pneu ARG</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form action="{{route('changement.store')}}" method="post">
                                  @csrf
                                  <input type="text" name="id" value="{{$vehicule->id}}" hidden>
                                  <input type="text" name="kil" value="{{$vehicule->kilometrage}}" hidden>
                                  <input type="text" name="place" value="2" hidden>
                                  <label>Référence :</label>
                                  <select class="form-control" name="ref">
                                    <option></option>
                                      @foreach($references as $stock)
                                      <option value="{{$stock->id}}">{{$stock->reference}}</option>
                                      @endforeach
                                  </select>
                                  <label>Hauteur de gomme :</label>
                                  <input type="text" name="hg" class="form-control">
                                  <label>Pression :</label>
                                  <input type="text" name="pression" class="form-control">
                                  <button class="btn btn-primary">Valider</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!--Fin Modal-->
                        <!--Modal-->
                        <div class="modal fade" id="changeARD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">pneu ARD</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form action="{{route('changement.store')}}" method="post">
                                  @csrf
                                  <input type="text" name="id" value="{{$vehicule->id}}" hidden>
                                  <input type="text" name="kil" value="{{$vehicule->kilometrage}}" hidden>
                                  <input type="text" name="place" value="3" hidden>
                                  <label>Référence :</label>
                                  <select class="form-control" name="ref">
                                    <option></option>
                                      @foreach($references as $stock)
                                      <option value="{{$stock->id}}">{{$stock->reference}}</option>
                                      @endforeach
                                  </select>
                                  <label>Hauteur de gomme :</label>
                                  <input type="text" name="hg" class="form-control">
                                  <label>Pression :</label>
                                  <input type="text" name="pression" class="form-control">
                                  <button class="btn btn-primary">Valider</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!--Fin Modal-->
                        <!--Modal-->
                        <div class="modal fade" id="changeARG2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">pneu ARG2</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form action="{{route('changement.store')}}" method="post">
                                  @csrf
                                  <input type="text" name="id" value="{{$vehicule->id}}" hidden>
                                  <input type="text" name="kil" value="{{$vehicule->kilometrage}}" hidden>
                                  <input type="text" name="place" value="4" hidden>
                                  <label>Référence :</label>
                                  <select class="form-control" name="ref">
                                    <option></option>
                                      @foreach($references as $stock)
                                      <option value="{{$stock->id}}">{{$stock->reference}}</option>
                                      @endforeach
                                  </select>
                                  <label>Hauteur de gomme :</label>
                                  <input type="text" name="hg" class="form-control">
                                  <label>Pression :</label>
                                  <input type="text" name="pression" class="form-control">
                                  <button class="btn btn-primary">Valider</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!--Fin Modal-->
                        <!--Modal-->
                        <div class="modal fade" id="changeARD2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">pneu ARD2</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form action="{{route('changement.store')}}" method="post">
                                  @csrf
                                  <input type="text" name="id" value="{{$vehicule->id}}" hidden>
                                  <input type="text" name="kil" value="{{$vehicule->kilometrage}}" hidden>
                                  <input type="text" name="place" value="5" hidden>
                                  <label>Référence :</label>
                                  <select class="form-control" name="ref">
                                    <option></option>
                                      @foreach($references as $stock)
                                      <option value="{{$stock->id}}">{{$stock->reference}}</option>
                                      @endforeach
                                  </select>
                                  <label>Hauteur de gomme :</label>
                                  <input type="text" name="hg" class="form-control">
                                  <label>Pression :</label>
                                  <input type="text" name="pression" class="form-control">
                                  <button class="btn btn-primary">Valider</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!--Fin Modal-->
<div class="col-md-12">
              <h1 style="text-align: center">Intervention de "{{$vehicule->immatriculation}}"" le {{date('d/m/Y')}}</h1>
              <!-- Menu -->

              <div class="row">
              <a href="/maintenances" class="btn btn-default col-3">Retour à la liste</a>
              <a href="{{route('vehicule.pression',$vehicule->id)}}" class="btn btn-default  col-3">Pressions  effectuées</a>
              <button type="button" class="btn btn-default col-3" data-toggle="modal" data-target="#exampleModal">
                Permutation
              </button>
              <!--Modal permutation-->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Permutation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <label>Placement initial</label>
                        <div class="row">
                        <div class="col-3"></div>
                        <div id="dv1" class="col-3">
                          <div style="width: 100%;height: 100%"  class="list">
                            <font color="black">{{unserialize($vehicule->hGomme)[0]}} mm<br>
                              {{unserialize($vehicule->etatPneu)[0]}} bar<br></font>
                          </div>
                      </div>
                      <div id="dv2" class="col-3">
                        <div style="width: 100%;height: 100%"  class="list">
                          <font color="brown">{{unserialize($vehicule->hGomme)[1]}} mm<br>
                              {{unserialize($vehicule->etatPneu)[1]}} bar</font>
                        </div>
                      </div>
                      <div class="col-3"></div>
                    </div>
                    <div class="row"> 
                       @if(isset(unserialize($vehicule->hGomme)[4]))
                        <div id="dv5"  class="col-3">
                        <div style="width: 100%;height: 100%"  class="list">
                          <font color="yellow">{{unserialize($vehicule->hGomme)[4]}} mm<br>
                              {{unserialize($vehicule->etatPneu)[4]}} bar</font>
                        </div>
                      </div>
                       @else
                       <div class="col-3"></div>
                       @endif
                      <div id="dv3" class="col-3">
                        <div style="width: 100%;height: 100%" class="list">
                         <font color="red"> {{unserialize($vehicule->hGomme)[2]}} mm<br>
                              {{unserialize($vehicule->etatPneu)[2]}} bar</font></div>
                        </div>
                      <div id="dv4" class="col-3">
                        <div style="width: 100%;height: 100%"  class="list">
                         <font color="green"> {{unserialize($vehicule->hGomme)[3]}} mm<br>
                              {{unserialize($vehicule->etatPneu)[3]}} bar</font>
                        </div>
                      </div>
                      @if(isset(unserialize($vehicule->hGomme)[5]))
                        <div id="dv6" class="col-3">
                        <div style="width: 100%;height: 100%" class="list">
                          <font color="blue">{{unserialize($vehicule->hGomme)[5]}} mm<br>
                              {{unserialize($vehicule->etatPneu)[5]}} bar</font>
                        </div>
                      </div>
                       @else
                       <div class="col-3"></div>
                       @endif
                   </div>
                   <hr>
                   <label>Permutation (glissez et déposez sur la case mais pas sur les détails)</label>
                        <form role="form" method="post" action="{{Route('vehicules.update',$vehicule->id)}}">
                          @csrf
                          @method('PUT')
                        <div class="row" style="text-align: center">
                        <div class="col-3"></div>
                        <div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)" class="col-3">
                          <div style="width: 100%;height: 100%" draggable="true" ondragstart="drag(event)" id="drag1" class="list">
                            <font color="black">{{unserialize($vehicule->hGomme)[0]}} mm<br>
                              {{unserialize($vehicule->etatPneu)[0]}} bar</font>
                          </div>
                           <input type="text" name="place[]" hidden="true" value="0">
                      </div>
                      <div id="div2" ondrop="drop(event)" ondragover="allowDrop(event)" class="col-3">
                        <div style="width: 100%;height: 100%" draggable="true" ondragstart="drag(event)" id="drag2" class="list">
                         <font color="brown"> {{unserialize($vehicule->hGomme)[1]}} mm<br>
                              {{unserialize($vehicule->etatPneu)[1]}} bar</font>
                        </div>
                        <input type="text" name="place[]" hidden="true" value="1">
                      </div>
                      <div class="col-3"></div>
                       @if(isset(unserialize($vehicule->hGomme)[4]))
                        <div id="div5" ondrop="drop(event)" ondragover="allowDrop(event)" class="col-3">
                        <div style="width: 100%;height: 100%" draggable="true" ondragstart="drag(event)" id="drag5" class="list">
                          <font color="yellow">{{unserialize($vehicule->hGomme)[4]}} mm<br>
                              {{unserialize($vehicule->etatPneu)[4]}} bar</font>
                        </div>
                        <input type="text" name="placeS[]"  hidden="true" value="4">
                      </div>
                       @else
                       <div class="col-3"></div>
                       @endif
                      <div id="div3" ondrop="drop(event)" ondragover="allowDrop(event)" class="col-3">
                        <div style="width: 100%;height: 100%" draggable="true" ondragstart="drag(event)" id="drag3" class="list">
                          <font color="red">{{unserialize($vehicule->hGomme)[2]}} mm<br>
                              {{unserialize($vehicule->etatPneu)[2]}} bar</font>
                        </div>
                        <input type="text" name="place[]"  hidden="true" value="2">
                      </div>
                      <div id="div4" ondrop="drop(event)" ondragover="allowDrop(event)" class="col-3">
                        <div style="width: 100%;height: 100%" draggable="true" ondragstart="drag(event)" id="drag4" class="list">
                          <font color="green">{{unserialize($vehicule->hGomme)[3]}} mm<br>
                              {{unserialize($vehicule->etatPneu)[3]}} bar</font>
                        </div>
                        <input type="text" name="place[]" hidden="true" value="3">
                      </div>
                      @if(isset(unserialize($vehicule->hGomme)[5]))
                        <div id="div6" ondrop="drop(event)" ondragover="allowDrop(event)" class="col-3">
                        <div style="width: 100%;height: 100%" draggable="true" ondragstart="drag(event)" id="drag6" class="list">
                          <font color="blue"> {{unserialize($vehicule->hGomme)[5]}} mm<br>
                              {{unserialize($vehicule->etatPneu)[5]}} bar</font>
                        </div>
                        <input type="text" name="placeS[]"  hidden="true" value="5">
                      </div>
                       @else
                       <div class="col-3"></div>
                       @endif
                   </div>
                       <button class="btn btn-primary">Valider</button>
                     </form>
                      </div>
                    </div>
                  </div>
                </div>
              <!--Fin permutation-->
              <a type="button" class="btn btn-default col-3" data-toggle="modal" data-target="#myModal">
                   Mettre à jour
              </a>
              <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Mise à jour</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <label> Hauteur de gomme actuel</label>
                        <form role="form" method="post" action="{{Route('vehicules.update',$vehicule->id)}}">
                          @csrf
                           @method('PUT')
                                      <div class="row">
                                        <div class="col-3"></div>
                                        <div class="col-3">
                                          <input type="text" class="form-control" name="hg[]" placeholder="AVG">
                                        </div>
                                        <div class="col-3">
                                          <input type="text" class="form-control" name="hg[]" placeholder="AVD">
                                        </div>
                                      </div>
                                      <div class="row">
                                        @if($vehicule->pneu==6)
                                        <div class="col-3">
                                          <input type="text" class="form-control" name="hg[]" placeholder="ARG 2">
                                        </div>
                                        @else
                                        <div class="col-3"></div>
                                        @endif
                                        <div class="col-3">
                                          <input type="text" class="form-control" name="hg[]" placeholder="ARG">
                                        </div>
                                        <div class="col-3">
                                          <input type="text" class="form-control" name="hg[]" placeholder="ARD">
                                        </div>
                                        @if($vehicule->pneu==6)
                                        <div class="col-3">
                                          <input type="text" class="form-control" name="hg[]" placeholder="ARD 2">
                                        </div>
                                        @endif
                                      </div>
                                      <div class="form-group">
                                      <label for="exampleInputPassword1">kilomètrage: </label>
                                      <input type="text" class="form-control" id="exampleInputPassword1" name="kilometrage">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Ajouter</button>
                                </form>
                    </div>
                 </div>
               </div>
            </div>
            </div>
            <!-- Fin menu -->
            <br>
              <div class="row">
                <div class="col-4">
                <!-- pneus avg -->
                  <div class="row">
                    <div class="col-11">
                      <div  class="hide" style="border-style: ridge;width: 100%;padding-left: 1cm;">
                        <h3>AVG</h3>
                        Hauteur de gomme: {{unserialize($vehicule->hGomme)[0]}} mm<br>
                        Pression actuelle: {{unserialize($vehicule->etatPneu)[0]}}<br>
                        Pression conseillée: {{unserialize($vehicule->etatPneuInit)[0]-unserialize($vehicule->etatPneu)[0]}}<br>
                        @foreach($stocks as $stock)
                          @if($stock->id==unserialize($vehicule->refPneus)[0])
                            Ref :  {{$stock->reference}}
                          @endif
                        @endforeach
                        <BR>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#changeAVG">Changer</button>
                      </div>
                    </div>
                    <div class="col-1 pneu"  style="border-style: solid;height: 4cm;margin-top: 1cm"></div>
                  </div>
                  <!-- pneus arg -->
                  <div class="row">
                    <div class="col-10">
                        <div  class="hide" style="border-style: ridge;width: 100%;padding-left: 1cm;">
                        <h3>ARG</h3>
                        Hauteur de gomme: {{unserialize($vehicule->hGomme)[2]}} mm<br>
                        Pression actuelle: {{unserialize($vehicule->etatPneu)[2]}}<br>
                        Pression conseillée:
                         {{unserialize($vehicule->etatPneuInit)[2]-unserialize($vehicule->etatPneu)[2]}}
                         @foreach($stocks as $stock)
                          @if($stock->id==unserialize($vehicule->refPneus)[2])
                           <br> Ref :  {{$stock->reference}}
                          @endif
                        @endforeach
                        <BR>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#changeARG">Changer</button>
                      </div>
                      @if(isset(unserialize($vehicule->hGomme)[4]))
                      <div  class="jum" style="border-style: ridge;width: 100%;padding-left: 1cm;">
                        <h3>ARG2</h3>
                        Hauteur de gomme: {{unserialize($vehicule->hGomme)[4]}} mm<br>
                        Pression actuelle: {{unserialize($vehicule->etatPneu)[4]}}<br>
                        Pression conseillée:
                         {{unserialize($vehicule->etatPneuInit)[4]-unserialize($vehicule->etatPneu)[4]}}
                         @foreach($stocks as $stock)
                          @if($stock->id==unserialize($vehicule->refPneus)[4])
                            <br>Ref :  {{$stock->reference}}
                          @endif
                        @endforeach
                        <BR>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#changeARG2">Changer</button>
                      </div>
                      @endif
                    </div>
                    @if(isset(unserialize($vehicule->hGomme)[4]))
                    <div class="col-1 ju" style="border-style: solid;height: 4cm;margin-top: 5cm"></div>
                    @else
                    <div class="col-1"></div>
                    @endif
                    <div class="col-1 pneu" style="border-style: solid;height: 4cm;margin-top: 5cm"></div>
                  </div>
                </div>
                <!--véhicules-->
                <div class="col-4" style="border-style: ridge;height: 17.5cm;text-align: center;">
                  <h4>Kilomètrage:{{$vehicule->kilometrage}}<br>
                    Dernière maintenance: {{date('d/m/Y',strtotime($vehicule->derniereMaintenance))}}<br>
                    Couple serrage : {{$vehicule->serrage}} nm<br>
                    Type de permutation : {{$vehicule->type}}<br>
                    Information nécessaire : "{{$vehicule->information}}"</h4>
                    <hr>
                    Pressions conseillées : 
                      <div class="row" style="">
                          @if(unserialize($vehicule->etatPneu)[0]<3)
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->etatPneuInit)[0]}} bar<br>
                          </div>
                          @else
                          <div class="col-3"></div>
                          <div class="col-3 tableau" style="background: green">               
                           {{unserialize($vehicule->etatPneuInit)[0]}} bar<br>
                          </div>
                          @endif
                          @if(unserialize($vehicule->etatPneu)[1]<3)
                          <div class="col-3 tableau" style="background: red">       
                             {{unserialize($vehicule->etatPneuInit)[1]}} bar<br>
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">               
                           {{unserialize($vehicule->etatPneuInit)[1]}} bar<br>
                          </div>
                          <div class="col-3"></div>
                          @endif
                        </div>
                        <div class="row">
                          @if(isset(unserialize($vehicule->etatPneu)[4]))
                          @if(unserialize($vehicule->etatPneu)[4]<3)
                            <div class="col-3 tableau" style="background: red">       
                               {{unserialize($vehicule->etatPneuInit)[4]}} bar<br>
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">            
                             {{unserialize($vehicule->etatPneuInit)[4]}} bar<br>
                            </div>
                            @endif
                          @else
                            <div class="col-3"></div> 
                          @endif
                          @if(unserialize($vehicule->etatPneu)[2]<3)
                          <div class="col-3 tableau" style="background: red">       
                            {{unserialize($vehicule->etatPneuInit)[2]}} bar<br>
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">                 {{unserialize($vehicule->etatPneuInit)[2]}} bar<br>
                          </div>
                          @endif
                          @if(unserialize($vehicule->etatPneu)[3]<3)
                          <div class="col-3 tableau" style="background: red">       
                             {{unserialize($vehicule->etatPneuInit)[3]}} bar<br>
                          </div>
                          @else
                          <div class="col-3 tableau" style="background: green">               
                            {{unserialize($vehicule->etatPneuInit)[3]}} bar<br>
                          </div>
                          @endif
                          @if(isset(unserialize($vehicule->etatPneu)[5]))
                          @if(unserialize($vehicule->etatPneu)[5]<3)
                            <div class="col-3 tableau" style="background: red">       
                             {{unserialize($vehicule->etatPneuInit)[5]}} bar<br>
                            </div>
                            @else
                            <div class="col-3 tableau" style="background: green">             
                              {{unserialize($vehicule->etatPneuInit)[5]}} bar<br>
                            </div>
                            @endif
                          @endif
                        </div>
                    <hr>
                    <form role="form" method="post" action="{{Route('rendezVous.finished',$maintenance[0]->id)}}" style="border-style: unset;" enctype="multipart/form-data">
                              @csrf
                              @method('PUT')
                        <div class="form-group" style="text-align: left;">
                                <!-- <b>Durée : </b>{{date('H:i:s',abs(strtotime(date('H:i:s'))-strtotime($maintenance[0]->debut)))}}<br> -->
                            <label>Ordre de réparation: </label>
                            <textarea name="operation" class="form-control">{{$maintenance[0]->commentaire}}</textarea>
                            <label>Observation: </label>
                            <textarea name="observation" class="form-control"></textarea>
                            <label>Images : </label>
                            <input type="file" name="file" class="form-control">
                            <input type="file" name="file2" class="form-control">
                            <button class="btn btn-primary">Valider</button>
                        </div>
                    </form>

                    <!-- Modal -->
                    <div class="modal fade" id="mm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Rapport</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form role="form" method="post" action="{{Route('rendezVous.finished',$maintenance[0]->id)}}">
                              @csrf
                              @method('PUT')
                              <div class="form-group" style="text-align: left;">
                                <b>Durée : </b>{{date('H:i:s',abs(strtotime(date('H:i:s'))-strtotime($maintenance[0]->debut)))}}<br>
                                <label>Opérations effectuées: </label>
                                  <textarea name="operation" class="form-control"></textarea>
                                <button class="btn btn-primary">Valider</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
               <div class="col-4">
                <!-- pneus avd -->
                  <div class="row">
                    <div class="col-1 pneu" style="border-style: solid;height: 4cm;margin-top: 1cm"></div>
                    <div class="col-11">
                      <div  class="hide" style="border-style: ridge;width: 100%;padding-left: 1cm;">
                        <h3>AVD</h3>
                        Hauteur de gomme: {{unserialize($vehicule->hGomme)[1]}} mm<br>
                        Pression actuelle: {{unserialize($vehicule->etatPneu)[1]}}<br>
                        Pression conseillée: {{unserialize($vehicule->etatPneuInit)[1]-unserialize($vehicule->etatPneu)[1]}}
                        @foreach($stocks as $stock)
                          @if($stock->id==unserialize($vehicule->refPneus)[1])
                           <br> Ref :  {{$stock->reference}}
                          @endif
                        @endforeach
                        <BR>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#changeAVD">Changer</button>
                      </div>

                    </div>
                  </div>
                  <!--pneus ard-->
                   <div class="row">
                    <div class="col-1 pneu" style="border-style: solid;height: 4cm;margin-top: 5cm"></div>
                    @if(isset(unserialize($vehicule->hGomme)[5]))
                    <div class="col-1 ju" style="border-style: solid;height: 4cm;margin-top: 5cm"></div>
                    @else
                    <div class="col-1"></div>
                    @endif
                    <div class="col-10">
                      <div  class="hide" style="border-style: ridge;width: 100%;padding-left: 1cm;">
                        <h3>ARD</h3>
                        Hauteur de gomme: {{unserialize($vehicule->hGomme)[3]}} mm<br>
                        Pression actuelle: {{unserialize($vehicule->etatPneu)[3]}}<br>
                        Pression conseillée: {{unserialize($vehicule->etatPneuInit)[3]-unserialize($vehicule->etatPneu)[3]}}
                        @foreach($stocks as $stock)
                          @if($stock->id==unserialize($vehicule->refPneus)[3])
                            <br>Ref :  {{$stock->reference}}
                          @endif
                        @endforeach
                        <BR>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#changeARD">Changer</button>
                      </div>
                      @if(isset(unserialize($vehicule->hGomme)[5]))
                      <div  class="jum" style="border-style: ridge;width: 100%;padding-left: 1cm;">
                        <h3>ARD 2</h3>
                        Hauteur de gomme: {{unserialize($vehicule->hGomme)[5]}} mm<br>
                        Pression actuelle: {{unserialize($vehicule->etatPneu)[5]}}<br>
                        Pression conseillée: {{unserialize($vehicule->etatPneuInit)[5]-unserialize($vehicule->etatPneu)[5]}}
                        @foreach($stocks as $stock)
                          @if($stock->id==unserialize($vehicule->refPneus)[5])
                            <br>Ref :  {{$stock->reference}}
                          @endif
                        @endforeach
                        <BR>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#changeARD2">Changer</button>
                      </div>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
          </div>