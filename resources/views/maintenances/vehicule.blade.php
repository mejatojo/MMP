                      <div class="modal fade" id="pression{{$vehicule->id}}" >
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div> 
                              <div class="modal-body">
                                <form action="{{route('vehicule.pression')}}" method="post">
                                  @csrf
                                  <input type="date" name="date" value="{{date('Y-m-d',strtotime($maintenance[0]->debut))}}" class="form-control" hidden>
                                  <input type="text" name="id" value="{{$vehicule->id}}" hidden>
                                  Voulez vous vraiment effectuer cette opération?  &emsp;
                                  <button class="btn btn-primary">Valider</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      <!--Modal-->
                        <div class="modal fade" id="changeAVG" >
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">pneu AVG (Mettre à jour les pneus avant changement)</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div> 
                              <div class="modal-body">
                               <label> Référence initial : </label>
                                 @foreach($stocks as $stock)
                                  @if($stock->id==unserialize($vehicule->refPneus)[0])
                                    {{$stock->reference}} <br>
                                    @if($stock->hgInit)
                                      <label>Hauteur de gomme initial : </label>{{$stock->hgInit}} mm<br>
                                    @endif
                                  @endif
                                @endforeach
                                <LABEL>Hauteur de gomme final : </LABEL>
                                {{unserialize($vehicule->hGomme)[0]}} mm
                                <hr>
                                <form action="{{route('changement.store')}}" method="post">
                                  @csrf
                                  <input type="text" name="idOld" value="{{unserialize($vehicule->refPneus)[0]}}" hidden>
                                  <input type="text" name="hgOld" value="{{unserialize($vehicule->hGomme)[0]}}" hidden>
                                  <input type="text" name="id" value="{{$vehicule->id}}" hidden>
                                  <input type="text" name="kil" value="{{$vehicule->kilometrage}}" hidden>
                                  <input type="text" name="place" value="0" hidden>
                                  <label>Nouvelle référence :</label><br>
                                  <select class="form-control select2" name="ref" required style="width: 100%">
                                    <option selected></option>
                                      @foreach($references as $stock)
                                      <option value="{{$stock->id}}">{{$stock->reference}}</option>
                                      @endforeach
                                  </select><br>
                                  <label>Nouveau hauteur de gomme :</label>
                                  <input type="text" name="hg" class="form-control" required>
                                  <input type="text" name="idmain" value="{{$maintenance[0]->id}}" hidden>
                   <input type="date" name="date" value="{{date('Y-m-d',strtotime($maintenance[0]->debut))}}" class="form-control" hidden>
                                  <button class="btn btn-primary">Valider</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!--Fin Modal-->
                        <!--Modal-->
                        <div class="modal fade" id="changeAVD" >
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">pneu AVD (Mettre à jour les pneus avant changement)</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <label> Référence initial : </label>
                                 @foreach($stocks as $stock)
                                  @if($stock->id==unserialize($vehicule->refPneus)[1])
                                    {{$stock->reference}} <br>
                                    @if($stock->hgInit)
                                      <label>Hauteur de gomme initial : </label>{{$stock->hgInit}} mm<br>
                                    @endif
                                  @endif
                                @endforeach
                                <LABEL>Hauteur de gomme final : </LABEL>
                                {{unserialize($vehicule->hGomme)[1]}} mm
                                <hr>
                                <form action="{{route('changement.store')}}" method="post">
                                  @csrf
                                  <input type="text" name="idOld" value="{{unserialize($vehicule->refPneus)[1]}}" hidden>
                                  <input type="text" name="hgOld" value="{{unserialize($vehicule->hGomme)[1]}}" hidden>
                                  <input type="text" name="id" value="{{$vehicule->id}}" hidden>
                                  <input type="text" name="kil" value="{{$vehicule->kilometrage}}" hidden>
                                  <input type="text" name="place" value="1" hidden>
                                  <label>Nouvelle référence :</label><br>
                                  <select class="form-control select2" name="ref" required style="width: 100%">
                                    <option></option>
                                      @foreach($references as $stock)
                                      <option value="{{$stock->id}}">{{$stock->reference}}</option>
                                      @endforeach
                                  </select><br>
                                  <label>Hauteur de gomme :</label>
                                  <input type="text" name="hg" class="form-control" required>
                                  <input type="text" name="idmain" value="{{$maintenance[0]->id}}" hidden>
                   <input type="date" name="date" value="{{date('Y-m-d',strtotime($maintenance[0]->debut))}}" class="form-control" hidden>
                                  <button class="btn btn-primary">Valider</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!--Fin Modal-->
                        <!--Modal-->
                        <div class="modal fade" id="changeARG" >
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">pneu ARG (Mettre à jour les pneus avant changement)</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <label> Référence initial : </label>
                                 @foreach($stocks as $stock)
                                  @if($stock->id==unserialize($vehicule->refPneus)[2])
                                    {{$stock->reference}} <br>
                                    @if($stock->hgInit)
                                      <label>Hauteur de gomme initial : </label>{{$stock->hgInit}} mm<br>
                                    @endif
                                  @endif
                                @endforeach
                                <LABEL>Hauteur de gomme final : </LABEL>
                                {{unserialize($vehicule->hGomme)[2]}} mm
                                <hr>
                                <form action="{{route('changement.store')}}" method="post">
                                  @csrf
                                  <input type="text" name="idOld" value="{{unserialize($vehicule->refPneus)[2]}}" hidden>
                                  <input type="text" name="hgOld" value="{{unserialize($vehicule->hGomme)[2]}}" hidden>
                                  <input type="text" name="id" value="{{$vehicule->id}}" hidden>
                                  <input type="text" name="kil" value="{{$vehicule->kilometrage}}" hidden>
                                  <input type="text" name="place" value="2" hidden>
                                  <label>Nouvelle référence :</label><br>
                                  <select class="form-control select2" name="ref" required style="width: 100%">
                                    <option></option>
                                      @foreach($references as $stock)
                                      <option value="{{$stock->id}}">{{$stock->reference}}</option>
                                      @endforeach
                                  </select><br>
                                  <label>Hauteur de gomme :</label>
                                  <input type="text" name="hg" class="form-control" required>
                                  <input type="text" name="idmain" value="{{$maintenance[0]->id}}" hidden>
                   <input type="date" name="date" value="{{date('Y-m-d',strtotime($maintenance[0]->debut))}}" class="form-control" hidden>
                                  <button class="btn btn-primary">Valider</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!--Fin Modal-->
                        <!--Modal-->
                        <div class="modal fade" id="changeARD" >
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">pneu ARD (Mettre à jour les pneus avant changement)</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <label> Référence initial : </label>
                                 @foreach($stocks as $stock)
                                  @if($stock->id==unserialize($vehicule->refPneus)[3])
                                    {{$stock->reference}} <br>
                                    @if($stock->hgInit)
                                      <label>Hauteur de gomme initial : </label>{{$stock->hgInit}} mm<br>
                                    @endif
                                  @endif
                                @endforeach
                                <LABEL>Hauteur de gomme final : </LABEL>
                                {{unserialize($vehicule->hGomme)[3]}} mm
                                <hr>
                                <form action="{{route('changement.store')}}" method="post">
                                  @csrf
                                  <input type="text" name="idOld" value="{{unserialize($vehicule->refPneus)[3]}}" hidden>
                                  <input type="text" name="hgOld" value="{{unserialize($vehicule->hGomme)[3]}}" hidden>
                                  <input type="text" name="id" value="{{$vehicule->id}}" hidden>
                                  <input type="text" name="kil" value="{{$vehicule->kilometrage}}" hidden>
                                  <input type="text" name="place" value="3" hidden>
                                  <label>Nouvelle référence :</label><br>
                                  <select class="form-control select2" name="ref" required style="width: 100%">
                                    <option></option>
                                      @foreach($references as $stock)
                                      <option value="{{$stock->id}}">{{$stock->reference}}</option>
                                      @endforeach
                                  </select><br>
                                  <label>Hauteur de gomme :</label>
                                  <input type="text" name="hg" class="form-control" required>
                                  <input type="text" name="idmain" value="{{$maintenance[0]->id}}" hidden>
                   <input type="date" name="date" value="{{date('Y-m-d',strtotime($maintenance[0]->debut))}}" class="form-control" hidden>
                                  <button class="btn btn-primary">Valider</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!--Fin Modal-->
                        <!--Modal-->
                         @if($vehicule->pneu==6)
                        <div class="modal fade" id="changeARG2" >
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">pneu ARG2 (Mettre à jour les pneus avant changement)</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                               
                                <label> Référence initial : </label>
                                 @foreach($stocks as $stock)
                                  @if($stock->id==unserialize($vehicule->refPneus)[4])
                                    {{$stock->reference}} <br>
                                    @if($stock->hgInit)
                                      <label>Hauteur de gomme initial : </label>{{$stock->hgInit}} mm<br>
                                    @endif
                                  @endif
                                @endforeach
                                <LABEL>Hauteur de gomme final : </LABEL>
                                {{unserialize($vehicule->hGomme)[4]}} mm
                                <hr>
                                <form action="{{route('changement.store')}}" method="post">
                                  @csrf
                                  <input type="text" name="idOld" value="{{unserialize($vehicule->refPneus)[4]}}" hidden>
                                  <input type="text" name="hgOld" value="{{unserialize($vehicule->hGomme)[4]}}" hidden>
                                  <input type="text" name="id" value="{{$vehicule->id}}" hidden>
                                  <input type="text" name="kil" value="{{$vehicule->kilometrage}}" hidden>
                                  <input type="text" name="place" value="4" hidden>
                                  <label>Nouvelle référence :</label><br>
                                  <select class="form-control col-12 select2" name="ref" required style="width: 100%">
                                    <option></option>
                                      @foreach($references as $stock)
                                      <option value="{{$stock->id}}">{{$stock->reference}}</option>
                                      @endforeach
                                  </select><br>
                                  <label>Hauteur de gomme :</label>
                                  <input type="text" name="hg" class="form-control" required>
                                  <input type="text" name="idmain" value="{{$maintenance[0]->id}}" hidden>
                   <input type="date" name="date" value="{{date('Y-m-d',strtotime($maintenance[0]->debut))}}" class="form-control" hidden>
                                  <button class="btn btn-primary">Valider</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!--Fin Modal-->
                        <!--Modal-->
                        <div class="modal fade" id="changeARD2" >
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">pneu ARD2 (Mettre à jour les pneus avant changement)</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <label> Référence initial : </label>
                                 @foreach($stocks as $stock)
                                  @if($stock->id==unserialize($vehicule->refPneus)[5])
                                    {{$stock->reference}} <br>
                                    @if($stock->hgInit)
                                      <label>Hauteur de gomme initial : </label>{{$stock->hgInit}} mm<br>
                                    @endif
                                  @endif
                                @endforeach
                                <LABEL>Hauteur de gomme final : </LABEL>
                                {{unserialize($vehicule->hGomme)[5]}} mm
                                <hr>
                                <form action="{{route('changement.store')}}" method="post">
                                  @csrf
                                  <input type="text" name="idOld" value="{{unserialize($vehicule->refPneus)[5]}}" hidden>
                                  <input type="text" name="hgOld" value="{{unserialize($vehicule->hGomme)[5]}}" hidden>
                                  <input type="text" name="id" value="{{$vehicule->id}}" hidden>
                                  <input type="text" name="kil" value="{{$vehicule->kilometrage}}" hidden>
                                  <input type="text" name="place" value="5" hidden>
                                  <label>Référence :</label>
                                  <select class="form-control" name="ref" required>
                                    <option></option>
                                      @foreach($references as $stock)
                                      <option value="{{$stock->id}}">{{$stock->reference}}</option>
                                      @endforeach
                                  </select>
                                  <label>Hauteur de gomme :</label>
                                  <input type="text" name="hg" class="form-control" required>
                                  <input type="text" name="idmain" value="{{$maintenance[0]->id}}" hidden>
                   <input type="date" name="date" value="{{date('Y-m-d',strtotime($maintenance[0]->debut))}}" class="form-control" hidden>
                                  <button class="btn btn-primary">Valider</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        @endif
                        <!--Fin Modal-->
