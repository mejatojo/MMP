
                                  <div class="row">
                                    <div class="col-6">
                                  <!-- <label>Pressions actuelles: </label>
                                      <div class="row">
                                        <div class="col-6">
                                          <input type="text" class="form-control" name="pneu[]" placeholder="AVG">
                                        </div>
                                        <div class="col-6">
                                          <input type="text" class="form-control" name="pneu[]" placeholder="AVD">
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-6">
                                          <input type="text" class="form-control" name="pneu[]" placeholder="ARG">
                                        </div>
                                        <div class="col-6">
                                          <input type="text" class="form-control" name="pneu[]" placeholder="ARD">
                                        </div>
                                      </div>
                                      <div class="row cache">
                                        <div class="col-6">
                                          <input type="text" class="form-control" name="pneu2[]" placeholder="ARG 2">
                                        </div>
                                        <div class="col-6">
                                          <input type="text" class="form-control" name="pneu2[]" placeholder="ARD2">
                                        </div>
                                      </div> -->
                                      <!--  -->
                                      <!-- maximale -->
                                      <label> Hauteur de gomme actuel</label>
                                      <div class="row">
                                        <div class="col-6">
                                          <input type="text" class="form-control" name="hg[]" placeholder="AVG">
                                        </div>
                                        <div class="col-6">
                                          <input type="text" class="form-control" name="hg[]" placeholder="AVD">
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-6">
                                          <input type="text" class="form-control" name="hg[]" placeholder="ARG">
                                        </div>
                                        <div class="col-6">
                                          <input type="text" class="form-control" name="hg[]" placeholder="ARD">
                                        </div>
                                      </div>
                                      <div class="row cache" >
                                        <div class="col-6">
                                          <input type="text" class="form-control" name="hg2[]" placeholder="ARG 2">
                                        </div>
                                        <div class="col-6">
                                          <input type="text" class="form-control" name="hg2[]" placeholder="ARD2">
                                        </div>
                                      </div>
                                      <!--  -->
                                  </div>
                                    <div class="col-6">
                                  <label>Pressions initiales(maximales): </label>
                                      <div class="row">
                                          <input type="text" class="form-control col-6" name="pneuI[]" placeholder="AVG" hidden>
                                          <input type="text" class="form-control col-6 init" name="pneuI[]" placeholder="pression AV">
                                      </div>
                                      <div class="row">
                                          <input type="text" class="form-control col-6" name="pneuI[]" placeholder="AR" hidden>
                                          <input type="text" class="form-control col-6 init" name="pneuI[]" placeholder="pression AR">
                                      </div>
                                      <div class="row cache" >
                                          <input type="text" class="form-control col-6" name="pneuI2[]" placeholder="AR 2" hidden>
                                          <input type="text" class="form-control col-6 init" name="pneuI2[]" placeholder="pression AR 2">
                                      </div>
                                  </div>
                              </div>

                                      <label>Réference des pneus</label>
                                     <div class="form-group  row">
                                      <div class="col-3"></div>
                                        <select class="form-control col-3" name="ref[]">
                                          <option></option>
                                          @foreach($references as $stock)
                                          <option value="{{$stock->id}}">{{$stock->reference}}</option>
                                          @endforeach
                                        </select>
                                        <select class="form-control col-3" name="ref[]">
                                          <option></option>
                                          @foreach($references as $stock)
                                          <option value="{{$stock->id}}">{{$stock->reference}}</option>
                                          @endforeach
                                        </select>
                                        <div class="col-3"></div>
                                     </div>
                                     <div class="form-group  row">
                                      <select class="form-control col-3 cache" name="ref2[]" >
                                        <option></option>
                                          @foreach($references as $stock)
                                          <option value="{{$stock->id}}">{{$stock->reference}}</option>
                                          @endforeach
                                        </select>
                                        <select class="form-control col-3" name="ref[]">
                                          <option></option>
                                          @foreach($references as $stock)
                                          <option value="{{$stock->id}}">{{$stock->reference}}</option>
                                          @endforeach
                                        </select>

                                        <select class="form-control col-3" name="ref[]">
                                          <option></option>
                                          @foreach($references as $stock)
                                          <option value="{{$stock->id}}">{{$stock->reference}}</option>
                                          @endforeach
                                        </select>
                                      <select class="form-control col-3 cache" name="ref2[]" >
                                        <option></option>
                                          @foreach($references as $stock)
                                          <option value="{{$stock->id}}">{{$stock->reference}}</option>
                                          @endforeach
                                        </select>
                                     </div>
                                     <div class="row">
                                    <div class="form-group col-4">
                                      <label for="exampleInputPassword1">kilomètrage: </label>
                                      <input type="number" class="form-control" id="exampleInputPassword1" name="kilometrage">
                                    </div>
                                    <div class="form-group col-4">
                                      <label for="exampleInputPassword1">Couple serrage: </label>
                                      <input type="number" class="form-control" id="exampleInputPassword1" name="serrage">
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
                                  <div class="row">
                                    <div class="form-group col-4">
                                      <label for="exampleInputPassword1">Nom : </label>
                                      <input type="text" class="form-control" id="exampleInputPassword1" name="nomH">
                                    </div>
                                    <div class="form-group col-4">
                                      <label for="exampleInputPassword1">email : </label>
                                      <input type="email" class="form-control" id="exampleInputPassword1" name="emailH">
                                    </div>
                                    <div class="form-group col-4">
                                      <label for="exampleInputPassword1">phone : </label>
                                      <input type="text" class="form-control" id="exampleInputPassword1" name="phoneH">
                                    </div>
                                  </div>
                                    <!-- <button type="submit" class="btn btn-primary">Ajouter</button> -->
