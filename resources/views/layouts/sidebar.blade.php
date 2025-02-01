

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

          <div data-simplebar class="h-100">

            <!--- Sidemenu -->
            <div id="sidebar-menu">
              <!-- Left Menu Start -->
              <ul class="metismenu list-unstyled" id="side-menu">

                      <li class="">
                        <a href="{{ route('home') }}" class="waves-effect item">
                            <i class="dripicons-device-desktop"></i>
                            <span>tableau de bord</span>
                        </a>
                      </li>

                      @canany( ['produit-list', 'categorie-list',"stock-list"])
                        <li>
                          <a href="javascript: void(0);" class="has-arrow waves-effect item">
                            <i class="dripicons-device-desktop"></i>
                            <span>catalogue</span>
                          </a>
                          <ul class="sub-menu" aria-expanded="true">
                            @can('categorie-list')
                            <li class="item-link {{ Route::currentRouteName() === 'categorie.edit' ||
                            Route::currentRouteName() === 'categorie.show' ||
                            Route::currentRouteName() === 'categorie.create' ||
                            Route::currentRouteName() === 'categorie.index'
                            ? 'mm-active':'' }}">
                              <a href="{{ route('categorie.index') }}" class="item-link">catégories</a>
                            </li>
                            @endcan
                            @can('produit-list')
                            <li class="item-link {{ Route::currentRouteName() === 'produit.edit' ||
                              Route::currentRouteName() === 'produit.show' ||
                              Route::currentRouteName() === 'produit.create' ||
                              Route::currentRouteName() === 'produit.index'
                              ? 'mm-active':'' }}">
                                <a href="{{ route('produit.index') }}" class="item-link">produits</a>
                            </li>
                            @endcan
                            @can('stock-list')
                              <li class="{{ Route::currentRouteName() === 'stock.edit' ||
                              Route::currentRouteName() === 'stock.show' ||
                              Route::currentRouteName() === 'stock.create' ||
                              Route::currentRouteName() === 'stock.index'
                              ? 'mm-active':'' }}">
                                <a href="{{ route('stock.index') }}" class="item-link">stock</a>
                              </li>
                            @endcan
                            @can('stock-list')
                              <li class="{{ Route::currentRouteName() === 'stockDepot.edit' ||
                              Route::currentRouteName() === 'stockDepot.show' ||
                              Route::currentRouteName() === 'stockDepot.index'
                              ? 'mm-active':'' }}">
                                <a href="{{ route('stockDepot.index') }}" class="item-link">depot</a>
                              </li>
                            @endcan
                          </ul>
                        </li>
                      @endcanany



                        @canany( ['client-list', 'fournisseur-list'])
                          <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect item">
                                  <i class="dripicons-device-desktop"></i>
                                  <span>crm</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                @can('fournisseur-list')
                                  <li  class="{{ Route::currentRouteName() === 'fournisseur.index' ||
                                  Route::currentRouteName() === 'fournisseur.show' ||
                                  Route::currentRouteName() === 'fournisseur.edit'
                                  ? 'mm-active':'' }}">
                                    <a href="{{ route('fournisseur.index') }}" class="item-link">fournisseurs</a>
                                  </li>
                                @endcan
                                @can('client-list')
                                  <li  class="{{ Route::currentRouteName() === 'client.index' ||
                                  Route::currentRouteName() === 'client.show' ||
                                  Route::currentRouteName() === 'client.edit'
                                  ? 'mm-active':'' }}">
                                    <a href="{{ route('client.index') }}" class="item-link">clients</a>
                                  </li>
                                @endcan
                            </ul>
                          </li>
                        @endcanany

                        @can('ligneAchat-list')
                        <li>
                              <a href="{{ route('ligneAchat.index') }}" class=" waves-effect">
                                <i class="dripicons-device-desktop"></i>
                                <span>achats</span>
                              </a>
                            </li>
                        @endcan
                        @can('ligneVente-list')
                        <li>
                              <a href="{{ route('ligneAchat.index') }}" class=" waves-effect">
                                <i class="dripicons-device-desktop"></i>
                                <span>ventes</span>
                              </a>
                            </li>
                        @endcan

                        @canany( ['user-list', 'role-list'])
                        <li>
                          <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="dripicons-device-desktop"></i>
                                <span>grh</span>
                          </a>
                          <ul class="sub-menu" aria-expanded="true">
                              @can('role-list')
                                <li><a href="{{ route('role.index') }}">roles</a></li>
                              @endcan
                              @can('user-list')
                                <li><a href="{{ route('user.index') }}">users</a></li>
                              @endcan
                          </ul>
                        </li>
                        @endcanany

                        @canany( ['achatPaiement-list', 'ventePaiement-list'])
                        <li>
                          <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="dripicons-device-desktop"></i>
                                <span>paiements</span>
                          </a>
                          <ul class="sub-menu" aria-expanded="true">
                              @can('achatPaiement-list')
                                <li><a href="{{ route('achatPaiement.index') }}">achats</a></li>
                              @endcan
                              @can('ventePaiement-list')
                                <li><a href="{{ route('ventePaiement.index') }}">ventes</a></li>
                              @endcan
                          </ul>
                        </li>
                        @endcanany

                            <li>
                              <a href="{{ route('document.index') }}" class=" waves-effect item">
                                  <i class="dripicons-device-desktop"></i>
                                  <span>documents</span>
                              </a>
                            </li>
                            <li>
                              <a href="{{ route('export.index') }}" class=" waves-effect item">
                                  <i class="dripicons-device-desktop"></i>
                                  <span>exports</span>
                              </a>
                            </li>

                            <li>
                              <a href="{{ route('rapportAchat.index') }}" class=" waves-effect">
                                  <i class="dripicons-device-desktop"></i>
                                  <span>rapports</span>
                              </a>
                            </li>


                            @canany( ['ventePaiement-list', 'achatPaiement-list'])
                              <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect item">
                                      <i class="dripicons-device-desktop"></i>
                                      <span>paramètres</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                    @can('tauxTva-list')
                                      <li class="{{ Route::currentRouteName() === 'tauxTva.edit' ||
                                        Route::currentRouteName() === 'tauxTva.show' ||
                                        Route::currentRouteName() === 'tauxTva.create' ||
                                        Route::currentRouteName() === 'tauxTva.index' ? 'mm-active':''
                                        }}">
                                        <a href="{{ route('tauxTva.index') }}" class="item-link">
                                          tva
                                        </a>
                                      </li>
                                    @endcan

                                    @can('depot-list')
                                      <li class="{{ Route::currentRouteName() === 'depot.edit' ||
                                        Route::currentRouteName() === 'depot.show' ||
                                        Route::currentRouteName() === 'depot.create' ||
                                        Route::currentRouteName() === 'depot.index' ? 'mm-active':''
                                        }}">
                                        <a href="{{ route('depot.index') }}" class="item-link">
                                          depôts
                                        </a>
                                      </li>
                                    @endcan
                                </ul>
                              </li>
                            @endcanany

              </ul>
          </div>
          <!-- Sidebar -->
      </div>
  </div>