@extends('backend.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(Auth::user()->role == 1 )
                    <div class="row">
                        <div class="col-lg-3 col-6">
                        
                        <div class="small-box bg-info">
                        <div class="inner">
                        <h3>{{ $productsCount }}</h3>
                        <p>Products in Warehouse</p>
                        </div>
                        <div class="icon">
                        <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{URL::to('/list_product')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                        </div>
                        
                        <div class="col-lg-3 col-6">
                        
                        <div class="small-box bg-success">
                        <div class="inner">
                        <h3>{{  $ordersCount }}</h3>
                        <p>Product Ordered</p>
                        </div>
                        <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                        </div>
                        
                        <div class="col-lg-3 col-6">
                        
                        <div class="small-box bg-warning">
                        <div class="inner">
                        <h3>{{  $usersCount }}</h3>
                        <p>User Registered</p>
                        </div>
                        <div class="icon">
                        <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{URL::to('/user_list')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                        </div>
                        
                        <div class="col-lg-3 col-6">
                        
                        <div class="small-box bg-danger">
                        <div class="inner">
                        <h3>65</h3>
                        <p>Unique Visitors</p>
                        </div>
                        <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                        </div>
                        
                        </div>

                        @endif

                        @if(Auth::user()->role == 2 )
                        <div class="row">
                            <div class="col-lg-3 col-6">
                            
                            <div class="small-box bg-info">
                            <div class="inner">
                            <h3>150</h3>
                            <p>New Orders</p>
                            </div>
                            <div class="icon">
                            <i class="ion ion-bag"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                            </div>
                            
                            <div class="col-lg-3 col-6">
                            
                            <div class="small-box bg-success">
                            <div class="inner">
                            <h3>53<sup style="font-size: 20px">%</sup></h3>
                            <p>Bounce Rate</p>
                            </div>
                            <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                            </div>
                            
                            <div class="col-lg-3 col-6">
                            
                            <div class="small-box bg-warning">
                            <div class="inner">
                            <h3>44</h3>
                            <p>User Registrations</p>
                            </div>
                            <div class="icon">
                            <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                            </div>
                            
                            <div class="col-lg-3 col-6">
                            
                            <div class="small-box bg-danger">
                            <div class="inner">
                            <h3>65</h3>
                            <p>Unique Visitors</p>
                            </div>
                            <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                            </div>
                            
                            </div>
                        @endif

                        @if(Auth::user()->role == 3 )
                        <div class="row">
                            <div class="col-lg-3 col-6">
                            
                            <div class="small-box bg-info">
                            <div class="inner">
                            <h3>150</h3>
                            <p>New Orders</p>
                            </div>
                            <div class="icon">
                            <i class="ion ion-bag"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                            </div>
                            
                            <div class="col-lg-3 col-6">
                            
                            <div class="small-box bg-success">
                            <div class="inner">
                            <h3>53<sup style="font-size: 20px">%</sup></h3>
                            <p>Bounce Rate</p>
                            </div>
                            <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                            </div>
                            
                            <div class="col-lg-3 col-6">
                            
                            <div class="small-box bg-warning">
                            <div class="inner">
                            <h3>44</h3>
                            <p>User Registrations</p>
                            </div>
                            <div class="icon">
                            <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                            </div>
                            
                            <div class="col-lg-3 col-6">
                            
                            <div class="small-box bg-danger">
                            <div class="inner">
                            <h3>65</h3>
                            <p>Unique Visitors</p>
                            </div>
                            <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                            </div>
                            
                            </div>
                        @endif
                   <b> {{ Auth::user()->name }} </b>  {{ __('You are logged in!') }}

                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
