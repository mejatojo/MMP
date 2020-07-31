<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->
    </ul>

    <!-- SEARCH FORM -->
    <!-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              {{ Auth::user()->name }} <span class="caret"></span>
          </a>

          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{ route('logout') }}"
                         onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                      {{ __('Se déconnecter') }}
                                    </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
            </form>
            <a type="button" class="dropdown-item" data-toggle="modal" data-target="#mdp">
                  Changer le mot de passe
                </a>
                
          </div>

      </li>
      <!-- Notifications Dropdown Menu -->
      
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
   

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          @if(Auth::user()->logo!='')
          <img src="{{asset('storage/'.Auth::user()->logo)}}" class="img-circle elevation-2" alt="User Image">
          @else
          <img src="{{asset('images/logo.jpg')}}" class="img-circle elevation-2" alt="User Image">
          @endif
        </div>
        <div class="info">
          <a href="#" class="d-block">
            {{ Auth::user()->name }}
            <br>({{ Auth::user()->role }})
          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               @if(Auth::user()->role=='responsable' or Auth::user()->role=='PDG')
            <li class="nav-item">
              <a href="/home" class="nav-link">
                <i class="far  fa-handshake"></i>
                <p>Flotte de {{Auth::user()->entreprise}}</p>
              </a>
          </li>
              @endif
               @if(Auth::user()->role=='responsable' or Auth::user()->role=='PDG' or Auth::user()->role=='conducteur')
            <li class="nav-item">
              <a href="/vehicules" class="nav-link">
                <i class="nav-icon fa fa-car"></i>
                <p>Véhicules</p>
              </a>
          </li>
              @endif
          @if(Auth::user()->role=='superadmin')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-car"></i>
              <p>
                Véhicules
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(Auth::user()->role=='conducteur' or Auth::user()->role=='responsable' or Auth::user()->role=='PDG')
              <li class="nav-item">
                <a href="/vehicules" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Véhicules de {{Auth::user()->entreprise}}</p>
                </a>
              </li>
              @elseif(Auth::user()->role=='superadmin')
              <li class="nav-item">
                <a href="/vehicules/create" class="nav-link">
                  <i class="fa fa-plus"></i>
                  <p>Ajouter</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/vehicules" class="nav-link">
                  <i class="fa fa-list"></i>
                  <p>Liste</p>
                </a>
              </li>
              @endif
            </ul>
          </li>
          @endif
          @if(Auth::user()->role=='superadmin')
          <li class="nav-item">
                <a href="/rendezVous" class="nav-link">
                  <i class="fas fa-handshake"></i>
                  <p>Rendez-vous
                    @if(isset($nbRdv))
                      ({{$nbRdv}})
                    @endif
                  </p>
                </a>
              </li>
          @elseif(Auth::user()->role=='conducteur' or Auth::user()->role=='responsable' or Auth::user()->role=='PDG')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-handshake"></i>
              <p>
                Rendez-vous 
                @if(Auth::user()->role=='superadmin')
                @if(isset($nbRdv))
                  ({{$nbRdv}})
                @endif
                @endif
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(Auth::user()->role=='responsable' or Auth::user()->role=='conducteur' or Auth::user()->role=='PDG')
              <li class="nav-item">
                <a href="/rendezVous/create" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ajouter</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/rendezVous/liste/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Liste</p>
                </a>
              </li>
              @endif
              @if(Auth::user()->role=='superadmin')
              <li class="nav-item">
                <a href="/rendezVous" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Demandes</p>
                </a>
              </li>
              @endif
            </ul>
          </li>
          @endif
              @if(Auth::user()->role=='operateur' or Auth::user()->role=='superadmin')
              <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-tools"></i>
              <p>
                Interventions
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/maintenances" class="nav-link">
                  <i class="nav-icon far fa-circle text-danger"></i>
                  <p>Rendez-vous d'aujourd'hui</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/maintenancesRapides" class="nav-link">
                  <i class="nav-icon far fa-circle text-warning"></i>
                  <p>Intervention rapide</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/historiques" class="nav-link">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Historique</p>
                </a>
              </li>
            </ul>
          </li>
              @endif
              @if(Auth::user()->role=='superadmin' or Auth::user()->role=='PDG' or Auth::user()->role=='responsable')
              <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-table"></i>
              <p>
                Statistiques
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <!-- <li class="nav-item">
                <a href="/utiliser" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pneus utilisés</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/couts" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gestion des coûts</p>
                </a>
              </li>  -->
              <li class="nav-item">
                <a href="/possession" class="nav-link">
                  <i class="fa fa-euro-sign nav-icon"></i>
                  <p>Gestion de coûts</p>
                </a>
              </li> 
              <li class="nav-item">
                <a href="/pneuUse" class="nav-link">
                  <i class="fa fa-times-circle nav-icon"></i>
                  <p>Pneus usés</p>
                </a>
              </li> 
            </ul>
          </li>
          <li class="nav-item">
                <a href="/entreprises" class="nav-link">
                  <i class="fa fa-building"></i>
                  <p>Entreprises</p>
                </a>
              </li>
          @endif
          @if(Auth::user()->role=='superadmin')
              <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-user"></i>
              <p>
                Utilisateurs
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/utilisateurs/create" class="nav-link">
                  <i class="fa fa-user-plus nav-icon"></i>
                  <p>Ajouter</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/utilisateurs" class="nav-link">
                  <i class="fa fa-users nav-icon"></i>
                  <p>Liste</p>
                </a>
              </li>
            </ul>
          </li>
          
              <li class="nav-item">
                <a href="/stocks" class="nav-link">
                  <i class="fa fa-archive"></i>
                  <p>Stocks</p>
                </a>
              </li>
           <li class="nav-item">
                <a href="/sauvegarde" class="nav-link">
                  <i class="fa fa-database"></i>
                  <p>Sauvegarder/Restaurer</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="/story" class="nav-link">
                  <i class="fa fa-history"></i>
                  <p>Historiques des alertes</p>
                </a>
              </li> 
          @endif
           @if(Auth::user()->role=='superadmin' or Auth::user()->role=='responsable' or Auth::user()->role=='conducteur' or Auth::user()->role=='PDG')
               <li class="nav-item">
                <a href="/prediction" class="nav-link">
                  <i class="fa fa-arrow-alt-circle-right"></i>
                  <p>Prédiction</p>
                </a>
              </li>
              @endif
            </ul>
          
          
          
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
