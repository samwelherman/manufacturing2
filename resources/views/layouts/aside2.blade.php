<!-- Main sidebar -->
<div class="sidebar sidebar-light sidebar-main sidebar-expand-lg">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <?php
        $settings = App\Models\System::where('added_by', auth()->user()->added_by)->first();
        
        ?>
        <style>
            .sibebarEma {
                background: url({{ url('public/assets/img/logo') }}/{{ $settings->picture }}) center center no-repeat;
                background-size: cover;
            }
        </style>
        <!-- User menu -->
        <div class="sidebar-section">
            <div class="sibebarEma">
                <div class="sidebar-section-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <button type="button"
                                class="btn btn-outline-dark border-transparent btn-icon btn-sm rounded-pill">
                                <i class="icon-wrench"></i>
                            </button>
                        </div>
                        <a href="#" class="flex-1 text-center"></a>
                        <div class="flex-1 text-right">
                            <button type="button"
                                class="btn btn-outline-dark border-transparent btn-icon rounded-pill btn-sm sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                                <i class="icon-transmission"></i>
                            </button>

                            <button type="button"
                                class="btn btn-outline-dark border-transparent btn-icon rounded-pill btn-sm sidebar-mobile-main-toggle d-lg-none">
                                <i class="icon-cross2"></i>
                            </button>
                        </div>
                    </div>

                </div>

                <div class="sidebar-user-material-footer">
                    <a href="#user-nav" class="d-flex justify-content-between align-items-center  dropdown-toggle"
                        data-toggle="collapse"></a>
                </div>

            </div>


        </div>
        <!-- /user menu -->


        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->
                <li class="nav-item-header">
                    <div class="text-uppercase font-size-xs line-height-xs mt-1">Main</div> <i class="icon-menu"
                        title="Main"></i>
                </li>

                <li class="nav-item">
                    <a href="{{ url('home') }}" class="nav-link  {{ request()->is('home') ? 'active' : '' }}">
                        <i class="icon-home4"></i>
                        <span>
                            Dashboard
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('manufacturing/manufacturing_location*') ? 'active' : '' }}"
                     href="{{ url('manufacturing/manufacturing_location') }}">
                    <i class="icon-store"></i><span>Stores</span>
                    </a>
                </li>



                @can('view-store-purchase')
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-copy"></i>Purchases</a>
                        <ul class="nav nav-group-sub">
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->is('store/purchases/store_items*') ? 'active' : '' }}"
                                    href="{{ url('store/purchases/store_items') }}"><i></i></i>Raw Materials</a>
                            </li>
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->is('store/purchases/store_pos_supplier*') ? 'active' : '' }}"
                                    href="{{ url('store/purchases/store_pos_supplier') }}"><i></i></i>Manage
                                    Suppliers</a></li>
                            @can('view-pos')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('store/purchases/store_purchase*') ? 'active' : '' }}"
                                        href="{{ url('store/purchases/store_purchase') }}"><i></i></i>Manage
                                        Purchases</a></li>
                            @endcan
                            <!-- <li class="nav-item"><a
                                    class="nav-link {{ request()->is('store/purchases/creditors_report*') ? 'active' : '' }}"
                                    href="{{ url('store/purchases/creditors_report') }}"><i></i></i>Creditors
                                    Report</a></li>

                            <li class="nav-item"><a
                                    class="nav-link {{ request()->is('store/purchases/store_debit_note*') ? 'active' : '' }}"
                                    href="{{ url('store/purchases/store_debit_note') }}"><i></i></i>Debit
                                    Note</a></li>
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->is('store/purchases/store_pos_issue*') ? 'active' : '' }}"
                                    href="{{ url('store/purchases/store_pos_issue') }}"><i></i></i>Good Issue</a>
                            </li> */
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->is('store/pos_activity*') ? 'active' : '' }}"
                                    href="{{ url('store/pos_activity') }}"><i></i></i>Track POS Activity</a></li> -->

                            <!-- <li class="nav-item"><a class="nav-link {{ request()->is('store/purchases/payments*') ? 'active' : '' }}"
                                            href="{{ url('store/purchases/payments') }}"><i></i></i>Manage Payments</a></li> -->
                        </ul>
                    </li>
                @endcan

                @can('view-store-sales')
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-copy"></i>Sales</a>
                        <ul class="nav nav-group-sub">
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->is('store/sales/store_pos_client*') ? 'active' : '' }}"
                                    href="{{ url('store/sales/store_pos_client') }}"><i></i></i>Clients List</a>
                            </li>
                            @can('view-pos')
                                <!--<li class="nav-item"><a class="nav-link {{ request()->is('store/sales/profoma_invoice*') ? 'active' : '' }}"
                                                                href="{{ url('store/sales/profoma_invoice') }}"><i></i></i>Profoma Invoice</a></li>-->
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('store/sales/store_invoice*') ? 'active' : '' }}"
                                        href="{{ url('store/sales/store_invoice') }}"><i></i></i>Invoices</a></li>
                            @endcan
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->is('store/sales/debtors_report*') ? 'active' : '' }}"
                                    href="{{ url('store/sales/debtors_report') }}"><i></i></i>Debtors Report</a>
                            </li>
                            <!-- <li class="nav-item"><a class="nav-link {{ request()->is('store/sales/credit_note*') ? 'active' : '' }}"
                                            href="{{ url('store/sales/credit_note') }}"><i></i></i>Credit Note</a></li>-->

                            <!-- <li class="nav-item"><a class="nav-link {{ request()->is('store/sales/payments*') ? 'active' : '' }}"
                                            href="{{ url('store/purchases/payments') }}"><i></i></i>Manage Payments</a></li> -->
                        </ul>
                    </li>
                @endcan









                @can('manage-manufacture')
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-copy"></i> <span>
                                Manufacturing</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                            @can('view-manufacture')
                              
                            @endcan
                              @can('view-manufacture')
                                                      <li class="nav-item"><a
                                                                        class="nav-link {{ request()->is('manufacturing/manufacturing_inventory*') ? 'active' : '' }}"
                                                                        href="{{ url('manufacturing/product_items') }}">Product Produced
                                                                        </a></li>
                             @endcan
                             <!--
                                            @can('view-manufacture')
        <li class="nav-item"><a
                                                                        class="nav-link {{ request()->is('inventory/fieldstaff*') ? 'active' : '' }}"
                                                                        href="{{ url('inventory/fieldstaff') }}">Field Staff</a></li> -->
                            @endcan
                            @can('view-manufacture')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('manufacturing/bill_of_material*') ? 'active' : '' }}"
                                        href="{{ url('manufacturing/bill_of_material') }}">Bill Of Material</a>
                                </li>
                            @endcan
                            @can('view-manufacture')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('manufacturing/work_order*') ? 'active' : '' }}"
                                        href="{{ url('manufacturing/work_order') }}">Production  Order</a></li>
                            @endcan

                           
                        <!--

                            @can('view-manufacture')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('inventory/good_issue*') ? 'active' : '' }}"
                                        href="{{ url('inventory/good_issue') }}">Good Issue</a></li>
                            @endcan
                            @can('view-manufacture2')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('inventory/good_return*') ? 'active' : '' }}"
                                        href="{{ url('inventory/good_return') }}">Good Return</a></li>
                            @endcan
                            @can('view-manufacture')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('inventory/good_movement*') ? 'active' : '' }}"
                                        href="{{ url('inventory/good_movement') }}">Good Movement</a></li>
                            @endcan
                            @can('view-manufacture')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('inventory/good_reallocation*') ? 'active' : '' }}"
                                        href="{{ url('inventory/good_reallocation') }}">Good
                                        Reallocation</a></li>
                            @endcan -->

                        </ul>
                    </li>
                @endcan

                @can('manage-report')
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-grid6"></i> <span>Reports</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Sidebars">
                            @can('view-inventory-report')
                                <li class="nav-item nav-item-submenu">
                                    <a href="#"
                                        class="nav-link {{ request()->is('reports/inventory_report*') ? 'active' : '' }}">Inventory
                                        Report</a>
                                    <ul class="nav nav-group-sub">
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/inventory_report/purchase_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/inventory_report/purchase_report') }}"><i></i></i>Inventory
                                                Purchase Report</a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/inventory_report/good_issue_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/inventory_report/good_issue_report') }}"><i></i></i>Inventory
                                                Issued Report</a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/inventory_report/sales_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/inventory_report/sales_report') }}"><i></i></i>Inventory
                                                Sales Report</a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/inventory_report/balance_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/inventory_report/balance_report') }}"><i></i></i>Inventory
                                                Balance Report</a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/inventory_report/stock_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/inventory_report/stock_report') }}"><i></i></i>Stock
                                                Value </a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/inventory_report/report_by_date*') ? 'active' : '' }}"
                                                href="{{ url('reports/inventory_report/report_by_date') }}"><i></i></i>Report
                                                By Date </a>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/inventory_report/profit_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/inventory_report/profit_report') }}"><i></i></i>Profit
                                                Report </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan

                          

                          


                          

                           

                            @can('view-store-report1')
                                <li class="nav-item nav-item-submenu">
                                    <a href="#"
                                        class="nav-link {{ request()->is('reports/store*') ? 'active' : '' }}">Store
                                        Report</a>
                                    <ul class="nav nav-group-sub">
                                        <!--<li class="nav-item"><a class="nav-link {{ request()->is('reports/store/purchase_report*') ? 'active' : '' }}"  href="{{ url('reports/store/purchase_report') }}"><i></i></i>Inventory Purchase Report</a></li>-->
                                        <!--  <li class="nav-item"><a class="nav-link {{ request()->is('reports/store/sales_report*') ? 'active' : '' }}" href="{{ url('reports/store/sales_report') }}"><i></i></i>Inventory Sales Report</a></li> -->
                                        <!--  <li class="nav-item"><a class="nav-link {{ request()->is('reports/store/balance_report*') ? 'active' : '' }}"  href="{{ url('reports/store/balance_report') }}"><i></i></i>Inventory Balance Report</a></li>-->
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/store/crate_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/store/crate_report') }}"><i></i></i>Inventory Crate
                                                Report</a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/store/crate_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/store/bottle_report') }}"><i></i></i>Inventory Bottle
                                                Report</a></li>
                                    </ul>
                                </li>
                            @endcan

                           

                        
                </ul>
                </li>
            @endcan


            <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link"><i class="icon-cog7"></i> <span>
                        {{ __('permission.access_control') }}</span></a>

                <ul class="nav nav-group-sub" data-submenu-title="Layouts">

                    <li class=" nav-item"><a
                            class="nav-link {{ request()->is('access_control/roleGroup*') ? 'active' : '' }}"
                            href="{{ url('access_control/roles') }}">
                            {{ __('permission.roles') }}</a>
                    </li>

                    @can('view-permission')
                        <li class=" nav-item "><a
                                class="nav-link {{ request()->is('access_control/roleGroup*') ? 'active' : '' }}"
                                href="{{ url('access_control/permissions') }}">{{ __('permission.permissions') }}</a>

                        </li>
                    @endcan
                    @can('view-user')
                        <li class="nav-item"><a
                                class="nav-link {{ request()->is('access_control/system*') ? 'active' : '' }}"
                                href="{{ url('access_control/system') }}">{{ __('permission.system_setings') }}</a>

                        </li>
                    @endcan

                    @can('view-user')
                        <li class="nav-item"><a
                                class="nav-link {{ request()->is('access_control/departments*') ? 'active' : '' }}"
                                href="{{ url('access_control/departments') }}">Departments
                            </a></li>
                    @endcan

                    @can('view-user')
                        <li class="nav-item"><a
                                class="nav-link {{ request()->is('access_control/designations*') ? 'active' : '' }}"
                                href="{{ url('access_control/designations') }}">Designations
                            </a></li>
                    @endcan

                    @can('view-user')
                        <li class=" nav-item "><a
                                class="nav-link {{ request()->is('access_control/users*') ? 'active' : '' }}"
                                href="{{ url('access_control/users') }}">{{ __('permission.user') }}
                                Management</a></li>
                    @endcan

                    @can('view-user-all')
                        <li class=" nav-item "><a
                                class="nav-link {{ request()->is('access_control/users*') ? 'active' : '' }}"
                                href="{{ url('access_control/users_all') }}">View All Users Details</a></li>
                    @endcan

                    @can('view-user-all')
                        <li class=" nav-item "><a
                                class="nav-link {{ request()->is('access_control/users*') ? 'active' : '' }}"
                                href="{{ url('access_control/affiliate_users_all') }}">View All Affiliate Users</a></li>
                    @endcan

                  


                </ul>
            </li>
            

            <!-- /page kits -->



            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->
