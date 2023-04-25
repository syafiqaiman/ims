@extends('backend.layouts.app')
@section('content')

<div class="card-body">
    <div class="row">

      <div class="col-md-2">

      </div>
                     <div class="col-md-8">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Product</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{URL::to('/insert_product')}}" method="post" enctype="multipart/form-data">
              	@csrf
                <div class="card-body">


                  <div class="form-group">
                    <label for="company_id">Company Name</label>
                    <select name="company_id" class="form-control" id="company_id">
                        <option value="">Select Company Name</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                        @endforeach
                    </select>
                    @error('company_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                           

<div class="form-group">
<label for="exampleInputEmail1">Product Name</label>
<input type="text" name="product_name"  class="form-control @error('title') is-invalid @enderror"
 id="exampleInputEmail1" placeholder="Enter Product Name">

@error('title')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>

<div class="form-group">
  <label for="exampleInputEmail1">Product Description</label>
  <input type="text" name="product_desc"  class="form-control @error('title') is-invalid @enderror"
   id="exampleInputEmail1" placeholder="Enter Product Description">
  
  @error('title')
  <span class="invalid-feedback" role="alert">
  <strong>{{ $message }}</strong>
  </span>
  @enderror
  </div>



<div class="form-group">
  <label for="exampleInputEmail1">Carton Quantity</label>
  <input type="number" name="carton_quantity"  class="form-control @error('title') is-invalid @enderror"
   id="exampleInputEmail1" placeholder="Enter Quantity">
  
  @error('slug')
  <span class="invalid-feedback" role="alert">
  <strong>{{ $message }}</strong>
  </span>
  @enderror
  </div>

  <div class="form-group">
    <label for="exampleInputEmail1">Item Per Carton</label>
    <input type="number" name="item_per_carton"  class="form-control @error('title') is-invalid @enderror"
     id="exampleInputEmail1" placeholder="Enter Quantity">
    
    @error('slug')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
    @enderror
    </div>

<div class="form-group">
    <label for="exampleInputEmail1">Product Dimension</label>
    <input type="text" name="product_dimensions"  class="form-control @error('title') is-invalid @enderror"
     id="exampleInputEmail1" placeholder="Product Dimensions">
    
    @error('title')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
  <label for="exampleInputEmail1">Weight Per Item</label>
  <input type="number" name="weight_per_item"  class="form-control @error('title') is-invalid @enderror"
   id="exampleInputEmail1" placeholder="Weight Per Item">
  
  @error('title')
  <span class="invalid-feedback" role="alert">
  <strong>{{ $message }}</strong>
  </span>
  @enderror
</div>

<div class="form-group">
  <label for="exampleInputEmail1">Weight Per Carton</label>
  <input type="number" name="weight_per_carton"  class="form-control @error('title') is-invalid @enderror"
   id="exampleInputEmail1" placeholder="Weight Per Carton">
  
  @error('title')
  <span class="invalid-feedback" role="alert">
  <strong>{{ $message }}</strong>
  </span>
  @enderror
</div>

<div class="form-group">
  <label for="exampleInputEmail1">Product Image</label>
  <input type="file" name="product_image"  class="form-control @error('title') is-invalid @enderror"
   id="exampleInputEmail1" placeholder="Upload Image">
  
  @error('title')
  <span class="invalid-feedback" role="alert">
  <strong>{{ $message }}</strong>
  </span>
  @enderror
</div>

<div class="form-group">
  <label for="exampleInputEmail1">Date to be stored</label>
  <input type="date" name="date_to_be_stored"  class="form-control @error('title') is-invalid @enderror"
   id="exampleInputEmail1" placeholder="Date">
  
  @error('title')
  <span class="invalid-feedback" role="alert">
  <strong>{{ $message }}</strong>
  </span>
  @enderror
</div>


                 
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
        </div>


 <div class="col-md-2">

      </div>


            </div>
            <!-- /.row -->
        </div>

                        <script type="text/javascript">
    function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              $('#image')
                  .attr('src', e.target.result)
                  .width(80)
                  .height(80);
          };
          reader.readAsDataURL(input.files[0]);
      }
   }
</script>

@endsection