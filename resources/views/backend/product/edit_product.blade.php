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
                <h3 class="card-title">Edit Product</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{URL::to('/update_product/'.$edit->id)}}" method="post" enctype="multipart/form-data">
              	@csrf
                <div class="card-body">

                  <div class="form-group">
                    <label for="exampleInputEmail1">Company Name</label>
                    <input type="text" name="company" value="{{$edit->company}}" class="form-control @error('title') is-invalid @enderror"
                     id="exampleInputEmail1" placeholder="Enter Company Name">
                    
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Product Name</label>
                    <input type="text" name="product_name" value="{{$edit->product_name}}" class="form-control @error('title') is-invalid @enderror"
                     id="exampleInputEmail1" placeholder="Enter Product Name">
                    
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Product Description</label>
                      <input type="text" name="product_desc" value="{{$edit->product_desc}}" class="form-control @error('title') is-invalid @enderror"
                       id="exampleInputEmail1" placeholder="Enter Product Description">
                      
                      @error('title')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                      </div>
                    
                    <div class="form-group">
                        <label for="exampleInputEmail1">Product Dimension</label>
                        <input type="text" name="product_dimensions" value="{{$edit->product_dimensions}}" class="form-control @error('title') is-invalid @enderror"
                         id="exampleInputEmail1" placeholder="Product Dimensions">
                        
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Weight Per Item</label>
                      <input type="number" name="weight_per_item" value="{{$edit->weight_per_item}}" class="form-control @error('title') is-invalid @enderror"
                       id="exampleInputEmail1" placeholder="Weight Per Item">
                      
                      @error('title')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Weight Per Carton</label>
                      <input type="number" name="weight_per_carton" value="{{$edit->weight_per_carton}}" class="form-control @error('title') is-invalid @enderror"
                       id="exampleInputEmail1" placeholder="Weight Per Carton">
                      
                      @error('title')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Product Image</label>
                      <input type="file" name="product_image" value="{{$edit->product_image}}" class="form-control @error('title') is-invalid @enderror"
                       id="exampleInputEmail1" placeholder="Upload Image">
                      
                      @error('title')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Date to be stored</label>
                      <input type="date" name="date_to_be_stored" value="{{$edit->date_to_be_stored}}" class="form-control @error('title') is-invalid @enderror"
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
                  <button type="submit" class="btn btn-primary">Update</button>
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