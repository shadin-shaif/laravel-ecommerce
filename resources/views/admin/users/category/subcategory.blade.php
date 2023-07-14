@extends('layouts.deshboard')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-primary my-3">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Categorie</a></li>
      <li class="breadcrumb-item"><a href="#">Sub Categories</a></li>
    </ol>
</nav>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>List Of Subcategory</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Sl</th>
                            <th>Subcategory</th>
                            <th>Category</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($subcategory as $sl=>$subCategory)
                            <tr>
                                <th>{{ $sl+1 }}</th>
                                <th>{{ $subCategory->subcategory_name }}</th>
                                <th>{{ $subCategory->relation_to_category->category_name }}</th>
                                <th>
                                    <img width="55" src="{{ asset('uploads/subcategory') }}/{{ $subCategory->subcategory_image }}" alt="">
                                </th>
                                <th>
                                    <div class="dropdown mb-2">
                                        <button class="btn p-0" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                        <a class="dropdown-item d-flex align-items-center" href="{{ route('subcategory.edit',$subCategory->id) }}"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span>Edit</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="{{ route('subcategory.delete',$subCategory->id) }}"><i data-feather="trash" class="icon-sm mr-2"></i> <span>Delete</span></a>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>  
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4>Add Subcategory</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('subcategory.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="subcategory" class="form-label">Subcategory Name</label>
                            <input class="form-control" type="text" name="subcategory" id="subcategory">
                        </div>
                        <div class="form-group">
                            <label for="select">Select Category</label>
                            <select class="form-select" name="category_id" id="select">
                                <option value="">--Select Category --</option>
                                @foreach ($categories as $category)
                                    <option class="form-control" value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image">Sub Category Image</label>
                            <input type="file" name="subcategory_image" class="form-control" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                            <div>
                                <img width="100" id="blah" src="" alt="">
                            </div>
                            @error('category_image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button class="btn btn-info text-white">Add Subcategory</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-3">
        @foreach ($categories as $categorie)
            <div class="col-lg-6 my-2">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ $categorie->category_name }}</h4>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Subcategory Name</th>
                                <th>Subcategory Image</th>
                                <th>Action</th>
                            </tr>
                            @foreach (App\Models\Subcategory::where('category_id',$categorie->id)->get() as $subcategory_item)
                                <tr>
                                    <td>{{ $subcategory_item->subcategory_name }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection