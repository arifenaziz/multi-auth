@php
     $usr = Auth::guard('admin')->user();
 @endphp

<aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->

                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">Medical Health Check</li>
                        <li> 
                            <a class="waves-effect waves-dark" href="{{ url('admin/home') }}" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard</span></a>
                        </li>

                        @if ($usr->can('category.view') || $usr->can('subcategory.view'))                        
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-creation"></i><span class="hide-menu">Lookup</span></a>
                            <ul aria-expanded="false" class="collapse">
                                @if ($usr->can('category.view'))
                                <li><a href="{{ url('admin/category') }}">Category</a></li>                                
                                @endif
                                @if ($usr->can('subcategory.view'))
                                <li><a href="{{ url('admin/subcategory') }}">Sub Category</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif

                        @if ($usr->can('admin.view') || $usr->can('role.view'))
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-creation"></i><span class="hide-menu">Permission</span></a>
                            <ul aria-expanded="false" class="collapse">
                                @if ($usr->can('role.view'))
                               <li><a href="{{ url('admin/roles') }}">Roles and Permission</a></li>  
                                @endif                 
                                @if ($usr->can('admin.view'))             
                                <li><a href="{{ url('admin/adminList') }}">Admin Role Assign</a></li>
                                @endif
                            </ul>
                        </li> 
                        @endif                   
                        
                        <li> 
                            <a class="waves-effect waves-dark" href="{{ url('/test') }}" aria-expanded="false"><i class="mdi mdi-calendar-clock"></i><span class="hide-menu">Test</span></a>
                        </li>                        
                                                
                    
                        <li></li>


                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>