<div class="col-md-12">
              <h1 style="text-align: center">Intervention de "{{$vehicule->immatriculation}}" le 

                {{date('d/m/Y',strtotime($maintenance[0]->debut))}}</h1>
              <!-- Menu -->

              <div class="row">
              <a href="/maintenances" class="btn btn-default col-3">Retour à la liste</a>
              <button class="btn btn-default  col-3" data-toggle="modal" data-target="#pression{{$vehicule->id}}">Pressions  effectuées</button>
              @if($vehicule->pneu==4 and $maintenance[0]->referenceIn==null)
              <button type="button" class="btn btn-default col-3" data-toggle="modal" data-target="#exampleModal">
                Permutation
              </button>
              @else
              <button type="button" class="btn btn-default col-3" disabled>
                Permutation
              </button>
              @endif

              <!--Modal permutation-->
                <div class="modal fade" id="exampleModal" >
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

                   <label>Permutation (glissez et déposez sur la case mais pas sur les détails)</label>
                        <form role="form" method="post" action="{{Route('vehicules.update',$vehicule->id)}}">
                          @csrf
                          @method('PUT')
                        <div class="row" style="text-align: center">
                        <div class="col-3"></div>
                        <div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)" class="col-3">
                          <div style="width: 100%;height: 100%" draggable="true" ondragstart="drag(event)" id="drag1" class="list">
                            <font color="black">{{unserialize($vehicule->hGomme)[0]}} mm<br>
                              </font>
                          </div>
                           <input type="text" name="place[]" hidden="true" value="0">
                      </div>
                      <div id="div2" ondrop="drop(event)" ondragover="allowDrop(event)" class="col-3">
                        <div style="width: 100%;height: 100%" draggable="true" ondragstart="drag(event)" id="drag2" class="list">
                         <font color="brown"> {{unserialize($vehicule->hGomme)[1]}} mm<br>
                              </font>
                        </div>
                        <input type="text" name="place[]" hidden="true" value="1">
                      </div>
                      <div class="col-3"></div>
                       @if(isset(unserialize($vehicule->hGomme)[4]))
                        <div id="div5" ondrop="drop(event)" ondragover="allowDrop(event)" class="col-3">
                        <div style="width: 100%;height: 100%" draggable="true" ondragstart="drag(event)" id="drag5" class="list">
                          <font color="yellow">{{unserialize($vehicule->hGomme)[4]}} mm<br>
                              </font>
                        </div>
                        <input type="text" name="placeS[]"  hidden="true" value="4">
                      </div>
                       @else
                       <div class="col-3"></div>
                       @endif
                      <div id="div3" ondrop="drop(event)" ondragover="allowDrop(event)" class="col-3">
                        <div style="width: 100%;height: 100%" draggable="true" ondragstart="drag(event)" id="drag3" class="list">
                          <font color="red">{{unserialize($vehicule->hGomme)[2]}} mm<br>
                              </font>
                        </div>
                        <input type="text" name="place[]"  hidden="true" value="2">
                      </div>
                      <div id="div4" ondrop="drop(event)" ondragover="allowDrop(event)" class="col-3">
                        <div style="width: 100%;height: 100%" draggable="true" ondragstart="drag(event)" id="drag4" class="list">
                          <font color="green">{{unserialize($vehicule->hGomme)[3]}} mm<br>
                             </font>
                        </div>
                        <input type="text" name="place[]" hidden="true" value="3">
                      </div>
                      @if(isset(unserialize($vehicule->hGomme)[5]))
                        <div id="div6" ondrop="drop(event)" ondragover="allowDrop(event)" class="col-3">
                        <div style="width: 100%;height: 100%" draggable="true" ondragstart="drag(event)" id="drag6" class="list">
                          <font color="blue"> {{unserialize($vehicule->hGomme)[5]}} mm<br>
                              </font>
                        </div>
                        <input type="text" name="placeS[]"  hidden="true" value="5">
                      </div>
                       @else
                       <div class="col-3"></div>
                       @endif
                   </div>
                   
                   <input type="date" name="date" value="{{date('Y-m-d',strtotime($maintenance[0]->debut))}}" class="form-control" hidden>
                       <button class="btn btn-primary">Valider</button>
                     </form>
                      </div>
                    </div>
                  </div>
                </div>
              <!--Fin permutation-->
              @if($maintenance[0]->kilometrageIn==null)
              <a type="button" class="btn btn-default col-3" data-toggle="modal" data-target="#myModal">
                   Mettre à jour
              </a>
              @else
              <button type="button" class="btn btn-default col-3" disabled>
                   Mettre à jour
              </button>
              @endif
              <div class="modal fade" id="myModal" >
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
                                          <input type="text" class="form-control" name="hg[]" placeholder="AVG" value="{{unserialize($vehicule->hGomme)[0]}}">
                                        </div>
                                        <div class="col-3">
                                          <input type="text" class="form-control" name="hg[]" placeholder="AVD" value="{{unserialize($vehicule->hGomme)[1]}}">
                                        </div>
                                      </div>
                                      <div class="row">
                                        @if($vehicule->pneu==6)
                                        <div class="col-3">
                                          <input type="text" class="form-control" name="hg[]" placeholder="ARG 2" value="{{unserialize($vehicule->hGomme)[4]}}">
                                        </div>
                                        @else
                                        <div class="col-3"></div>
                                        @endif
                                        <div class="col-3">
                                          <input type="text" class="form-control" name="hg[]" placeholder="ARG" value="{{unserialize($vehicule->hGomme)[2]}}">
                                        </div>
                                        <div class="col-3">
                                          <input type="text" class="form-control" name="hg[]" placeholder="ARD" value="{{unserialize($vehicule->hGomme)[3]}}">
                                        </div>
                                        @if($vehicule->pneu==6)
                                        <div class="col-3">
                                          <input type="text" class="form-control" name="hg[]" placeholder="ARD 2" value="{{unserialize($vehicule->hGomme)[5]}}">
                                        </div>
                                        @endif
                                      </div>
                                      <div class="form-group">
                                      <label for="exampleInputPassword1">kilomètrage: </label>
                                      <input type="text" class="form-control" id="exampleInputPassword1" name="kilometrage" value="{{$vehicule->kilometrage}}">
                                      <input type="text" name="maintenance" value="{{$maintenance[0]->ide}}" hidden>
                                    </div>
                                    
                   <input type="date" name="date" value="{{date('Y-m-d',strtotime($maintenance[0]->debut))}}" class="form-control" hidden>
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
                        Hauteur de gomme: 
                        @if($maintenance[0]->hGommeIn==null)
                        {{unserialize($vehicule->hGomme)[0]}} mm<br>
                        @else
                        {{unserialize($maintenance[0]->hGommeIn)[0]}} mm<br>
                        @endif
                        Pression actuelle: {{unserialize($vehicule->etatPneu)[0]}}
                        @if($maintenance[0]->referenceIn==null)
                          @foreach($stocks as $stock)
                            @if($stock->id==unserialize($vehicule->refPneus)[0])
                             <br> Ref :  {{$stock->reference}}
                            @endif
                          @endforeach
                        @else
                          @foreach($stocks as $stock)
                            @if($stock->id==unserialize($maintenance[0]->referenceIn)[0])
                             <br> Ref :  {{$stock->reference}}
                            @endif
                           @endforeach
                        @endif
                        <BR>
                        @if($maintenance[0]->referenceIn==null)
                        <button class="btn btn-primary" data-toggle="modal" data-target="#changeAVG">Changer</button>
                        @else
                        <button class="btn btn-primary" disabled>Changer</button>
                        @endif
                      </div>
                    </div>
                    <div class="col-1 pneu"  style="border-style: solid;height: 4cm;margin-top: 1cm"></div>
                  </div>
                  <!-- pneus arg -->
                  <div class="row">
                    <div class="col-10">
                        <div  class="hide" style="border-style: ridge;width: 100%;padding-left: 1cm;">
                        <h3>ARG</h3>
                        Hauteur de gomme: 
                        @if($maintenance[0]->hGommeIn==null)
                        {{unserialize($vehicule->hGomme)[2]}} mm<br>
                        @else
                        {{unserialize($maintenance[0]->hGommeIn)[2]}} mm<br>
                        @endif
                        Pression actuelle: {{unserialize($vehicule->etatPneu)[2]}}
                        @if($maintenance[0]->referenceIn==null)
                          @foreach($stocks as $stock)
                            @if($stock->id==unserialize($vehicule->refPneus)[2])
                             <br> Ref :  {{$stock->reference}}
                            @endif
                          @endforeach
                        @else
                          @foreach($stocks as $stock)
                            @if($stock->id==unserialize($maintenance[0]->referenceIn)[2])
                             <br> Ref :  {{$stock->reference}}
                            @endif
                           @endforeach
                        @endif
                        <BR>
                        @if($maintenance[0]->referenceIn==null)
                        <button class="btn btn-primary" data-toggle="modal" data-target="#changeARG">Changer</button>
                        @else
                        <button class="btn btn-primary" disabled>Changer</button>
                        @endif
                      </div>
                      @if(isset(unserialize($vehicule->hGomme)[4]))
                      <div  class="jum" style="border-style: ridge;width: 100%;padding-left: 1cm;">
                        <h3>ARG2</h3>
                        Hauteur de gomme: 
                        @if($maintenance[0]->hGommeIn==null)
                        {{unserialize($vehicule->hGomme)[4]}} mm<br>
                        @else
                        {{unserialize($maintenance[0]->hGommeIn)[4]}} mm<br>
                        @endif
                        Pression actuelle: {{unserialize($vehicule->etatPneu)[4]}}
                         @if($maintenance[0]->referenceIn==null)
                          @foreach($stocks as $stock)
                            @if($stock->id==unserialize($vehicule->refPneus)[4])
                             <br> Ref :  {{$stock->reference}}
                            @endif
                          @endforeach
                        @else 
                          @foreach($stocks as $stock)
                            @if($stock->id==unserialize($maintenance[0]->referenceIn)[4])
                             <br> Ref :  {{$stock->reference}}
                            @endif
                           @endforeach
                        @endif
                        <BR>
                        @if($maintenance[0]->referenceIn==null)
                        <button class="btn btn-primary" data-toggle="modal" data-target="#changeARG2">Changer</button>
                        @else
                        <button class="btn btn-primary" disabled>Changer</button>
                        @endif
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
                <div class="col-4" style="border-style: ridge;height: 17cm;text-align: center;">
                  <h4>
                    Kilomètrage:
                    @if($maintenance[0]->kilometrageIn==null)
                    {{$vehicule->kilometrage}}
                    @else
                    {{$maintenance[0]->kilometrageIn}}
                    @endif
                    km
                    <br>
                    Permutation dans 
                    @if($maintenance[0]->permutationIn==null)
                    {{$vehicule->permutation}}
                    @else
                    {{$maintenance[0]->permutationIn}}
                    @endif
                     km <br>
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
                            <button class="btn btn-primary">Terminer</button>
                        <div class="form-group" style="text-align: left;">
                                <!-- <b>Durée : </b>{{date('H:i:s',abs(strtotime(date('H:i:s'))-strtotime($maintenance[0]->debut)))}}<br> -->
                            <label>Ordre de réparation: </label>
                            <textarea name="operation" class="form-control" required>{{$maintenance[0]->commentaire}}</textarea>
                            <label>Observation: </label>
                            <textarea name="observation" class="form-control" required>{{$vehicule->observations}}</textarea>
                            <label>Images : </label>
                            <div class="row">
                            <input type="file" name="file" class="form-control col-6">
                            <input type="file" name="file2" class="form-control col-6">
                            
                   <input type="date" name="date" value="{{date('Y-m-d',strtotime($maintenance[0]->debut))}}" class="form-control" hidden>
                          </div>
                        </div>
                    </form>

                    <!-- Modal -->
                    <div class="modal fade" id="mm" >
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
                        Hauteur de gomme: 
                        @if($maintenance[0]->hGommeIn==null)
                        {{unserialize($vehicule->hGomme)[1]}} mm<br>
                        @else
                        {{unserialize($maintenance[0]->hGommeIn)[1]}} mm<br>
                        @endif
                        Pression actuelle: {{unserialize($vehicule->etatPneu)[1]}}
                        @if($maintenance[0]->referenceIn==null)
                          @foreach($stocks as $stock)
                            @if($stock->id==unserialize($vehicule->refPneus)[1])
                             <br> Ref :  {{$stock->reference}}
                            @endif
                          @endforeach
                        @else
                          @foreach($stocks as $stock)
                            @if($stock->id==unserialize($maintenance[0]->referenceIn)[1])
                             <br> Ref :  {{$stock->reference}}
                            @endif
                           @endforeach
                        @endif
                        <BR>
                        @if($maintenance[0]->referenceIn==null)
                        <button class="btn btn-primary" data-toggle="modal" data-target="#changeAVD">Changer</button>
                        @else
                        <button class="btn btn-primary" disabled>Changer</button>
                        @endif
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
                        Hauteur de gomme: 
                        @if($maintenance[0]->hGommeIn==null)
                        {{unserialize($vehicule->hGomme)[3]}} mm<br>
                        @else
                        {{unserialize($maintenance[0]->hGommeIn)[3]}} mm<br>
                        @endif
                        Pression actuelle: {{unserialize($vehicule->etatPneu)[3]}}
                        @if($maintenance[0]->referenceIn==null)
                          @foreach($stocks as $stock)
                            @if($stock->id==unserialize($vehicule->refPneus)[3])
                             <br> Ref :  {{$stock->reference}}
                            @endif
                          @endforeach
                        @else
                          @foreach($stocks as $stock)
                            @if($stock->id==unserialize($maintenance[0]->referenceIn)[3])
                             <br> Ref :  {{$stock->reference}}
                            @endif
                           @endforeach
                        @endif
                        <BR>
                        @if($maintenance[0]->referenceIn==null)
                        <button class="btn btn-primary" data-toggle="modal" data-target="#changeARD">Changer</button>
                        @else
                        <button class="btn btn-primary" disabled>Changer</button>
                        @endif
                      </div>
                      @if(isset(unserialize($vehicule->hGomme)[5]))
                      <div  class="jum" style="border-style: ridge;width: 100%;padding-left: 1cm;">
                        <h3>ARD 2</h3>
                        Hauteur de gomme: 
                        Hauteur de gomme: 
                        @if($maintenance[0]->hGommeIn==null)
                        {{unserialize($vehicule->hGomme)[5]}} mm<br>
                        @else
                        {{unserialize($maintenance[0]->hGommeIn)[5]}} mm<br>
                        @endif
                        Pression actuelle: {{unserialize($vehicule->etatPneu)[5]}}
                        @if($maintenance[0]->referenceIn==null)
                          @foreach($stocks as $stock)
                            @if($stock->id==unserialize($vehicule->refPneus)[5])
                             <br> Ref :  {{$stock->reference}}
                            @endif
                          @endforeach
                        @else
                          @foreach($stocks as $stock)
                            @if($stock->id==unserialize($maintenance[0]->referenceIn)[5])
                             <br> Ref :  {{$stock->reference}}
                            @endif
                           @endforeach
                        @endif
                        <BR>
                        @if($maintenance[0]->referenceIn==null)
                        <button class="btn btn-primary" data-toggle="modal" data-target="#changeARD2">Changer</button>
                        @else
                        <button class="btn btn-primary" disabled>Changer</button>
                        @endif
                      </div>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
          </div>