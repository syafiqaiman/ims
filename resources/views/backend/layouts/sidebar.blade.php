<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{URL::to('/home')}}" class="brand-link">
      <img src="{{('backend/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      @if(Auth::user()->role == 1 )
      <span class="brand-text font-weight-light">Admin Panel</span>
      @endif
      @if(Auth::user()->role == 2 )
      <span class="brand-text font-weight-light">Picker Panel</span>
      @endif
      @if(Auth::user()->role == 3 )
      <span class="brand-text font-weight-light">Customer Panel</span>
      @endif

    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{('backend/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{URL::to('/home')}}" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Starter Pages
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Active Page</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inactive Page</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Simple Link
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>


@if (Auth::user()->role == 1 )
<li class="nav-item">
  <a href="{{URL::to('/check_new_product')}}" class="nav-link">
    <i class="nav-icon fas fa-th"></i>
    <p>
      New Product Request
      <!-- <span class="right badge badge-danger">New</span> -->
    </p>
  </a>
</li>

<li class="nav-item">
  <a href="{{URL::to('/review_request')}}" class="nav-link">
    <i class="nav-icon fas fa-th"></i>
    <p>
      Restock Request
      <!-- <span class="right badge badge-danger">New</span> -->
    </p>
  </a>
</li>

          <li class="nav-item">
            <a href="{{URL::to('/add_product')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Add Product
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{URL::to('/cart_index')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Assign Product
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="{{URL::to('/picker_status')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Picker Status
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{URL::to('/quantity_list')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Product Stock Level
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{URL::to('/list_product')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Product List
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{URL::to('/racks')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Rack List
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{URL::to('/floors')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Floor List
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{URL::to('/company_list')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Company List
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{URL::to('/user_list')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                User List
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{URL::to('/admin/weekly-report')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Weekly Report
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>
        
@endif


@if (Auth::user()->role == 2 )


          <li class="nav-item">
            <a href="{{URL::to('/picker_task')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Picker Task
                {{-- <span class="right badge badge-danger">0</span> --}}
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{URL::to('/picker/history')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                History
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{URL::to('/quantity_list')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Product Stock Level
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>

@endif



@if (Auth::user()->role == 3 )
<li class="nav-item">
  <a href="{{URL::to('/customer_add_product')}}" class="nav-link">
    <i class="nav-icon fas fa-th"></i>
    <p>
      Add New Product
      <!-- <span class="right badge badge-danger">New</span> -->
    </p>
  </a>
</li>
<li class="nav-item">
  <a href="{{URL::to('/request_restock_status')}}" class="nav-link">
    <i class="nav-icon fas fa-th"></i>
    <p>
      Product Restock Status
      {{-- oonly display existing item --}}
      <!-- <span class="right badge badge-danger">New</span> -->
    </p>
  </a>
</li>
<li class="nav-item">
  <a href="{{URL::to('/my_stock_level')}}" class="nav-link">
    <i class="nav-icon fas fa-th"></i>
    <p>
      Stock Level
      <!-- <span class="right badge badge-danger">New</span> -->
    </p>
  </a>
</li>
<li class="nav-item">
  <a href="{{URL::to('/add_company')}}" class="nav-link">
    <i class="nav-icon fas fa-th"></i>
    <p>
      Product Pick Up (future feature)
      <!-- <span class="right badge badge-danger">New</span> -->
    </p>
  </a>
</li>
<li class="nav-item">
  <a href="{{URL::to('/delivery/delivery_form')}}" class="nav-link">
    <i class="nav-icon fas fa-th"></i>
    <p>
      Delivery Form (future feature)
      <!-- <span class="right badge badge-danger">New</span> -->
    </p>
  </a>
</li>
<li class="nav-item">
  <a href="{{URL::to('/add_company')}}" class="nav-link">
    <i class="nav-icon fas fa-th"></i>
    <p>
      Assign Delivery (future feature)
      <!-- <span class="right badge badge-danger">New</span> -->
      
    </p>
  </a>
</li>
<li class="nav-item">
  <a href="{{URL::to('/detail_company')}}" class="nav-link">
    <i class="nav-icon fas fa-th"></i>
    <p>
      Company Detail
      <!-- <span class="right badge badge-danger">New</span> -->
    </p>
  </a>
</li>
<li class="nav-item">
  <a href="{{URL::to('/add_company')}}" class="nav-link">
    <i class="nav-icon fas fa-th"></i>
    <p>
      Add Company
      <!-- <span class="right badge badge-danger">New</span> -->
    </p>
  </a>
</li>
<li class="nav-item">
            <a href="{{URL::to('/list_product')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Product List
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
</li>
          </li>
          
        
@endif


<li class="nav-item">
<a href="{{ route('logout') }}"
onclick="event.preventDefault();
document.getElementById('logout-form').submit();" class="nav-link">
<i class="nav-icon fas fa-th"></i>
  <p> Logout
   <!-- <span class="right badge badge-danger">New</span> -->
  </p>
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
@csrf
</form>
</li>
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>