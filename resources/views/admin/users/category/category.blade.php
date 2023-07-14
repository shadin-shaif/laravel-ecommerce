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
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>List Of Categories</h3>
            </div>
            <div class="card-body">
                @if (session('category_dlt'))
                <div class="alert alert-success">{{ session('category_dlt') }}</div>
                @endif
                <form action="{{ route('check.delete') }}" method="post">
                    @csrf
                    <table class="table table-bordered">
                        <tr>
                            <th>
                                <input type="checkbox" id="chkSelectAll">
                                <label for="chkSelectAll">Check All</label>
                            </th>
                            <th>Sl</th>
                            <th>Category Name</th>
                            <th>Category Image</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($categories as $key=>$category)
                        <tr>
                            <td>
                                <input type="checkbox" class="chkDel" name="category_id[]" value="{{ $category->id }}">
                            </td>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $category->category_name }}</td>
                            <td><img width="70" src="{{ asset('uploads/category') }}/{{ $category->category_image }}" alt=""></td>
                            <td>

                                <div class="dropdown mb-2">
                                    <button class="btn p-0" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('category.edit',$category->id) }}"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('category.delete', $category->id) }}"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
                                    </div>
                                </div>

                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <button class="btn btn-danger my-3 dlt_btn">Deleted Checked</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4 class="pt-1">Add Category</h4>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form class="forms-sample" method="POST" enctype="multipart/form-data" action="{{ route('category.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="Category">Category Name</label>
                        <input type="text" class="form-control" name="category" id="Category" placeholder="Category Name">
                        @error('category')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image">Category Image</label>
                        <input id="image" type="file" name="category_image" class="form-control" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        <div>
                            <img width="100" id="blah" src="" alt="">
                        </div>
                        @error('category_image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                                   
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                </form>
            </div>
          </div>
    </div>
  </div>

@if ($trash_category->count() >= 1)
<div class="row my-5">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Trash Category</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('category.trash') }}" method="post">
                    @csrf
                    <table class="table table-bordered">
                        <tr>
                            <th>
                                <input type="checkbox"  id="chkSelectTrash">
                                <label for="chkSelectTrash">Check All</label>
                            </th>
                            <th>Sl</th>
                            <th>Category Name</th>
                            <th>Category Image</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($trash_category as $key=>$trash)
                        <tr>
                            <td>
                                <input type="checkbox" class="chkDelTrash" name="category_id[]" value="{{ $trash->id }}">
                            </td>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $trash->category_name }}</td>
                            <td><img width="70" src="{{ asset('uploads/category') }}/{{ $trash->category_image }}" alt=""></td>
                            <td>
                                <div class="dropdown mb-2">
                                    <button class="btn p-0" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('category.restor',$trash->id) }}"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span>Restor</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('category.dlt', $trash->id) }}"><i data-feather="trash" class="icon-sm mr-2"></i> <span>Permanent Delete</span></a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <button class="btn btn-danger my-3" type="submit" name="action" value="delete">Delete All</button>
                    <button class="btn btn-info my-3" type="submit" name="action" value="restore">Restore All</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('footer_script')
<script>

$("#chkSelectAll").on('click', function(){
    this.checked ? $(".chkDel").prop("checked",true) : $(".chkDel").prop("checked",false);  
})

$("#chkSelectTrash").on('click', function(){
    this.checked ? $(".chkDelTrash").prop("checked",true) : $(".chkDelTrash").prop("checked",false);  
})
</script>
@endsection