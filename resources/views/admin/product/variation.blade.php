@extends('layouts.deshboard');
@section('content')
    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h4>Color List</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <table class="table table-bordered">
                        <tr>
                            <th>Color Name</th>
                            <th>Color Code</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($colors as $color)
                            
                            <tr>
                                <td>{{ $color->color_name }}</td>
                                <td><div class="badge d-block" style="background: {{ $color->color_code }}; height: 25px; width: 60px;"></div></td>
                                <td><a href="{{ route('delete.color',$color->id) }}" class="btn btn-danger">Delete</a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            <div class="row">
                @foreach ($categories as $categorie)
                    
                <div class="col-lg-6 my-3">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $categorie->category_name }}</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Size</th>
                                    <th>Action</th>
                                </tr>
                                @foreach (App\Models\Size::where('category_id', $categorie->id)->get() as $size)
                                <tr>
                                    <td>{{ $size->size_name }}</td>
                                    <td> {{ $size->category_id == null?'NA':$size->rel_to_cat->category_name }}</td>

                                    <td>
                                        <a href="{{ route('delete.size',$size->id) }}" class="btn btn-danger btn-icon">
                                            <i data-feather="trash"></i>
                                        </a>
                                    </td>

                                    
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>





        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h4>Add New Color</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('variation.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="color" class="form-label">Color Name</label>
                            <input type="text" class="form-control" name="color_name" id="color">
                        </div>
                        <div class="form-group">
                            <label for="color_code" class="form-label">Color Code</label>
                            <input type="text" class="form-control" name="color_code" id="color_code">
                        </div>
                        <div class="form-group">
                            <button name="btn" value="1" class="btn btn-primary">Add Color</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card my-4">
                <div class="card-header">
                    <h4>Add new Size</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('variation.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Select Category</label>
                            <select name="category_id">
                                <option value=" ">--Select Category--</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="size" class="form-label">Size Name</label>
                            <input type="text" class="form-control" name="size_name" id="size">
                        </div>
                        <div class="form-group">
                            <button name="btn" value="2" class="btn btn-primary">Add Size</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection