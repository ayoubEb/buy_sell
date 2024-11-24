

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

          <div data-simplebar class="h-100">

            <!--- Sidemenu -->
            <div id="sidebar-menu">
              <!-- Left Menu Start -->
              <ul class="metismenu list-unstyled" id="side-menu">

                      <li>
                        <a href="{{ route('home') }}" class=" waves-effect">
                            <i class="dripicons-device-desktop"></i>
                            <span>tableau de bord</span>
                        </a>
                      </li>

                      @canany( ['produit-list', 'categorie-list',"stock-list"])
                        <li>
                          <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="dripicons-device-desktop"></i>
                            <span>catalogue</span>
                          </a>
                          <ul class="sub-menu" aria-expanded="true">
                            @can('produit-list')
                              <li><a href="{{ route('produit.index') }}">produits</a></li>
                            @endcan
                            @can('categorie-list')
                              <li><a href="{{ route('categorie.index') }}">catégories</a></li>
                            @endcan
                            @can('stock-list')
                              <li><a href="{{ route('stock.index') }}">stock</a></li>
                            @endcan
                          </ul>
                        </li>
                      @endcanany



                        @canany( ['client-list', 'fournisseur-list'])
                        <li>
                          <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="dripicons-device-desktop"></i>
                                <span>crm</span>
                          </a>
                          <ul class="sub-menu" aria-expanded="true">
                              @can('fournisseur-list')
                                <li><a href="{{ route('fournisseur.index') }}">fournisseurs</a></li>
                              @endcan
                              @can('client-list')
                                <li><a href="{{ route('client.index') }}">clients</a></li>
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
                              <a href="{{ route('ligneVente.index') }}" class=" waves-effect">
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

                        @can('categorieDepense-list')
                          <li>
                            <a href="{{ route('categorieDepense.index') }}" class=" waves-effect">
                                <i class="dripicons-device-desktop"></i>
                                <span>catégorie dépense</span>
                            </a>
                          </li>
                        @endcan

                        @can('depense-list')
                          <li>
                            <a href="{{ route('depense.index') }}" class=" waves-effect">
                                <i class="dripicons-device-desktop"></i>
                                <span>dépense</span>
                            </a>
                          </li>
                        @endcan

                            <li>
                              <a href="{{ route('rapportAchat.index') }}" class=" waves-effect">
                                  <i class="dripicons-device-desktop"></i>
                                  <span>rapports</span>
                              </a>
                            </li>

                            @canany( ['ventePaiement-list', 'achatPaiement-list'])
                              <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                      <i class="dripicons-device-desktop"></i>
                                      <span>caisses</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                    @can('ventePaiement-list')
                                      <li><a href="{{ route('categorieCaisse.index') }}">catégorie caisse</a></li>
                                    @endcan
                                    @can('achatPaiement-list')
                                      <li><a href="{{ route('caisse.index') }}">caisse</a></li>
                                    @endcan
                                </ul>
                              </li>
                            @endcanany

                            @canany( ['ventePaiement-list', 'achatPaiement-list'])
                              <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                      <i class="dripicons-device-desktop"></i>
                                      <span>paramètres</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                    @can('ventePaiement-list')
                                      <li><a href="{{ route('tauxTva.index') }}">tva</a></li>
                                    @endcan
                                    @can('achatPaiement-list')
                                      <li><a href="{{ route('marque.index') }}">marques</a></li>
                                    @endcan
                                </ul>
                              </li>
                            @endcanany

              </ul>
          </div>
          <!-- Sidebar -->
      </div>
  </div>