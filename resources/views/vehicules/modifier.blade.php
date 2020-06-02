<form method="post" action="{{Route('vehicules.modifRapide',$vehicule->id)}}">
    @csrf
    @method('PUT')
    <div class="form-group row">
      <div class="col-md-4">
      <label for="name">{{ __('Immatriculation') }}</label>
         <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="immatriculation" value="{{$vehicule->immatriculation}}" required autocomplete="name" autofocus>
      </div>
      <div class="col-md-4">
      <label >Date de mise en circulation : </label>
      <input type="date" name="datec" class="form-control" value="{{$vehicule->dateC}}">
    </div>
    <div class="col-md-4">
      <label>Dernière maintenance : </label>
      <input type="date" name="dmaintenance" class="form-control" value="{{$vehicule->derniereMaintenance}}">
    </div>
  </div>
    <div class="form-group row">
      <div class="col-md-4">
        <label>Nom : </label>
        <input type="text" name="nomH" class="form-control" value="{{$vehicule->nomH}}">
    </div>
    <div class="col-md-4">
      <label>Email : </label>
      <input type="text" name="emailH" class="form-control" value="{{$vehicule->emailH}}">
    </div>
    <div class="col-md-4">
      <label>Phone : </label>
      <input type="text" name="phoneH" class="form-control" value="{{$vehicule->phoneH}}">
      <input type="text" value="{{$vehicule->pneu}}" name="pne" hidden>
    </div>
  </div>
    <div class="form-group row">
      <div class="col-md-4">
        <label for="email">{{ __('Model') }}</label>
        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="model" value="{{$vehicule->model}}" required autocomplete="email">
      </div>
      <div class="col-md-4">
        <label for="email">{{ __('Marque') }}</label>
        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="marque" value="{{$vehicule->marque}}" required>
      </div>
      <div class="col-md-4">
        <label for="password">{{ __('Entreprise') }}</label>
          <select class="form-control" name="conducteur" id="choixE">
            @foreach($entreprises as $entreprise)
              @if($vehicule->entreprise==$entreprise->entreprise)
                <option value="{{$entreprise->id}}" selected>{{$entreprise->entreprise}}</option>
              @else
                <option value="{{$entreprise->id}}">{{$entreprise->entreprise}}</option>
              @endif
            @endforeach
          </select>
    </div>
  </div>
    

    <div class="row">
      <div class="col-md-6">
        <label> Hauteur de gomme actuel</label>
        <div class="row">
          <div class="col-6">
            <input type="text" class="form-control" name="hg[]" placeholder="AVG" value="{{unserialize($vehicule->hGomme)[0]}}">
          </div>
          <div class="col-6">
            <input type="text" class="form-control" name="hg[]" placeholder="AVD" value="{{unserialize($vehicule->hGomme)[1]}}">
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <input type="text" class="form-control" name="hg[]" placeholder="ARG" value="{{unserialize($vehicule->hGomme)[2]}}">
          </div>
          <div class="col-6">
            <input type="text" class="form-control" name="hg[]" placeholder="ARD" value="{{unserialize($vehicule->hGomme)[3]}}">
          </div>
        </div>
        @if($vehicule->pneu==6)
          <div class="row">
            <div class="col-6">
              <input type="text" class="form-control" name="hg2[]" placeholder="ARG 2" value="{{unserialize($vehicule->hGomme)[4]}}">
            </div>
            <div class="col-6">
              <input type="text" class="form-control" name="hg2[]" placeholder="ARD2" value="{{unserialize($vehicule->hGomme)[5]}}">
            </div>
          </div>
        @endif
      </div>
      <div class="col-md-6">
        <label>Pression maximale : </label>
        <div>
          <input type="text" class="form-control col-6" name="pneuI[]" placeholder="AVG" hidden value="{{unserialize($vehicule->etatPneu)[0]}}">
          <input type="text" class="form-control col-6 init" name="pneuI[]" placeholder="pression AV" value="{{unserialize($vehicule->etatPneu)[0]}}">
        </div>
        <div>
          <input type="text" class="form-control col-6" name="pneuI[]" placeholder="AVG" hidden value="{{unserialize($vehicule->etatPneu)[3]}}">
          <input type="text" class="form-control col-6 init" name="pneuI[]" placeholder="pression AR" value="{{unserialize($vehicule->etatPneu)[3]}}">
        </div>
        @if($vehicule->pneu==6)
        <div>
          <input type="text" class="form-control col-6" name="pneuI2[]" placeholder="AVG" hidden value="{{unserialize($vehicule->etatPneu)[5]}}">
          <input type="text" class="form-control col-6 init" name="pneuI2[]" placeholder="pression AR2" value="{{unserialize($vehicule->etatPneu)[5]}}">
        </div>
        @endif
      </div>
    </div>

                                      <label>Réference des pneus</label>
                                     <div class="form-group  row">
                                      <div class="col-3"></div>
                                        <select class="form-control col-3" name="ref[]">
                                          @foreach($references as $reference)
                                            @if($reference->id==unserialize($vehicule->refPneus)[0])
                                              @foreach($refPneus as $stock)
                                                @if($stock->id==$reference->reference_id)
                                                <option value="{{$stock->id}}" selected>{{$stock->reference}}</option>
                                                @endif
                                              @endforeach
                                              @foreach($refPneus as $stock)
                                                @if($stock->id!=$reference->reference_id)
                                                <option value="{{$stock->id}}">{{$stock->reference}}</option>
                                                @endif
                                              @endforeach
                                            @endif
                                          @endforeach
                                          
                                        </select>
                                        <select class="form-control col-3" name="ref[]">
                                         @foreach($references as $reference)
                                            @if($reference->id==unserialize($vehicule->refPneus)[1])
                                              @foreach($refPneus as $stock)
                                                @if($stock->id==$reference->reference_id)
                                                <option value="{{$stock->id}}" selected>{{$stock->reference}}</option>
                                                @endif
                                              @endforeach
                                              @foreach($refPneus as $stock)
                                                @if($stock->id!=$reference->reference_id)
                                                <option value="{{$stock->id}}">{{$stock->reference}}</option>
                                                @endif
                                              @endforeach
                                            @endif
                                          @endforeach
                                        </select>
                                        <div class="col-3"></div>
                                     </div>
                                     <div class="form-group  row">
                                      @if($vehicule->pneu==6)
                                        <select class="form-control col-3 " name="ref2[]" >
                                          @foreach($references as $reference)
                                            @if($reference->id==unserialize($vehicule->refPneus)[4])
                                              @foreach($refPneus as $stock)
                                                @if($stock->id==$reference->reference_id)
                                                <option value="{{$stock->id}}" selected>{{$stock->reference}}</option>
                                                @endif
                                              @endforeach
                                              @foreach($refPneus as $stock)
                                                @if($stock->id!=$reference->reference_id)
                                                <option value="{{$stock->id}}">{{$stock->reference}}</option>
                                                @endif
                                              @endforeach
                                            @endif
                                          @endforeach
                                        </select>
                                      @else
                                        <div class="col-3"></div>
                                      @endif
                                        <select class="form-control col-3" name="ref[]">
                                          @foreach($references as $reference)
                                            @if($reference->id==unserialize($vehicule->refPneus)[2])
                                              @foreach($refPneus as $stock)
                                                @if($stock->id==$reference->reference_id)
                                                <option value="{{$stock->id}}" selected>{{$stock->reference}}</option>
                                                @endif
                                              @endforeach
                                              @foreach($refPneus as $stock)
                                                @if($stock->id!=$reference->reference_id)
                                                <option value="{{$stock->id}}">{{$stock->reference}}</option>
                                                @endif
                                              @endforeach
                                            @endif
                                          @endforeach
                                        </select>

                                        <select class="form-control col-3" name="ref[]">
                                          @foreach($references as $reference)
                                            @if($reference->id==unserialize($vehicule->refPneus)[3])
                                              @foreach($refPneus as $stock)
                                                @if($stock->id==$reference->reference_id)
                                                <option value="{{$stock->id}}" selected>{{$stock->reference}}</option>
                                                @endif
                                              @endforeach
                                              @foreach($refPneus as $stock)
                                                @if($stock->id!=$reference->reference_id)
                                                <option value="{{$stock->id}}">{{$stock->reference}}</option>
                                                @endif
                                              @endforeach
                                            @endif
                                          @endforeach
                                        </select>
                                      @if($vehicule->pneu==6)
                                        <select class="form-control col-3 " name="ref2[]" >
                                          @foreach($references as $reference)
                                            @if($reference->id==unserialize($vehicule->refPneus)[5])
                                              @foreach($refPneus as $stock)
                                                @if($stock->id==$reference->reference_id)
                                                <option value="{{$stock->id}}" selected>{{$stock->reference}}</option>
                                                @endif
                                              @endforeach
                                              @foreach($refPneus as $stock)
                                                @if($stock->id!=$reference->reference_id)
                                                <option value="{{$stock->id}}">{{$stock->reference}}</option>
                                                @endif
                                              @endforeach
                                            @endif
                                          @endforeach
                                        </select>
                                      @else
                                        <div class="col-3"></div>
                                      @endif
                                     </div>
                                     <div class="form-group row">
                                       <div class="form-group col-4">
                                      <label for="exampleInputPassword1">kilomètrage: </label>
                                      <input type="number" class="form-control" id="exampleInputPassword1" name="kilometrage" value="{{$vehicule->kilometrage}}">
                                    </div>
                                    <div class="form-group col-4">
                                      <label for="exampleInputPassword1">Couple serrage: </label>
                                      <input type="number" class="form-control" id="exampleInputPassword1" name="serrage" value="{{$vehicule->serrage}}">
                                    </div>
                                    <div class="form-group col-4">
                                      <label for="exampleInputPassword1">Type de permutation: </label>
                                      <select class="form-control" name="type" >
                                          <option value="aucune">Aucune</option>
                                          <option value="traction">Traction</option>
                                          <option value="propulsion">Propulsion</option>
                                          <option value="4*4">4*4</option>
                                          <option value="asymétrique">Asymétrique</option>
                                        </select>
                                    </div> 
                                    </div> 


    <div class="form-group row mb-0">
      <div class="col-md-2 offset-md-9">
        <button type="submit" class="btn btn-primary">
          {{ __('Modifier') }}
        </button>
      </div>
    </div>
</form>