{{-- @extends('layouts.deshboard');
@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Category</h4>
                </div>
                <div class="card-body">
                    @if (session('category_update'))
                        <div class="alert alert-success">{{ session('category_update') }}</div>
                    @endif
                    <form class="forms-sample" method="POST" enctype="multipart/form-data" action="{{ route('category.update') }}">
                        @csrf
                        <div class="form-group">
                            <label for="Category">Category Name</label>
                            <input type="text" name="category_name" class="form-control" value="{{ $category_info->category_name }}"  id="Category">
                            @error('category')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                                                 
                        <input type="hidden" name="category_id" value="{{ $category_info->id }}">               
                        <button type="submit" class="btn btn-primary mr-2">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection --}}

sidebar issues! need to fix