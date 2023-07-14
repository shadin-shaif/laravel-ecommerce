@extends('layouts.deshboard')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-primary my-3">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Product</a></li>
      <li class="breadcrumb-item active" aria-current="page">Add Product</li>
    </ol>
</nav>
<div>
    <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-header">
                <h4>Add New Product</h4>
            </div>
            <div class="card-body">
               <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="p-name" class="form-label">Product Name</label>
                        <input class="form-control" type="text" name="product_name" id="p-name" placeholder="Product Name">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="p-Price" class="form-label">Product Price</label>
                        <input class="form-control" type="number" name="price" id="p-Price" placeholder="Product Price">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="p-dis" class="form-label">Product Discount</label>
                        <input class="form-control" type="number" name="discount" id="p-dis" placeholder="Product Discount">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="category_id">Select Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="subcategory">Select subcategory</label>
                        <select name="subcategory_id" id="subcategory" class="form-control">
                            <option value="">-- Select Subcategory --</option>
                            @foreach ($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}">{{ $subcategory->subcategory_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="p-brand" class="form-label">Product Brand</label>
                        <select name="brand" class="form-control">
                            <option value="">-- Select Brand --</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="form-group">
                        <label for="short-des" class="form-label">Short Description</label>
                        <input class="form-control" type="text" name="short_description" id="short-des" placeholder="short description">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="summernote" class="form-label">Long Description</label>
                        <textarea class="form-control" id="summernote" name="long_description"></textarea>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="summernote2">Additional information</label>
                        <textarea id="summernote2" name="additional_info"></textarea>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="preview">Product Preview</label>
                        <input class="form-control" type="file" id="preview" name="preview" required></input>
                        @error('preview')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="gallery">Product Gallery</label>
                        <input class="form-control" multiple type="file" id="gallery" name="gallery[]"></input>
                    </div>
                </div>

                <div class="col-lg-6 m-auto">
                    <button type="submit" class="btn btn-primary form-control">Add Product</button>
                </div>
               </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('footer_script')
    <script>
        $(document).ready(function() {
        $('#summernote').summernote();
        $('#summernote2').summernote();
        });
    </script>
    <script>
        $('#category_id').change(function(){
            var category_id = $(this).val();
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                type:'POST',
                url:'/getsubcategory',
                data:{'category_id': category_id},//kiname jabe ke jabe
                
                success:function(data){
                    $('#subcategory').html(data)
                }
            });

        })

        
        
    </script>
@endsection