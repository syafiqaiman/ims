@extends('backend.layouts.app')

@section('content')

<div class="card-body">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Product</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{URL::to('/update_product/'.$edit->id)}}" method="post" enctype="multipart/form-data">
              	@csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="company_name">Company Name</label>
                    <select name="company_id" class="form-control @error('company_id') is-invalid @enderror" id="company_id">
                      <option value="">Select Company Name</option>
                      @foreach($companies as $company)
                          @if(auth()->user()->role == 1 || (auth()->user()->role == 3 && $company->user_id == auth()->user()->id))
                              <option value="{{ $company->id }}" {{ $edit->company_id == $company->id ? 'selected' : '' }}>{{ $company->company_name }}</option>
                          @endif
                      @endforeach
                  </select>
                    @error('company_id')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                

                  <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" name="product_name" value="{{$edit->product_name}}" class="form-control @error('product_name') is-invalid @enderror"
                     id="product_name" placeholder="Enter Product Name">
                    @error('product_name')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="product_desc">Product Price</label>
                    <textarea name="product_price" class="form-control @error('product_desc') is-invalid @enderror" id="product_price" placeholder="Product Price">{{$edit->product_price}}</textarea>
                    @error('product_desc')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
        
                  <div class="form-group">
                      <label for="product_desc">Product Description</label>
                      <textarea name="product_desc" class="form-control @error('product_desc') is-invalid @enderror" id="product_desc" placeholder="Enter Product Description">{{$edit->product_desc}}</textarea>
                      @error('product_desc')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                  </div>
         

    
                  <div class="form-group">
                    <label for="product_dimensions">Product Dimension</label>
                    <input type="text" name="product_dimensions" value="{{$edit->product_dimensions}}" class="form-control @error('product_dimensions') is-invalid @enderror"
                     id="product_dimensions" placeholder="Product Dimensions">
                    @error('product_dimensions')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
        
              
   
                  <div class="form-group">
                    <label for="weight_per_item">Weight Per Item</label>
                    <input type="number" name="weight_per_item" value="{{$edit->weight_per_item}}" class="form-control @error('weight_per_item') is-invalid @enderror"
                     id="weight_per_item" placeholder="Weight Per Item">
                    @error('weight_per_item')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
             

           
                  <div class="form-group">
                    <label for="weight_per_carton">Weight Per Carton</label>
                    <input type="number" name="weight_per_carton" value="{{$edit->weight_per_carton}}" class="form-control @error('weight_per_carton') is-invalid @enderror"
                     id="weight_per_carton" placeholder="Weight Per Carton">
                     @error('weight_per_carton')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                     </div>

                     <div class="form-group">
                      <label for="exampleInputEmail1">Date to be stored</label>
                      <input type="date" name="date_to_be_stored" value="{{ $edit->date_to_be_stored }}" class="form-control @error('title') is-invalid @enderror"
                       id="exampleInputEmail1" placeholder="Date">
                      
                      @error('title')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
 

                     <div class="form-group">
                     <label for="product_image">Product Image</label>
                     <input type="file" name="product_image" class="form-control-file @error('product_image') is-invalid @enderror" id="product_image">
                     @error('product_image')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                     <img src="{{ asset('storage/Image/'.$edit->product_image) }}" width="100">
                     </div>

                     </div>
                     <!-- /.card-body -->
                     <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Update Product</button>
                    </div>
                  </form>
                </div>
                <!-- /.card -->
        
            </div>
            <div class="col-md-2"></div>
        </div>
      </div>
      @endsection