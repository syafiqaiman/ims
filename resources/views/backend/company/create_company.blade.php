@extends('backend.layouts.app')
@section('content')
<title>Create Company</title>
<div class="card-body">
    <div class="row">

      <div class="col-md-2">

      </div>
                     <div class="col-md-8">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Company Detail</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{URL::to('/insert_company')}}" method="post" enctype="multipart/form-data">
              	@csrf
                <div class="card-body">


<div class="form-group">
<label for="exampleInputEmail1">Company Name</label>
<input type="text" name="company_name"  class="form-control @error('title') is-invalid @enderror"
 id="exampleInputEmail1" placeholder="Enter Company Name">

@error('title')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>

<div class="form-group">
<label for="exampleInputEmail1">Company Address</label>
<input type="text" name="address"  class="form-control @error('title') is-invalid @enderror"
 id="exampleInputEmail1" placeholder="Enter Company Address">

@error('title')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>

<div class="form-group">
  <label for="exampleInputEmail1">Phone Number</label>
  <input type="text" name="phone_number"  class="form-control @error('title') is-invalid @enderror"
   id="exampleInputEmail1" placeholder="Enter Phone Number">
  
  @error('title')
  <span class="invalid-feedback" role="alert">
  <strong>{{ $message }}</strong>
  </span>
  @enderror
  </div>

<div class="form-group">
    <label for="exampleInputEmail1">Company Email</label>
    <input type="text" name="email"  class="form-control @error('title') is-invalid @enderror"
     id="exampleInputEmail1" placeholder="Enter Company Email">
    
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