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
                <h3 class="card-title">Send Product</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{URL::to('/insert_product')}}" method="post" enctype="multipart/form-data">
              	@csrf
                <div class="card-body">     

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
   id="carton_quantity" placeholder="Enter Quantity">
  
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
  <label for="exampleInputEmail1">Weight Per Item (kg)</label>
  <<input type="text" name="weight_per_item"  class="form-control @error('title') is-invalid @enderror"
  id="weight_per_item" placeholder="Weight Per Item" step="0.1">
  @error('title')
  <span class="invalid-feedback" role="alert">
  <strong>{{ $message }}</strong>
  </span>
  @enderror
</div>

<div class="form-group">
  <label for="exampleInputEmail1">Weight Per Carton (kg)</label>
  <input type="text" name="weight_per_carton"  class="form-control @error('title') is-invalid @enderror"
   id="weight_per_carton" placeholder="Weight Per Carton" step="0.1">
  @error('title')
  <span class="invalid-feedback" role="alert">
  <strong>{{ $message }}</strong>
  </span>
  @enderror
</div>

<div class="form-group">
  <label for="exampleInputEmail1">Total Weight (kg)</label>
  <input type="text" name="total_weight" id="total_weight" class="form-control @error('title') is-invalid @enderror" readonly>
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

   const cartonQuantity = document.getElementById('carton_quantity');
  const weightPerCarton = document.getElementById('weight_per_carton');
  const totalWeightOutput = document.getElementById('total_weight');

  cartonQuantity.addEventListener('input', updateTotalWeight);
  weightPerCarton.addEventListener('input', updateTotalWeight);

  function updateTotalWeight() {
    const cartonQuantityValue = parseFloat(cartonQuantity.value) || 0;
    const weightPerCartonValue = parseFloat(weightPerCarton.value) || 0;
    const totalWeight = cartonQuantityValue * weightPerCartonValue;
    totalWeightOutput.value = totalWeight.toFixed(2);
  }
</script>

@endsection