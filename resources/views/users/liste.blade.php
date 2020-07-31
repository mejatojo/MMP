@extends('dashboard.dashboard')
@section('style')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">

@endsection
@section('content')
          <div class="card col-12">
            <div class="card-header card-success">

              <h3 class="card-title">Liste des utilisateurs</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nom</th>
                  <th>email/telephone</th>
                  <th>Entreprise</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($usersAccepted as $user)
                 <div class="modal fade" id="suprimer{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  Vous voulez vraiment supprimer cet utilisateur?
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                                  <a href="utilisateurs/destroy/{{$user->id}}" type="button" class="btn btn-primary">Oui</a>
                                </div>
                              </div>
                            </div>
                          </div>
                    <tr style="">
                      <td>{{$user->name}}</td>
                      <td>{{$user->email}}/{{$user->phone}}</td>
                      <td>{{$user->entreprise}} ({{$user->role}})</td>
                      <td>
                        <a href="find/{{$user->id}}" type="button" class="btn btn-warning"  data-toggle="tooltip" data-placement="bottom" title="Modifier">
                          <i class="fa fa-edit"></i>
                        </a>
                         <a  type="button" class="btn btn-danger" data-toggle="modal" data-target="#suprimer{{$user->id}}">
                          <i class="fa fa-trash-alt"></i>
                        </a> 
                        
                        <!-- <a type="button" class="btn btn-dark" data-toggle="tooltip" data-placement="bottom" title="Réinitialiser" href="utilisateurs/reinitialiser/{{$user->id}}">
                          <i class="fa fa-redo-alt"></i>
                        </a> -->
                        <!-- Modal -->
                        <div class="modal fade" id="exa{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modification</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                          <form method="post" action="{{Route('utilisateurs.update',$user->id)}}">
                                              @csrf
                                              @method('PUT')
                                              <div class="form-group row">
                                                  <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }}</label>

                                                  <div class="col-md-6">
                                                      <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$user->name}}" required autocomplete="name" autofocus>

                                                      @error('name')
                                                          <span class="invalid-feedback" role="alert">
                                                              <strong>{{ $message }}</strong>
                                                          </span>
                                                      @enderror
                                                  </div>
                                              </div>

                                              <div class="form-group row">
                                                  <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Adresse email') }}</label>

                                                  <div class="col-md-6">
                                                      <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$user->email}}" required autocomplete="email">

                                                      @error('email')
                                                          <span class="invalid-feedback" role="alert">
                                                              <strong>{{ $message }}</strong>
                                                          </span>
                                                      @enderror
                                                  </div>
                                              </div>

                                              <div class="form-group row">
                                                  <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('N° téléphone') }}</label>

                                                  <div class="col-md-6">
                                                      <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{$user->phone}}" required>

                                                      @error('phone')
                                                          <span class="invalid-feedback" role="alert">
                                                              <strong>{{ $message }}</strong>
                                                          </span>
                                                      @enderror
                                                  </div>
                                              </div>
                                               <div class="form-group row">
                                                  <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Rôle') }}</label>
                                                  <div class="col-md-6">
                                                      <select class="form-control" name="role">
                                                          @if($user->role=="conducteur")
                                                          <option value="conducteur">Conducteur</option>
                                                          <option value="responsable">Responsable</option>
                                                          <option value="PDG">PDG</option>
                                                         @elseif($user->role=="responsable")
                                                          <option value="responsable">Responsable</option>
                                                          <option value="conducteur">Conducteur</option>
                                                          <option value="PDG">PDG</option>
                                                          @elseif($user->role=="PDG")
                                                          <option value="PDG" selected>PDG</option>
                                                          <option value="responsable">Responsable</option>
                                                          <option value="conducteur">Conducteur</option>
                                                          @endif
                                                      </select>
                                                  </div>
                                                </div>



                                              <div class="form-group row">
                                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Rôle') }}</label>
                                                <div class="col-md-6">
                                                    <select class="form-control entreprise" name="role"  >
                                                        <option value="conducteur">Conducteur</option>
                                                        <option value="responsable">Responsable</option>
                                                        <option value="PDG">PDG</option>
                                                    </select>
                                                </div>
                                            </div>

                                             <div class="form-group row cResponsable" hidden="true" >
                                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Entreprise') }}</label>

                                                <div class="col-md-6">
                                                    <input  type="text" class="form-control createE @error('entreprise') is-invalid @enderror" name="entrepri" value="{{ old('entreprise') }}">

                                                    @error('entreprise')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>




                                              <div class="form-group row"  id="cConducteur">
                                                  <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Entreprise') }}</label>
                                                  <div class="col-md-6">
                                                      <select class="form-control" name="entreprise" id="choixE">
                                                          @foreach($entreprises as $entreprise)
                                                          @if($user->entreprise==$entreprise->entreprise)
                                                          <option value="{{$entreprise->entreprise}}" selected>{{$entreprise->entreprise}}</option>
                                                          @else
                                                          <option value="{{$entreprise->entreprise}}">{{$entreprise->entreprise}}</option>
                                                          @endif
                                                          @endforeach
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
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr> 
                @endforeach                             
                </tbody>
              </table>
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
<script type="text/javascript">
        var e=document.querySelector('#entreprise')
        e.addEventListener('change',function(){
            console.log(this.value)
            if(this.value==='responsable')
            {
                document.querySelector('#choixE').value=null;
                document.querySelector('#cConducteur').hidden=true;
                document.querySelector('#cResponsable').hidden=false;
            }
            if(this.value==='conducteur')
            {
                document.querySelector('#createE').value=null;
                document.querySelector('#cConducteur').hidden=false;
                document.querySelector('#cResponsable').hidden=true;
            }
            if(this.value==='PDG')
            {
                document.querySelector('#createE').value=null;
                document.querySelector('#cConducteur').hidden=false;
                document.querySelector('#cResponsable').hidden=true;
            }
        })
    </script>


@endsection