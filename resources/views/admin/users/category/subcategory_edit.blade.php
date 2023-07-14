@extends('layouts.deshboard')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-primary my-3">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Categorie</a></li>
      <li class="breadcrumb-item active" aria-current="page">Categories List</li>
    </ol>
</nav>



<div class="row">
    <div class="col-lg-6 m-auto">
        <div class="card">
            <div class="card-header">
                <h4>Edit Subcategory</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('subcategory.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="subcategory" class="form-label">Subcategory Name</label>
                        <input value="{{ $subcategory_info->subcategory_name }}" class="form-control" type="text" name="subcategory" id="subcategory">
                    </div>
                    <div class="form-group">
                        <label for="select">Select Category</label>
                        <select class="form-select" name="category_id" id="select">
                            @foreach ($categories as $category)
                                <option class="form-control" {{ $category->id == $subcategory_info->category_id?'selected':'' }} value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image">Sub Category Image</label>
                        <input type="file" name="subcategory_image" class="form-control" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        <div>
                            <img width="100" id="blah" src="{{ asset('uploads/subcategory') }}/{{ $subcategory_info->subcategory_image }}" alt="">
                        </div>
                        @error('category_image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- <input type="text" value="{{ $subcategory_info->id }}" name="id"> --}}
                    <button class="btn btn-info text-white">Update Subcategory</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection