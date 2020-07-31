@extends('dashboard.dashboard')
@section('style')
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
@endsection
@section('content')

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Ajout d\'un utilisateur') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('utilisateurs.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$vehicule[0]->nomH}}" required autocomplete="name" autofocus>

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
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$vehicule[0]->emailH}}" required autocomplete="email">

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
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{$vehicule[0]->phoneH}}" required>

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
                                    <option value="conducteur">Conducteur</option>
                                    <option value="responsable">Responsable</option>
                                </select>
                        </div>
                        </div>

                         <div class="form-group row" hidden="true" id="cResponsable">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Entreprise') }}</label>

                            <div class="col-md-6">
                                <input  type="text" class="form-control @error('entreprise') is-invalid @enderror" name="entrepri" value="{{ old('entreprise') }}" id="createE">

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
                                    @if($entreprise->entreprise==$vehicule[0]->entreprise)
                                    <option value="{{$entreprise->entreprise}}">{{$entreprise->entreprise}}</option selected>
                                    @endif
                                    @endforeach
                                    @foreach($entreprises as $entreprise)
                                    @if($entreprise->entreprise!=$vehicule[0]->entreprise)
                                    <option value="{{$entreprise->entreprise}}">{{$entreprise->entreprise}}</option>
                                    @endif
                                    @endforeach
                                </select>
                        </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Mot de passe') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Ajouter') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script type="text/javascript">
        var e=document.querySelector('#entreprise')
        e.addEventListener('change',function(){
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
        })
    </script>

@endsection
