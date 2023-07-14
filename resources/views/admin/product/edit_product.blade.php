@extends('layouts.deshboard')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-primary">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Product</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
    </ol>
</nav>

<form action="{{ route('product.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-header">
            <h4>Edit Product</h4>
        </div>
        <div class="card-body">
           <div class="row">
            <input type="hidden" name="product_id" value="{{ $product_info->id }}">
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Product Name</label>
                    <input class="form-control" type="text" name="product_name" value="{{ $product_info->product_name }}">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="p-Price" class="form-label">Product Price</label>
                    <input class="form-control" type="number" name="price" id="p-Price" value="{{ $product_info->after_discount }}">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="p-dis" class="form-label">Product Discount</label>
                    <input class="form-control" type="number" name="discount" id="p-dis" value="{{ $product_info->discount }}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label" for="category_id">Select Category</label>
                    <select name="category_id" id="category_id" class="form-control">
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                            <option {{ $category->id == $product_info->category_id?'selected':'' }} value="{{ $category->id }}">{{ $category->category_name }}</option>
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
                            <option {{ $subcategory->id == $product_info->subcategory_id?'selected':'' }} value="{{ $subcategory->id }}">{{ $subcategory->subcategory_name }}</option>
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
                            <option {{ $brand->id == $product_info->brand?'selected':'' }} value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="form-group">
                    <label for="short-des" class="form-label">Short Description</label>
                    <input class="form-control" type="text" name="short_description" id="short-des" value="{{ $product_info->short_desp }}">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="summernote" class="form-label">Long Description</label>
                    <textarea class="form-control" id="summernote" name="long_description">{{ $product_info->long_desp }}</textarea>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="summernote2">Additional information</label>
                    <textarea id="summernote2" name="additional_info">{{ $product_info->additional_info }}</textarea>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label" for="preview">Product Preview</label>
                    <input class="form-control" type="file" id="preview" name="preview"></input>
                    <div class="my-2">
                        <img width="100" src="{{ asset('uploads/product/preview') }}/{{ $product_info->preview }}" alt="preview">
                    </div>
                    @error('preview')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label" for="gallery">Product Gallery</label>
                    <input class="form-control" multiple type="file" id="gallery" name="gallery[]"></input>
                    <div class="my-2">
                        @foreach ($gallery_imges as $gallery)
                            <img width="100" class="m-1" src="{{ asset('uploads/product/gallery') }}/{{ $gallery->gallery }}" alt="gallery">
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-6 m-auto">
                <button type="submit" class="btn btn-primary form-control">Update Product</button>
            </div>
           </div>
        </div>
    </div>
</form>
@endsection
@section('footer_script')
    <script>
        $(document).ready(function() {
        $('#summernote').summernote();
        $('#summernote2').summernote();
        });
    </script>

@endsection
