@extends('dashboard.dashboard')
@section('style')
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
@endsection
@section('content')

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Modification d\'un utilisateur') }}</div>

                <div class="card-body">
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
                                <select class="form-control" name="role" id="entreprise" >
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

                         <div class="form-group row" hidden="true" id="cResponsable">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Entreprise') }}</label>

                            <div class="col-md-6">
                                <input  type="text" class="form-control @error('entreprise') is-invalid @enderror" name="entrepri" value="{{$user->entreprise}}" id="createE">

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
                                    <option value="null"></option>
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
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Modifier') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script type="text/javascript">

        var e=document.querySelector('#entreprise')
        if(e.value==='responsable')
            {
                document.querySelector('#choixE').value=null;
                document.querySelector('#cConducteur').hidden=true;
                document.querySelector('#cResponsable').hidden=false;
            }
            if(e.value==='conducteur')
            {
                document.querySelector('#createE').value=null;
                document.querySelector('#cConducteur').hidden=false;
                document.querySelector('#cResponsable').hidden=true;
            }
            if(e.value==='PDG')
            {
                document.querySelector('#createE').value=null;
                document.querySelector('#cConducteur').hidden=false;
                document.querySelector('#cResponsable').hidden=true;
            }
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
