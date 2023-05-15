@extends('backend.layouts.app')
@section('content')

       <div class="row">
<div class="col-md-12">
<div class="card card-primary">
<div class="card-header info">
<h3 class="card-title">Product List</h3>
</div>
            <!-- /.card-header -->
 <div class="card-body">
<table id="example1" class="table table-bordered table-striped">
<thead>
<tr>
<th>ID</th>
<th>Company</th>

@if (Auth::user()->role == 1 || Auth::user()->role == 2) 
<th>Rack Location</th>   
@endif

<th>Product Name & Desc</th>             
<th>Qty</th>   
<th>Product Dimensions</th>   
<th>Total Weight In Stock (kg)</th>   
<th>Product Image</th>   
<th>Date To Be Stored</th>  
@if(Auth::user()->role == 1)    
<th>Action</th>  
@endif             
</tr>
</thead>
<tbody>
@foreach($list as $row)
<tr>
<td>{{ $row->id }}</td>
<td>{{ $row->company_name }}</td>
@if (Auth::user()->role == 1 || Auth::user()->role == 2) 
<td>{{ $row->location_code }}</td>
@endif
<td>
       <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="prodDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             {{ $row->product_name }}
          </button>
          <div class="dropdown-menu" aria-labelledby="quantityDropdown">
             <a class="dropdown-item" href="#">Product Name: {{ $row->product_name }}</a>
             <a class="dropdown-item" href="#">Product Description: {{ $row->product_desc }}</a>
          </div>
       </div>
    </td>
    
<td>{{ $row->remaining_quantity }}</td>
    
<td>{{ $row->product_dimensions }}</td>
<td>

             {{ $row->weight_of_product }}

          {{-- <div class="dropdown-menu" aria-labelledby="quantityDropdown">
             <a class="dropdown-item" href="#">Weight per Carton: {{ $row->weight_per_carton }}</a>
             <a class="dropdown-item" href="#">Weight per Item: {{ $row->weight_per_item }}</a>
          </div> --}}
    </td>
    <td> 
      <img src="{{ asset('storage/Image/'.$row->product_image) }}"
           style="height: 100px; width: 150px;">
    </td>
    
<td>{{ $row->date_to_be_stored }}</td>
@if(Auth::user()->role == 1)
<td>
      
       <a href="{{ URL::to('/edit_product/'.$row->id) }}" class="btn btn-sm btn-info">Edit</a>
       <a href="{{ URL::to('delete_product/'.$row->id) }}" class="btn btn-sm btn-danger" id="delete" class="middle-align">Delete</a>
       
   </td>
   @endif
</tr>
@endforeach


        </table>
        </div>
        <!-- /.card-body -->
        </div>
        <!-- /.card -->
        </div>
        </div>

            @endsection

