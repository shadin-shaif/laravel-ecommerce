@extends('layouts.deshboard')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-primary my-3">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Product</a></li>
      <li class="breadcrumb-item active" aria-current="page">Brand</li>
    </ol>
</nav>

<div class="row">
    @if ($brands->count() >= 1)
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4>List Of Brand</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Sl</th>
                        <th>Brand Name</th>
                        <th>Brand Image</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($brands as $sl=>$brand)
                        <tr>
                            <th>{{ $sl+1 }}</th>
                            <th>{{ $brand->brand_name }}</th>
                            <th>
                                @if ($brand->brand_image == null)
                                    <img width="55" src="{{ Avatar::create($brand->brand_name)->toBase64() }}" />
                                @else 
                                    <img width="55" src="{{ asset('uploads/brand') }}/{{ $brand->brand_image }}" alt="">
                                @endif
                                
                            </th>
                            <th>
                                <a href="#" class="btn btn-danger">Delete</a>
                                {{-- <div class="dropdown mb-2">
                                    <button class="btn p-0" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                    <a class="dropdown-item d-flex align-items-center" href=""><i data-feather="edit-2" class="icon-sm mr-2"></i> <span>Edit</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href=""><i data-feather="trash" class="icon-sm mr-2"></i> <span>Delete</span></a>
                                    </div>
                                </div> --}}
                            </th>
                        </tr>
                    @endforeach
                </table>
                {{ $brands->links() }}
            </div>
        </div>  
    </div>
    @endif

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4 class="pt-1">Add Product Brand</h4>
            </div>
            <div class="card-body">

                <form class="forms-sample" method="POST" enctype="multipart/form-data" action="{{ route('brand.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="Brand">Brand Name</label>
                        <input required type="text" class="form-control" name="brand_name" id="Brand" placeholder="Brand Name">
                        @error('brand_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image">Brand Image</label>
                        <input id="image" type="file" name="brand_logo" class="form-control">
                    </div>
                                   
                    <button type="submit" class="btn btn-primary">Add Brand</button>
                </form>
            </div>
          </div>
    </div>
  
</div>
@endsection

